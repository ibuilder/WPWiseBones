#!/usr/bin/env bash
# Builds installable zips for the child theme library and the Industry Kit.
#
#   tools/build-library.sh            # every theme in child-themes/ + the kit
#   tools/build-library.sh wisebones-trades wisebones-residential
#
# Each zip holds one top-level folder named after the theme slug, which is what
# Appearance -> Themes -> Upload expects. Output goes to dist/ (git-ignored).
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
out="$root/dist"
mkdir -p "$out"

if [ "$#" -gt 0 ]; then
	slugs=("$@")
else
	slugs=()
	for dir in "$root"/child-themes/*/; do
		[ -f "$dir/style.css" ] && slugs+=("$(basename "$dir")")
	done
fi

pack() { # pack <source-dir> <slug>
	local src="$1" slug="$2" stage
	stage="$(mktemp -d)"
	cp -R "$src" "$stage/$slug"
	# Repository-only files never ship.
	find "$stage/$slug" \( -name 'README.md' -o -name '.distignore' -o -name '.DS_Store' \) -prune -exec rm -rf {} +
	rm -f "$out/$slug.zip"
	(cd "$stage" && zip -qr "$out/$slug.zip" "$slug")
	rm -rf "$stage"
	echo "  $slug.zip"
}

echo "Building into dist/:"
for slug in "${slugs[@]}"; do
	[ -d "$root/child-themes/$slug" ] || { echo "no such theme: $slug" >&2; exit 1; }
	pack "$root/child-themes/$slug" "$slug"
done
[ "$#" -gt 0 ] || pack "$root/wisebones-industry-kit" "wisebones-industry-kit"
