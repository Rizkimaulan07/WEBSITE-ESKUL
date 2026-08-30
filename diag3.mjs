import puppeteer from 'puppeteer-core';
import postcss from 'postcss';

const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.goto(url,{waitUntil:"load",timeout:30000});
const style = await page.evaluate(()=>{
  for(const s of document.styleSheets){
    if(s.href==null){
      let txt='';
      for(const r of s.cssRules){ txt+=r.cssText+"\n"; }
      return {len:txt.length, screenshot:txt.slice(0,200)};
    }
  }
  return null;
});
console.log("INLINE RULES PARSED:", style ? style.len : "none");
console.log("first parsed:", style ? style.screenshot : "");

// Now grab raw <style> text from HTML
const html = await page.content();
const m = html.match(/<style>([\s\S]*?)<\/style>/);
const raw = m ? m[1] : "";
console.log("raw style length:", raw.length);
const result = await postcss().process(raw, {from:"inline"});
const errs = result.warnings();
if (errs.length===0) console.log("POSTCSS: no errors/warnings");
for (const e of errs) console.log("POSTCSS ERR:", e.toString());
await browser.close();
