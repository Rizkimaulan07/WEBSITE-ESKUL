import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu","--window-size=1440,1000"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.setViewport({width:1440,height:1000});
await page.goto(url,{waitUntil:"networkidle0",timeout:30000});
await page.evaluate(()=>window.scrollTo(0,0));
const r = await page.evaluate(()=>{
  const out=[];
  const cs=(s)=>getComputedStyle(document.querySelector(s));
  out.push("root --bg-main: "+cs(":root").getPropertyValue('--bg-main'));
  out.push("root --sidebar-width: "+cs(":root").getPropertyValue('--sidebar-width'));
  const ss=cs('.sidebar');
  out.push("sidebar position="+ss.position+" bg="+ss.backgroundImage+" z="+ss.zIndex);
  const ms=cs('.main-content');
  out.push("main-content pos="+ms.position+" margin="+ms.marginLeft+" ml="+ms.marginLeft+" w="+ms.width+" padding="+ms.padding);
  const aw=document.querySelector('.app-wrapper');
  out.push("app-wrapper exists="+(aw!=null));
  // find tall elements
  out.push("--- tall/invisible divs (>200px) ---");
  let cnt=0;
  for(const el of document.querySelectorAll('body *')){
    const r2=el.getBoundingClientRect();
    if(r2.height>900 && cnt<8){ out.push(`  class="${el.className}" h=${Math.round(r2.height)} rect=${Math.round(r2.x)},${Math.round(r2.y)}`); cnt++; }
  }
  // count stylesheets / errors
  out.push("--- stylesheets ---");
  document.styleSheets.length;
  for(const sh of document.styleSheets){
    let rules=0, errs=0;
    try{ rules=sh.cssRules.length; }catch(e){ errs=1; }
    out.push(`  href=${sh.href} rules=${rules} crossOriginErr=${errs}`);
  }
  return out.join("\n");
});
console.log(r);
await browser.close();
