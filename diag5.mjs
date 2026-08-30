import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.goto(url,{waitUntil:"load",timeout:30000});
const html = await page.content();
const markers = ['--sidebar-width','.sidebar {','.main-content {',':root','--bg-main','stat-card','hero-gradient','ANIMATIONS'];
for(const m of markers){
  const n = html.split(m).length-1;
  console.log(`marker "${m}": ${n}`);
}
console.log("html length:", html.length);
await browser.close();
