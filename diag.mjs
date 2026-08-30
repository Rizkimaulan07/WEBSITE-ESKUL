import puppeteer from 'puppeteer-core';

const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];

const browser = await puppeteer.launch({
  executablePath: EDGE,
  headless: "new",
  args: ["--no-sandbox", "--disable-gpu", "--window-size=1440,1000"],
  userDataDir: "C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile",
});
const page = await browser.newPage();
await page.setViewport({ width: 1440, height: 1000 });
await page.goto(url, { waitUntil: "networkidle0", timeout: 30000 });

const report = await page.evaluate(() => {
  const vw = window.innerWidth;
  const vh = window.innerHeight;
  const docW = document.documentElement.scrollWidth;
  const docH = document.documentElement.scrollHeight;
  const out = [];
  out.push(`VIEWPORT=${vw}x${vh} DOC=(${docW}x${docH}) HORIZONTAL_OVERFLOW=${docW > vw ? docW - vw : 0}`);

  const rect = (el) => {
    if (!el) return null;
    const r = el.getBoundingClientRect();
    return `${Math.round(r.x)},${Math.round(r.y)} ${Math.round(r.width)}x${Math.round(r.height)}`;
  };
  const info = (label, el) => {
    if (!el) { out.push(`  ${label}: (none)`); return; }
    const cs = getComputedStyle(el);
    out.push(`  ${label}: rect=${rect(el)} display=${cs.display} pos=${cs.position} flexDir=${cs.flexDirection} justify=${cs.justifyContent} align=${cs.alignItems} gap=${cs.gap}`);
  };

  out.push(`--- SIDEBAR ---`);
  info('sidebar', document.querySelector('.sidebar, aside, [class*=sidebar]'));

  out.push(`--- MAIN CONTENT ---`);
  info('main-content', document.querySelector('.main-content, main, .content, [class*=content]'));

  out.push(`--- TOPBAR ---`);
  info('topbar', document.querySelector('.topbar, [class*=topbar], header'));

  out.push(`--- STAT/CARDS ---`);
  const cards = document.querySelectorAll('.stat-card, [class*=stat], [class*=card]');
  out.push(`  count=${cards.length}`);
  let i = 0;
  for (const c of cards) {
    if (i > 8) break;
    const cs = getComputedStyle(c);
    out.push(`  card[${i}] class="${c.className}" rect=${rect(c)} disp=${cs.display} flexDir=${cs.flexDirection} gap=${cs.gap} grid=${cs.gridTemplateColumns}`);
    i++;
  }

  out.push(`--- HERO/CONTAINER/ROW ---`);
  info('hero/container', document.querySelector('.hero, [class*=hero], .page-header, .dashboard-content, .container, .row, .page-title'));

  out.push(`--- BODY TOP-LEVEL ---`);
  for (const ch of document.body.children) {
    const cs = getComputedStyle(ch);
    out.push(`  body>${ch.tagName.toLowerCase()} class="${ch.className}" rect=${rect(ch)} disp=${cs.display}`);
  }

  return out.join("\n");
});

console.log(report);
await browser.close();
