import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.goto(url,{waitUntil:"load",timeout:30000});
const html = await page.content();
const idxs = [];
let re=/<style|<\/style/gi, m;
while((m=re.exec(html))){ idxs.push({i:m.index, t:m[0]}); }
for(const o of idxs){
  const start=Math.max(0,o.i-120);
  const seg=html.slice(start,o.i+40).replace(/\n/g,' ');
  console.log(`[${o.i}] ${o.t} ... ${seg.slice(-160)}`);
}
console.log("HTML LEN:", html.length);
await browser.close();
