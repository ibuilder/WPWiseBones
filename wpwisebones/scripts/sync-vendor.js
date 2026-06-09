/**
 * sync-vendor.js
 * Copies Bootstrap & Bootstrap Icons from node_modules into assets/vendor/
 * Run: npm run sync
 */

const fs   = require('fs');
const path = require('path');

const ROOT   = path.resolve(__dirname, '..');
const NM     = path.join(ROOT, 'node_modules');
const VENDOR = path.join(ROOT, 'assets', 'vendor');

const copies = [
    // [ source, dest ]
    [ path.join(NM, 'bootstrap/dist/css/bootstrap.min.css'),          path.join(VENDOR, 'css/bootstrap.min.css') ],
    [ path.join(NM, 'bootstrap/dist/css/bootstrap.min.css.map'),      path.join(VENDOR, 'css/bootstrap.min.css.map') ],
    [ path.join(NM, 'bootstrap/dist/js/bootstrap.bundle.min.js'),     path.join(VENDOR, 'js/bootstrap.bundle.min.js') ],
    [ path.join(NM, 'bootstrap/dist/js/bootstrap.bundle.min.js.map'), path.join(VENDOR, 'js/bootstrap.bundle.min.js.map') ],
    [ path.join(NM, 'bootstrap-icons/font/bootstrap-icons.min.css'),  path.join(VENDOR, 'css/bootstrap-icons.min.css') ],
    [ path.join(NM, 'bootstrap-icons/font/fonts/bootstrap-icons.woff'),  path.join(VENDOR, 'fonts/bootstrap-icons.woff') ],
    [ path.join(NM, 'bootstrap-icons/font/fonts/bootstrap-icons.woff2'), path.join(VENDOR, 'fonts/bootstrap-icons.woff2') ],
];

// Ensure directories exist
['css','js','fonts'].forEach(d => fs.mkdirSync(path.join(VENDOR, d), { recursive: true }));

let ok = 0, fail = 0;
for (const [src, dest] of copies) {
    try {
        fs.copyFileSync(src, dest);
        console.log(`✔  ${path.relative(ROOT, dest)}`);
        ok++;
    } catch (e) {
        console.error(`✘  ${path.relative(ROOT, src)} — ${e.message}`);
        fail++;
    }
}

console.log(`\n${ok} file(s) synced${fail ? `, ${fail} failed` : ''}.`);
if (fail) process.exit(1);
