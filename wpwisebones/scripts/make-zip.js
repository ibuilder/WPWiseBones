/**
 * make-zip.js
 * Creates a distributable wpwisebones.zip in the parent directory,
 * excluding everything listed in .distignore.
 * Run: npm run zip
 * Requires: npm install archiver --save-dev  (one-time)
 */

const fs      = require('fs');
const path    = require('path');
const { execSync } = require('child_process');

const ROOT     = path.resolve(__dirname, '..');
const THEME    = path.basename(ROOT);
const OUTFILE  = path.join(ROOT, '..', `${THEME}.zip`);
const IGNORE_FILE = path.join(ROOT, '.distignore');

// Read .distignore and expand each pattern so archiver glob matches
// subdirectories too (e.g. "node_modules" → also "node_modules/**")
const rawIgnore = fs.existsSync(IGNORE_FILE)
    ? fs.readFileSync(IGNORE_FILE, 'utf8').split('\n').map(l => l.trim()).filter(l => l && !l.startsWith('#'))
    : [];

const ignorePatterns = [];
for (const p of rawIgnore) {
    ignorePatterns.push(p);
    // Also match all contents inside directories
    if (!p.includes('*')) {
        ignorePatterns.push(`${p}/**`);
        ignorePatterns.push(`**/${p}`);
        ignorePatterns.push(`**/${p}/**`);
    }
}

// Try to use archiver if available, else fall back to PowerShell Compress-Archive
try {
    require.resolve('archiver');
} catch {
    console.log('archiver not found â€” using system zip fallback.');
    useFallback();
    process.exit(0);
}

const archiver = require('archiver');
const output   = fs.createWriteStream(OUTFILE);
const archive  = archiver('zip', { zlib: { level: 9 } });

output.on('close', () => {
    const mb = (archive.pointer() / 1024 / 1024).toFixed(2);
    console.log(`\nâœ”  ${OUTFILE} (${mb} MB)`);
});
archive.on('error', e => { throw e; });
archive.pipe(output);

archive.glob('**/*', {
    cwd: ROOT,
    ignore: ignorePatterns,
    dot: true,
}, { prefix: THEME });

archive.finalize();

function useFallback() {
    // PowerShell Compress-Archive fallback (Windows)
    const excludeStr = ignorePatterns.map(p => `"${path.join(ROOT, p)}"`).join(',');
    try {
        execSync(
            `powershell -Command "Compress-Archive -Path '${ROOT}' -DestinationPath '${OUTFILE}' -Force"`,
            { stdio: 'inherit' }
        );
        console.log(`âœ”  ${OUTFILE}`);
    } catch (e) {
        console.error('Zip failed:', e.message);
        process.exit(1);
    }
}
