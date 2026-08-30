import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.goto(url,{waitUntil:"load",timeout:30000});
const ctx = await page.evaluate(()=>{
  const out=[];
  const get=(s)=>{const e=document.querySelector(s); const r=e?e.getBoundingClientRect():null; return r?`${Math.round(r.x)},${Math.round(r.y)} ${Math.round(r.width)}x${Math.round(r.height)}`:"(none)"};
  out.push("SIDEBAR rect: "+get('.sidebar'));
  out.push("Style tags: "+document.querySelectorAll('style').length);
  return out.join("\n");
});
console.log(ctx);
// now raw: get the position immediately after <head> to see dumped CSS
const info = await page.evaluate(()=>{
  const bodyText = document.body.innerText.slice(0,1500);
  return "BODY TEXT START:\n" + bodyText;
});
console.log(info);
await browser.close();
