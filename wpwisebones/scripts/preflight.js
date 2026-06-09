/**
 * preflight.js — WPWiseBones
 * Production readiness checker. Run: npm run preflight
 * https://wprealwise.com
 */

"use strict";
const fs   = require("fs");
const path = require("path");

const ROOT    = path.resolve(__dirname, "..");
const STYLE   = path.join(ROOT, "style.css");
const DOMAIN  = "wpwisebones";
const POT     = path.join(ROOT, `languages/${DOMAIN}.pot`);

let errors = 0, warnings = 0;
const err  = m => { console.error(`  X ERROR:   ${m}`); errors++;   };
const warn = m => { console.warn( `  ! WARN:    ${m}`); warnings++; };
const ok   = m =>   console.log(  `  OK:        ${m}`);

console.log("\n  WPWiseBones -- Production Preflight");
console.log("  wprealwise.com\n");

// 1. Required files
console.log("[ Required Files ]");
[
    "style.css","index.php","functions.php","header.php","footer.php",
    "sidebar.php","comments.php","screenshot.png","searchform.php",
    "single.php","page.php","archive.php","search.php","404.php",
    "attachment.php","author.php","category.php","tag.php","date.php",
    "home.php","singular.php","taxonomy.php",
    "inc/setup.php","inc/enqueue.php","inc/customizer.php",
    "inc/seo.php","inc/woocommerce.php","inc/ajax-handlers.php",
    "inc/admin/admin-page.php","inc/admin/meta-boxes.php",
    "languages/" + DOMAIN + ".pot",
    "assets/vendor/css/bootstrap.min.css",
    "assets/vendor/js/bootstrap.bundle.min.js",
    "assets/vendor/css/bootstrap-icons.min.css",
    "assets/vendor/fonts/bootstrap-icons.woff2",
    "theme.json",
].forEach(f => {
    fs.existsSync(path.join(ROOT, f)) ? ok(f) : err("Missing: " + f);
});

// 2. style.css header
console.log("\n[ style.css Header ]");
const style = fs.readFileSync(STYLE, "utf8");
const fields = {
    "Theme Name": /Theme Name:\s*(.+)/,
    "Theme URI":  /Theme URI:\s*(.+)/,
    "Version":    /Version:\s*(.+)/,
    "Author":     /Author:\s*(.+)/,
    "Author URI": /Author URI:\s*(.+)/,
    "Text Domain":/Text Domain:\s*(.+)/,
    "License":    /License:\s*(.+)/,
};
for (const [f, rx] of Object.entries(fields)) {
    const m = style.match(rx);
    m && m[1].trim() ? ok(f + ": " + m[1].trim()) : err("Missing style.css header: " + f);
}
const td = style.match(/Text Domain:\s*(.+)/);
if (td && td[1].trim() !== DOMAIN) err("Text domain mismatch: " + td[1].trim());
const au = style.match(/Author URI:\s*(.+)/);
if (au && !au[1].includes("wprealwise.com")) warn("Author URI should point to wprealwise.com");

// 3. Screenshot
console.log("\n[ Screenshot ]");
const ss = path.join(ROOT, "screenshot.png");
if (fs.existsSync(ss)) {
    const sz = fs.statSync(ss).size;
    sz < 1000 ? warn("screenshot.png is very small") : ok("screenshot.png (" + (sz/1024).toFixed(1) + " KB)");
} else err("screenshot.png missing");

// 4. ABSPATH guards
console.log("\n[ Security ]");
const topLevel = new Set([
    "index.php","single.php","page.php","archive.php","search.php","404.php",
    "header.php","footer.php","sidebar.php","comments.php","functions.php",
    "screenshot.php","attachment.php","author.php","category.php","tag.php",
    "date.php","home.php","singular.php","taxonomy.php","searchform.php",
]);
let guardOk = 0, guardFail = [];
function collectPhp(dir, isRoot) {
    for (const e of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, e.name);
        if (e.isDirectory() && !["node_modules",".git","assets"].includes(e.name)) collectPhp(full, false);
        else if (e.isFile() && e.name.endsWith(".php") && e.name !== "index.php") {
            if (isRoot && topLevel.has(e.name)) continue;
            /defined\s*\(\s*['"]ABSPATH['"]/.test(fs.readFileSync(full,"utf8")) ? guardOk++ : guardFail.push(path.relative(ROOT,full));
        }
    }
}
collectPhp(ROOT, true);
ok(guardOk + " files have ABSPATH guard");
guardFail.forEach(f => warn("No guard: " + f));

// 5. Function prefix
console.log("\n[ Function Prefix ]");
let pfxErr = 0;
const allPhp = [];
function collectAll(dir) {
    for (const e of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, e.name);
        if (e.isDirectory() && !["node_modules",".git"].includes(e.name)) collectAll(full);
        else if (e.isFile() && e.name.endsWith(".php")) allPhp.push(full);
    }
}
collectAll(ROOT);
for (const f of allPhp) {
    const src = fs.readFileSync(f,"utf8");
    if (/function\s+bsk_\w+/.test(src)) { warn("Old bsk_ function in " + path.relative(ROOT,f)); pfxErr++; }
}
if (!pfxErr) ok("All functions use wpb_ prefix");

// 6. Text domain
console.log("\n[ Text Domain ]");
let dmErr = 0;
for (const f of allPhp) {
    const src = fs.readFileSync(f,"utf8");
    const w = src.match(/__\(\s*[""][^""]+[""]\s*,\s*[""](?!wpwisebones)[^""]+[""]\s*\)/g);
    if (w) { warn("Wrong domain in " + path.relative(ROOT,f) + ": " + w[0]); dmErr++; }
}
if (!dmErr) ok("All __() calls use correct domain");

// 7. Vendor assets
console.log("\n[ Vendor Assets ]");
["assets/vendor/css/bootstrap.min.css","assets/vendor/js/bootstrap.bundle.min.js",
 "assets/vendor/css/bootstrap-icons.min.css","assets/vendor/fonts/bootstrap-icons.woff2"
].forEach(f => {
    const full = path.join(ROOT, f);
    fs.existsSync(full) ? ok(f + " (" + (fs.statSync(full).size/1024).toFixed(0) + " KB)") : err("Missing: " + f);
});

// 8. theme.json
console.log("\n[ Block Editor ]");
const tj = path.join(ROOT,"theme.json");
if (fs.existsSync(tj)) {
    try { const d = JSON.parse(fs.readFileSync(tj,"utf8")); ok("theme.json valid (v" + d.version + ")"); }
    catch(e) { err("theme.json invalid JSON: " + e.message); }
} else err("theme.json missing");

// 9. SEO
console.log("\n[ SEO Module ]");
const seoFile = path.join(ROOT,"inc/seo.php");
if (fs.existsSync(seoFile)) {
    const s = fs.readFileSync(seoFile,"utf8");
    ["og:title","twitter:card","schema.org","canonical"].every(t => s.includes(t))
        ? ok("Open Graph + Twitter Card + Schema.org + Canonical all present")
        : warn("SEO module incomplete");
} else err("inc/seo.php missing");

// 10. WooCommerce
console.log("\n[ WooCommerce ]");
const wooFile = path.join(ROOT,"inc/woocommerce.php");
if (fs.existsSync(wooFile)) {
    /woocommerce_before_main_content/.test(fs.readFileSync(wooFile,"utf8"))
        ? ok("WooCommerce hooks present") : warn("WooCommerce may be incomplete");
} else err("inc/woocommerce.php missing");

// 11. POT
console.log("\n[ Translation ]");
if (fs.existsSync(POT)) {
    const potSrc = fs.readFileSync(POT,"utf8");
    const n = (potSrc.match(/^msgid\s+"/gm)||[]).length;
    n > 50 ? ok(".pot file: " + n + " strings") : warn(".pot only " + n + " strings — run: npm run pot");
} else err(".pot missing — run: npm run pot");

// 12. WPWiseBones credits
console.log("\n[ WPWiseBones Branding ]");
const ap = fs.readFileSync(path.join(ROOT,"inc/admin/admin-page.php"),"utf8");
/wprealwise\.com/i.test(ap) ? ok("wprealwise.com credit in admin page") : warn("Credit missing from admin page");
/wprealwise\.com/i.test(style) ? ok("wprealwise.com in style.css") : warn("wprealwise.com not in style.css");


// 13b. LICENSE file
console.log("\n[ License ]");
["license.txt","LICENSE","LICENSE.txt","LICENSE.md"].some(n => fs.existsSync(path.join(ROOT,n)))
    ? ok("license.txt present")
    : err("No license file found — required for WordPress.org");

// 13c. Dashboard widget
console.log("\n[ Dashboard Widget ]");
const dw = path.join(ROOT,"inc/dashboard-widget.php");
if (fs.existsSync(dw)) {
    /wp_add_dashboard_widget/.test(fs.readFileSync(dw,"utf8"))
        ? ok("Dashboard widget registered") : warn("inc/dashboard-widget.php exists but widget not registered");
} else err("inc/dashboard-widget.php missing");

// 13d. Folder name warning
console.log("\n[ Folder Name ]");
const folderName = path.basename(ROOT);
const domainFromStyle = (fs.readFileSync(path.join(ROOT,"style.css"),"utf8").match(/Text Domain:\s*(.+)/) || [])[1];
if (domainFromStyle && folderName !== domainFromStyle.trim()) {
    warn("Folder name '" + folderName + "' != text domain '" + domainFromStyle.trim() + "' — rename folder before installing");
} else {
    ok("Folder name matches text domain: " + folderName);
}
// Summary
console.log("\n  Errors: " + errors + "  Warnings: " + warnings + "\n");
if (errors > 0) { console.error("X FAILED\n"); process.exit(1); }
else if (warnings > 0) console.warn("! PASSED with warnings\n");
else console.log("OK ALL CHECKS PASSED -- production ready\n");
