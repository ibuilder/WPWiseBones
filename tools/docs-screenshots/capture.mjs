/**
 * Screenshots the rendered pages produced by render.php into the docs site.
 *
 * Usage: node capture.mjs <build-dir> <docs-img-dir>
 */
import { chromium } from 'playwright';
import { mkdir, readFile } from 'node:fs/promises';
import { pathToFileURL } from 'node:url';
import path from 'node:path';

const [buildDir, outDir] = process.argv.slice(2);
if (!buildDir || !outDir) {
  console.error('Usage: node capture.mjs <build-dir> <docs-img-dir>');
  process.exit(1);
}
await mkdir(outDir, { recursive: true });

const executablePath = process.env.CHROMIUM_PATH || '/opt/pw-browsers/chromium';
const browser = await chromium.launch({ executablePath });

async function shootPage(file, name, { width = 1440, height = 900, full = false, scale = 2 } = {}) {
  // reducedMotion makes the themes' own prefers-reduced-motion rules disable the
  // scroll-reveal animations, so off-screen sections are captured fully visible.
  const page = await browser.newPage({
    viewport: { width, height },
    deviceScaleFactor: scale,
    reducedMotion: 'reduce',
  });
  await page.goto(pathToFileURL(path.join(buildDir, file)).href, { waitUntil: 'load' });
  await page.waitForTimeout(500);
  await page.screenshot({ path: path.join(outDir, `${name}.png`), fullPage: full });
  await page.close();
  console.log(`  ${name}.png`);
}

async function shootElements(file, { width = 1000 } = {}) {
  const page = await browser.newPage({ viewport: { width, height: 900 }, deviceScaleFactor: 2 });
  await page.goto(pathToFileURL(path.join(buildDir, file)).href, { waitUntil: 'load' });
  await page.waitForTimeout(600);
  const slugs = await page.$$eval('.shot', (els) => els.map((el) => el.dataset.slug));
  for (const slug of slugs) {
    const el = await page.$(`#shot-${slug}`);
    // Modals render hidden; open the one on this card before shooting it.
    if (slug === 'modal') {
      await el.evaluate((node) => {
        const dialog = node.querySelector('.modal');
        if (dialog) {
          dialog.classList.add('show');
          dialog.style.display = 'block';
          dialog.style.position = 'static';
          dialog.style.marginTop = '1rem';
        }
      });
      await page.waitForTimeout(200);
    }
    await el.screenshot({ path: path.join(outDir, `sc-${slug}.png`) });
    console.log(`  sc-${slug}.png`);
  }
  await page.close();
}

const themes = ['wpwisebones', 'realwise', 'aec-forge'];

console.log('Theme pages (above the fold):');
for (const theme of themes) {
  await shootPage(`theme-${theme}.html`, `theme-${theme}`, { height: 940 });
}

console.log('Theme pages (full length):');
for (const theme of themes) {
  await shootPage(`theme-${theme}.html`, `theme-${theme}-full`, { full: true, scale: 1 });
}

console.log('Theme pages (mobile):');
for (const theme of themes) {
  await shootPage(`theme-${theme}.html`, `theme-${theme}-mobile`, { width: 414, height: 860 });
}

console.log('Shortcodes:');
await shootElements('shortcodes.html');

await browser.close();
console.log('Done.');
