import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.goto(url,{waitUntil:"load",timeout:30000});
const info = await page.evaluate(()=>{
  const out=[];
  for(const s of document.styleSheets){
    let rules=-1, first="";
    try{ rules=s.cssRules.length; if(rules>0){ first=s.cssRules[0].cssText?.slice(0,80)||""; } }catch(e){ rules=-1; }
    out.push(`STYLESHEET href=${s.href||"(inline)"} ownerTag=${s.ownerNode.tagName} rules=${rules} first="${first}"`);
  }
  // list link tags
  out.push("--- <link rel=stylesheet> ---");
  for(const l of document.querySelectorAll('link[rel=stylesheet]')){
    out.push("  link href="+l.href+" media="+(l.media||""));
  }
  // list style tags with lengths
  out.push("--- <style> tags ---");
  let i=0;
  for(const st of document.querySelectorAll('style')){
    out.push(`  style[${i}] len=${st.textContent.length} start="${st.textContent.slice(0,60).replace(/\n/g,' ')}"`);
    i++;
  }
  return out.join("\n");
});
console.log(info);
await browser.close();
