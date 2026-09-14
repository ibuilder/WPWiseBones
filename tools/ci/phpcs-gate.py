#!/usr/bin/env python3
"""Turn a PHPCS JSON report into a build verdict.

A ruleset that matches no files reports zero findings and looks exactly like a
clean run, and phpcs writes no report at all when it cannot start. Both would
otherwise pass as green, so every state that is not "phpcs ran and judged real
files" fails here instead.

Usage: phpcs-gate.py <label> <report.json>
Exit status: 0 no errors, 1 errors found or the report could not be trusted.
"""

import json
import os
import sys


def main(argv):
    if len(argv) < 3:
        print('usage: phpcs-gate.py <label> <report.json>')
        return 2

    label, path = argv[1], argv[2]

    if not os.path.exists(path) or os.path.getsize(path) == 0:
        print('::error::%s: phpcs produced no report — it did not run.' % label)
        return 1

    try:
        with open(path, encoding='utf-8') as handle:
            report = json.load(handle)
    except ValueError as exc:
        print('::error::%s: phpcs report is not valid JSON (%s) — it did not '
              'run cleanly.' % (label, exc))
        return 1

    try:
        files = report['files']
        totals = report['totals']
    except (KeyError, TypeError):
        print('::error::%s: phpcs report is missing files/totals — the report '
              'format changed.' % label)
        return 1

    scanned = len(files)
    print('%s: %d file(s) scanned, %d error(s), %d warning(s)'
          % (label, scanned, totals['errors'], totals['warnings']))

    if scanned == 0:
        print('::error::%s: the ruleset matched no files — it is not actually '
              'checking anything.' % label)
        return 1

    for name, data in files.items():
        for message in data['messages']:
            level = 'error' if message['type'] == 'ERROR' else 'warning'
            print('::%s file=%s,line=%s::%s: %s'
                  % (level, name, message['line'], message['source'],
                     message['message']))

    return 1 if totals['errors'] else 0


if __name__ == '__main__':
    sys.exit(main(sys.argv))
