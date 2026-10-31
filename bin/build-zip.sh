#!/usr/bin/env bash
# Package the theme as starvion.zip, ready for Appearance > Themes > Add New > Upload.
set -euo pipefail
cd "$(dirname "$0")/.."
rm -f starvion.zip
zip -rq starvion.zip starvion -x '*.DS_Store'
echo "Built starvion.zip"
