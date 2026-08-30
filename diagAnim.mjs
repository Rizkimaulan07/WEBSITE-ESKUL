import puppeteer from 'puppeteer-core';
const EDGE = "C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe";
const url = process.argv[2];
const browser = await puppeteer.launch({executablePath:EDGE, headless:"new", args:["--no-sandbox","--disable-gpu"], userDataDir:"C:/Users/lenov/AppData/Local/Temp/opencode/pp_profile"});
const page = await browser.newPage();
await page.setViewport({width:1440,height:1000});
await page.goto(url,{waitUntil:"networkidle0",timeout:30000});
const r = await page.evaluate(()=>{
  const out=[];
  const load = document.querySelector('.simskul-loading');
  out.push("loading overlay present: " + (load!=null));
  // count keyframe animations defined & used
  const anims = new Set();
  for(const s of document.styleSheets){
    if(s.href!=null) continue;
    try{ for(const rr of s.cssRules){ if(rr.type===CSSRule.KEYFRAMES_RULE){ anims.add(rr.name); } } }catch(e){}
  }
  out.push("keyframes defined: " + [...anims].join(', '));
  // check elements using animations
  const using = [];
  for(const el of document.querySelectorAll('*')){
    const a = getComputedStyle(el).animationName;
    if(a && a!=='none'){ using.push(el.className.toString().slice(0,30)+":"+a); }
  }
  out.push("elements animating: " + (using.slice(0,10).join(' | ')||"none"));
  return out.join("\n");
});
console.log(r);
await browser.close();
