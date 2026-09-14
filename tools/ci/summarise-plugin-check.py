#!/usr/bin/env python3
"""Summarise a Plugin Check report and decide whether the build passes.

Plugin Check does not emit one document. It prints a ``FILE: <path>`` header
followed by a single-line JSON array of findings, once per file, and prints
nothing but a success line when the plugin is clean. Feeding that to a plain
CSV or JSON reader silently yields zero findings, which looks exactly like a
pass -- so every branch below that cannot account for the output fails loudly
instead of reporting a clean run.

Usage: summarise-plugin-check.py <slug> <report> [stderr]
Exit status: 0 no errors, 1 errors found or the report could not be read.
"""

import collections
import json
import os
import sys

CLEAN_MARKER = 'No errors found'


def read(path):
    if not path or not os.path.exists(path):
        return ''
    with open(path, encoding='utf-8', errors='replace') as handle:
        return handle.read()


def parse(text):
    """Return (rows, section_count, unparsed_section_count)."""
    rows = []
    sections = 0
    unparsed = 0
    current = None
    for line in text.splitlines():
        line = line.strip()
        if line.startswith('FILE:'):
            sections += 1
            current = line[5:].strip()
        elif line.startswith('['):
            try:
                items = json.loads(line)
            except ValueError:
                unparsed += 1
                continue
            for item in items:
                if not isinstance(item, dict):
                    unparsed += 1
                    continue
                if not item.get('file'):
                    item['file'] = current
                rows.append(item)
    return rows, sections, unparsed


def fail(message, *details):
    print('::error::' + message)
    for block in details:
        if block.strip():
            print(block[:4000])
    return 1


def main(argv):
    if len(argv) < 3:
        print('usage: summarise-plugin-check.py <slug> <report> [stderr]')
        return 2

    slug, report_path = argv[1], argv[2]
    stderr_path = argv[3] if len(argv) > 3 else None
    text = read(report_path)
    stderr = read(stderr_path)
    clean = CLEAN_MARKER in text

    if not text.strip():
        return fail(
            'Plugin Check produced no output at all -- it failed to run.', stderr)

    rows, sections, unparsed = parse(text)

    if unparsed:
        return fail(
            '%d section(s) of the Plugin Check report could not be read -- '
            'the report format has changed.' % unparsed, text)

    if sections and not rows:
        return fail(
            'Plugin Check reported findings but none could be read -- '
            'the report format has changed.', text)

    if not sections and not clean:
        return fail(
            'Plugin Check output matched neither a clean run nor a findings '
            'report -- refusing to call this a pass.', text, stderr)

    # Every finding carries a severity. A blank one means the fields were not
    # read correctly, which would under-report errors as zero.
    typeless = [r for r in rows if not str(r.get('type') or '').strip()]
    if typeless:
        return fail(
            '%d finding(s) carry no severity -- the fields were not read '
            'correctly.' % len(typeless), text)

    counts = collections.Counter(
        (str(r.get('type')), str(r.get('code'))) for r in rows)
    for (kind, code), count in counts.most_common():
        print('%4d  %-8s  %s' % (count, kind, code))

    errors = [r for r in rows if str(r.get('type')).upper() == 'ERROR']
    for row in errors:
        print('::error file=%s/%s,line=%s::%s: %s' % (
            slug, row.get('file'), row.get('line') or 0,
            row.get('code'), row.get('message')))

    print('\n%d finding(s), %d error(s)' % (len(rows), len(errors)))
    return 1 if errors else 0


if __name__ == '__main__':
    sys.exit(main(sys.argv))
