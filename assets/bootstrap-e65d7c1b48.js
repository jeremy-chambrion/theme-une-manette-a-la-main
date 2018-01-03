"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};!function e(t,n,o){function i(s,a){if(!n[s]){if(!t[s]){var c="function"==typeof require&&require;if(!a&&c)return c(s,!0);if(r)return r(s,!0);var u=new Error("Cannot find module '"+s+"'");throw u.code="MODULE_NOT_FOUND",u}var d=n[s]={exports:{}};t[s][0].call(d.exports,function(e){var n=t[s][1][e];return i(n||e)},d,d.exports,e,t,n,o)}return n[s].exports}for(var r="function"==typeof require&&require,s=0;s<o.length;s++)i(o[s]);return i}({1:[function(e,t,n){var o=e("../parse/index.js");t.exports=function(e,t){var n=o(e).getTime(),i=o(t).getTime();return n<i?-1:n>i?1:0}},{"../parse/index.js":17}],2:[function(e,t,n){var o=e("../parse/index.js");t.exports=function(e,t){var n=o(e).getTime(),i=o(t).getTime();return n>i?-1:n<i?1:0}},{"../parse/index.js":17}],3:[function(e,t,n){var o=e("../parse/index.js");t.exports=function(e,t){var n=o(e),i=o(t);return 12*(n.getFullYear()-i.getFullYear())+(n.getMonth()-i.getMonth())}},{"../parse/index.js":17}],4:[function(e,t,n){var o=e("../parse/index.js");t.exports=function(e,t){var n=o(e),i=o(t);return n.getTime()-i.getTime()}},{"../parse/index.js":17}],5:[function(e,t,n){var o=e("../parse/index.js"),i=e("../difference_in_calendar_months/index.js"),r=e("../compare_asc/index.js");t.exports=function(e,t){var n=o(e),s=o(t),a=r(n,s),c=Math.abs(i(n,s));return n.setMonth(n.getMonth()-a*c),a*(c-(r(n,s)===-a))}},{"../compare_asc/index.js":1,"../difference_in_calendar_months/index.js":3,"../parse/index.js":17}],6:[function(e,t,n){var o=e("../difference_in_milliseconds/index.js");t.exports=function(e,t){var n=o(e,t)/1e3;return n>0?Math.floor(n):Math.ceil(n)}},{"../difference_in_milliseconds/index.js":4}],7:[function(e,t,n){var o=e("../compare_desc/index.js"),i=e("../parse/index.js"),r=e("../difference_in_seconds/index.js"),s=e("../difference_in_months/index.js"),a=e("../locale/en/index.js"),c=1440,u=2520,d=43200,l=86400;t.exports=function(e,t,n){var h=n||{},f=o(e,t),m=h.locale,p=a.distanceInWords.localize;m&&m.distanceInWords&&m.distanceInWords.localize&&(p=m.distanceInWords.localize);var v,y,g={addSuffix:Boolean(h.addSuffix),comparison:f};f>0?(v=i(e),y=i(t)):(v=i(t),y=i(e));var x,w=r(y,v),b=y.getTimezoneOffset()-v.getTimezoneOffset(),_=Math.round(w/60)-b;if(_<2)return h.includeSeconds?w<5?p("lessThanXSeconds",5,g):w<10?p("lessThanXSeconds",10,g):w<20?p("lessThanXSeconds",20,g):w<40?p("halfAMinute",null,g):p(w<60?"lessThanXMinutes":"xMinutes",1,g):0===_?p("lessThanXMinutes",1,g):p("xMinutes",_,g);if(_<45)return p("xMinutes",_,g);if(_<90)return p("aboutXHours",1,g);if(_<c)return p("aboutXHours",Math.round(_/60),g);if(_<u)return p("xDays",1,g);if(_<d)return p("xDays",Math.round(_/c),g);if(_<l)return p("aboutXMonths",x=Math.round(_/d),g);if((x=s(y,v))<12)return p("xMonths",Math.round(_/d),g);var M=x%12,T=Math.floor(x/12);return M<3?p("aboutXYears",T,g):M<9?p("overXYears",T,g):p("almostXYears",T+1,g)}},{"../compare_desc/index.js":2,"../difference_in_months/index.js":5,"../difference_in_seconds/index.js":6,"../locale/en/index.js":13,"../parse/index.js":17}],8:[function(e,t,n){var o=e("../distance_in_words/index.js");t.exports=function(e,t){return o(Date.now(),e,t)}},{"../distance_in_words/index.js":7}],9:[function(e,t,n){t.exports=function(e){return e instanceof Date}},{}],10:[function(e,t,n){var o=["M","MM","Q","D","DD","DDD","DDDD","d","E","W","WW","YY","YYYY","GG","GGGG","H","HH","h","hh","m","mm","s","ss","S","SS","SSS","Z","ZZ","X","x"];t.exports=function(e){var t=[];for(var n in e)e.hasOwnProperty(n)&&t.push(n);var i=o.concat(t).sort().reverse();return new RegExp("(\\[[^\\[]*\\])|(\\\\)?("+i.join("|")+"|.)","g")}},{}],11:[function(e,t,n){t.exports=function(){var e={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};return{localize:function(t,n,o){o=o||{};var i;return i="string"==typeof e[t]?e[t]:1===n?e[t].one:e[t].other.replace("{{count}}",n),o.addSuffix?o.comparison>0?"in "+i:i+" ago":i}}}},{}],12:[function(e,t,n){var o=e("../../_lib/build_formatting_tokens_reg_exp/index.js");t.exports=function(){var e=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],t=["January","February","March","April","May","June","July","August","September","October","November","December"],n=["Su","Mo","Tu","We","Th","Fr","Sa"],i=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],r=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],s=["AM","PM"],a=["am","pm"],c=["a.m.","p.m."],u={MMM:function(t){return e[t.getMonth()]},MMMM:function(e){return t[e.getMonth()]},dd:function(e){return n[e.getDay()]},ddd:function(e){return i[e.getDay()]},dddd:function(e){return r[e.getDay()]},A:function(e){return e.getHours()/12>=1?s[1]:s[0]},a:function(e){return e.getHours()/12>=1?a[1]:a[0]},aa:function(e){return e.getHours()/12>=1?c[1]:c[0]}};return["M","D","DDD","d","Q","W"].forEach(function(e){u[e+"o"]=function(t,n){return function(e){var t=e%100;if(t>20||t<10)switch(t%10){case 1:return e+"st";case 2:return e+"nd";case 3:return e+"rd"}return e+"th"}(n[e](t))}}),{formatters:u,formattingTokensRegExp:o(u)}}},{"../../_lib/build_formatting_tokens_reg_exp/index.js":10}],13:[function(e,t,n){var o=e("./build_distance_in_words_locale/index.js"),i=e("./build_format_locale/index.js");t.exports={distanceInWords:o(),format:i()}},{"./build_distance_in_words_locale/index.js":11,"./build_format_locale/index.js":12}],14:[function(e,t,n){t.exports=function(){var e={lessThanXSeconds:{one:"moins d’une seconde",other:"moins de {{count}} secondes"},xSeconds:{one:"1 seconde",other:"{{count}} secondes"},halfAMinute:"30 secondes",lessThanXMinutes:{one:"moins d’une minute",other:"moins de {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"environ 1 heure",other:"environ {{count}} heures"},xHours:{one:"1 heure",other:"{{count}} heures"},xDays:{one:"1 jour",other:"{{count}} jours"},aboutXMonths:{one:"environ 1 mois",other:"environ {{count}} mois"},xMonths:{one:"1 mois",other:"{{count}} mois"},aboutXYears:{one:"environ 1 an",other:"environ {{count}} ans"},xYears:{one:"1 an",other:"{{count}} ans"},overXYears:{one:"plus d’un an",other:"plus de {{count}} ans"},almostXYears:{one:"presqu’un an",other:"presque {{count}} ans"}};return{localize:function(t,n,o){o=o||{};var i;return i="string"==typeof e[t]?e[t]:1===n?e[t].one:e[t].other.replace("{{count}}",n),o.addSuffix?o.comparison>0?"dans "+i:"il y a "+i:i}}}},{}],15:[function(e,t,n){var o=e("../../_lib/build_formatting_tokens_reg_exp/index.js");t.exports=function(){var e=["janv.","févr.","mars","avr.","mai","juin","juill.","août","sept.","oct.","nov.","déc."],t=["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"],n=["di","lu","ma","me","je","ve","sa"],i=["dim.","lun.","mar.","mer.","jeu.","ven.","sam."],r=["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"],s=["AM","PM"],a=["am","pm"],c=["du matin","de l’après-midi","du soir"],u={MMM:function(t){return e[t.getMonth()]},MMMM:function(e){return t[e.getMonth()]},dd:function(e){return n[e.getDay()]},ddd:function(e){return i[e.getDay()]},dddd:function(e){return r[e.getDay()]},A:function(e){return e.getHours()/12>=1?s[1]:s[0]},a:function(e){return e.getHours()/12>=1?a[1]:a[0]},aa:function(e){var t=e.getHours();return t<=12?c[0]:t<=16?c[1]:c[2]},Wo:function(e,t){return 1===(n=t.W(e))?"1re":n+"e";var n}};return["M","D","DDD","d","Q"].forEach(function(e){u[e+"o"]=function(t,n){return 1===(o=n[e](t))?"1er":o+"e";var o}}),["MMM","MMMM"].forEach(function(e){u["Do "+e]=function(t,n){var o=1===t.getDate()?"Do":"D";return(u[o]||n[o])(t,n)+" "+u[e](t)}}),{formatters:u,formattingTokensRegExp:o(u)}}},{"../../_lib/build_formatting_tokens_reg_exp/index.js":10}],16:[function(e,t,n){var o=e("./build_distance_in_words_locale/index.js"),i=e("./build_format_locale/index.js");t.exports={distanceInWords:o(),format:i()}},{"./build_distance_in_words_locale/index.js":14,"./build_format_locale/index.js":15}],17:[function(e,t,n){var o=e("../is_date/index.js"),i=36e5,r=6e4,s=2,a=/[T ]/,c=/:/,u=/^(\d{2})$/,d=[/^([+-]\d{2})$/,/^([+-]\d{3})$/,/^([+-]\d{4})$/],l=/^(\d{4})/,h=[/^([+-]\d{4})/,/^([+-]\d{5})/,/^([+-]\d{6})/],f=/^-(\d{2})$/,m=/^-?(\d{3})$/,p=/^-?(\d{2})-?(\d{2})$/,v=/^-?W(\d{2})$/,y=/^-?W(\d{2})-?(\d{1})$/,g=/^(\d{2}([.,]\d*)?)$/,x=/^(\d{2}):?(\d{2}([.,]\d*)?)$/,w=/^(\d{2}):?(\d{2}):?(\d{2}([.,]\d*)?)$/,b=/([Z+-].*)$/,_=/^(Z)$/,M=/^([+-])(\d{2})$/,T=/^([+-])(\d{2}):?(\d{2})$/;function D(e,t,n){t=t||0,n=n||0;var o=new Date(0);o.setUTCFullYear(e,0,4);var i=7*t+n+1-(o.getUTCDay()||7);return o.setUTCDate(o.getUTCDate()+i),o}t.exports=function(e,t){if(o(e))return new Date(e.getTime());if("string"!=typeof e)return new Date(e);var n=(t||{}).additionalDigits;n=null==n?s:Number(n);var S=function(e){var t,n={},o=e.split(a);if(c.test(o[0])?(n.date=null,t=o[0]):(n.date=o[0],t=o[1]),t){var i=b.exec(t);i?(n.time=t.replace(i[1],""),n.timezone=i[1]):n.time=t}return n}(e),j=function(e,t){var n,o=d[t],i=h[t];if(n=l.exec(e)||i.exec(e)){var r=n[1];return{year:parseInt(r,10),restDateString:e.slice(r.length)}}if(n=u.exec(e)||o.exec(e)){var s=n[1];return{year:100*parseInt(s,10),restDateString:e.slice(s.length)}}return{year:null}}(S.date,n),E=j.year,H=function(e,t){if(null===t)return null;var n,o,i,r;if(0===e.length)return(o=new Date(0)).setUTCFullYear(t),o;if(n=f.exec(e))return o=new Date(0),i=parseInt(n[1],10)-1,o.setUTCFullYear(t,i),o;if(n=m.exec(e)){o=new Date(0);var s=parseInt(n[1],10);return o.setUTCFullYear(t,0,s),o}if(n=p.exec(e)){o=new Date(0),i=parseInt(n[1],10)-1;var a=parseInt(n[2],10);return o.setUTCFullYear(t,i,a),o}if(n=v.exec(e))return r=parseInt(n[1],10)-1,D(t,r);if(n=y.exec(e)){r=parseInt(n[1],10)-1;var c=parseInt(n[2],10)-1;return D(t,r,c)}return null}(j.restDateString,E);if(H){var Y,F=H.getTime(),I=0;return S.time&&(I=function(e){var t,n,o;if(t=g.exec(e))return(n=parseFloat(t[1].replace(",",".")))%24*i;if(t=x.exec(e))return n=parseInt(t[1],10),o=parseFloat(t[2].replace(",",".")),n%24*i+o*r;if(t=w.exec(e)){n=parseInt(t[1],10),o=parseInt(t[2],10);var s=parseFloat(t[3].replace(",","."));return n%24*i+o*r+1e3*s}return null}(S.time)),S.timezone?Y=function(e){var t,n;return(t=_.exec(e))?0:(t=M.exec(e))?(n=60*parseInt(t[2],10),"+"===t[1]?-n:n):(t=T.exec(e))?(n=60*parseInt(t[2],10)+parseInt(t[3],10),"+"===t[1]?-n:n):0}(S.timezone):(Y=new Date(F+I).getTimezoneOffset(),Y=new Date(F+I+Y*r).getTimezoneOffset()),new Date(F+I+Y*r)}return new Date(e)}},{"../is_date/index.js":9}],18:[function(e,t,n){!function(){function e(e,t){document.addEventListener?e.addEventListener("scroll",t,!1):e.attachEvent("scroll",t)}function n(e){this.a=document.createElement("div"),this.a.setAttribute("aria-hidden","true"),this.a.appendChild(document.createTextNode(e)),this.b=document.createElement("span"),this.c=document.createElement("span"),this.h=document.createElement("span"),this.f=document.createElement("span"),this.g=-1,this.b.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.c.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.f.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.h.style.cssText="display:inline-block;width:200%;height:200%;font-size:16px;max-width:none;",this.b.appendChild(this.h),this.c.appendChild(this.f),this.a.appendChild(this.b),this.a.appendChild(this.c)}function o(e,t){e.a.style.cssText="max-width:none;min-width:20px;min-height:20px;display:inline-block;overflow:hidden;position:absolute;width:auto;margin:0;padding:0;top:-999px;white-space:nowrap;font-synthesis:none;font:"+t+";"}function i(e){var t=e.a.offsetWidth,n=t+100;return e.f.style.width=n+"px",e.c.scrollLeft=n,e.b.scrollLeft=e.b.scrollWidth+100,e.g!==t&&(e.g=t,!0)}function r(t,n){function o(){var e=r;i(e)&&e.a.parentNode&&n(e.g)}var r=t;e(t.b,o),e(t.c,o),i(t)}function s(e,t){var n=t||{};this.family=e,this.style=n.style||"normal",this.weight=n.weight||"normal",this.stretch=n.stretch||"normal"}var a=null,c=null,u=null,d=null;function l(){return null===d&&(d=!!document.fonts),d}function h(e,t){return[e.style,e.weight,function(){if(null===u){var e=document.createElement("div");try{e.style.font="condensed 100px sans-serif"}catch(e){}u=""!==e.style.font}return u}()?e.stretch:"","100px",t].join(" ")}s.prototype.load=function(e,t){var i=this,s=e||"BESbswy",u=0,d=t||3e3,f=(new Date).getTime();return new Promise(function(e,t){if(l()&&!function(){if(null===c)if(l()&&/Apple/.test(window.navigator.vendor)){var e=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))(?:\.([0-9]+))/.exec(window.navigator.userAgent);c=!!e&&603>parseInt(e[1],10)}else c=!1;return c}()){var m=new Promise(function(e,t){!function n(){(new Date).getTime()-f>=d?t():document.fonts.load(h(i,'"'+i.family+'"'),s).then(function(t){1<=t.length?e():setTimeout(n,25)},function(){t()})}()}),p=new Promise(function(e,t){u=setTimeout(t,d)});Promise.race([p,m]).then(function(){clearTimeout(u),e(i)},function(){t(i)})}else v=function(){function c(){var t;(t=-1!=v&&-1!=y||-1!=v&&-1!=g||-1!=y&&-1!=g)&&((t=v!=y&&v!=g&&y!=g)||(null===a&&(t=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent),a=!!t&&(536>parseInt(t[1],10)||536===parseInt(t[1],10)&&11>=parseInt(t[2],10))),t=a&&(v==x&&y==x&&g==x||v==w&&y==w&&g==w||v==b&&y==b&&g==b)),t=!t),t&&(_.parentNode&&_.parentNode.removeChild(_),clearTimeout(u),e(i))}var l=new n(s),m=new n(s),p=new n(s),v=-1,y=-1,g=-1,x=-1,w=-1,b=-1,_=document.createElement("div");_.dir="ltr",o(l,h(i,"sans-serif")),o(m,h(i,"serif")),o(p,h(i,"monospace")),_.appendChild(l.a),_.appendChild(m.a),_.appendChild(p.a),document.body.appendChild(_),x=l.a.offsetWidth,w=m.a.offsetWidth,b=p.a.offsetWidth,function e(){if((new Date).getTime()-f>=d)_.parentNode&&_.parentNode.removeChild(_),t(i);else{var n=document.hidden;!0!==n&&void 0!==n||(v=l.a.offsetWidth,y=m.a.offsetWidth,g=p.a.offsetWidth,c()),u=setTimeout(e,50)}}(),r(l,function(e){v=e,c()}),o(l,h(i,'"'+i.family+'",sans-serif')),r(m,function(e){y=e,c()}),o(m,h(i,'"'+i.family+'",serif')),r(p,function(e){g=e,c()}),o(p,h(i,'"'+i.family+'",monospace'))},document.body?v():document.addEventListener?document.addEventListener("DOMContentLoaded",function e(){document.removeEventListener("DOMContentLoaded",e),v()}):document.attachEvent("onreadystatechange",function e(){"interactive"!=document.readyState&&"complete"!=document.readyState||(document.detachEvent("onreadystatechange",e),v())});var v})},"object"===(void 0===t?"undefined":_typeof(t))?t.exports=s:(window.FontFaceObserver=s,window.FontFaceObserver.prototype.load=s.prototype.load)}()},{}],19:[function(e,t,n){o=this,i=function(){var e={bind:!!function(){}.bind,classList:"classList"in document.documentElement,rAF:!!(window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame)};window.requestAnimationFrame=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame;function t(e){this.callback=e,this.ticking=!1}t.prototype={constructor:t,update:function(){this.callback&&this.callback(),this.ticking=!1},requestTick:function(){this.ticking||(requestAnimationFrame(this.rafCallback||(this.rafCallback=this.update.bind(this))),this.ticking=!0)},handleEvent:function(){this.requestTick()}};function n(e,t){t=function e(t){if(arguments.length<=0)throw new Error("Missing arguments in extend function");var n,o,i=t||{};for(o=1;o<arguments.length;o++){var r=arguments[o]||{};for(n in r)"object"===_typeof(i[n])&&(s=i[n],!s||"undefined"==typeof window||s!==window&&!s.nodeType)?i[n]=e(i[n],r[n]):i[n]=i[n]||r[n]}var s;return i}(t,n.options),this.lastKnownScrollY=0,this.elem=e,this.tolerance=(o=t.tolerance,o===Object(o)?o:{down:o,up:o});var o;this.classes=t.classes,this.offset=t.offset,this.scroller=t.scroller,this.initialised=!1,this.onPin=t.onPin,this.onUnpin=t.onUnpin,this.onTop=t.onTop,this.onNotTop=t.onNotTop,this.onBottom=t.onBottom,this.onNotBottom=t.onNotBottom}return n.prototype={constructor:n,init:function(){if(n.cutsTheMustard)return this.debouncer=new t(this.update.bind(this)),this.elem.classList.add(this.classes.initial),setTimeout(this.attachEvent.bind(this),100),this},destroy:function(){var e=this.classes;this.initialised=!1;for(var t in e)e.hasOwnProperty(t)&&this.elem.classList.remove(e[t]);this.scroller.removeEventListener("scroll",this.debouncer,!1)},attachEvent:function(){this.initialised||(this.lastKnownScrollY=this.getScrollY(),this.initialised=!0,this.scroller.addEventListener("scroll",this.debouncer,!1),this.debouncer.handleEvent())},unpin:function(){var e=this.elem.classList,t=this.classes;!e.contains(t.pinned)&&e.contains(t.unpinned)||(e.add(t.unpinned),e.remove(t.pinned),this.onUnpin&&this.onUnpin.call(this))},pin:function(){var e=this.elem.classList,t=this.classes;e.contains(t.unpinned)&&(e.remove(t.unpinned),e.add(t.pinned),this.onPin&&this.onPin.call(this))},top:function(){var e=this.elem.classList,t=this.classes;e.contains(t.top)||(e.add(t.top),e.remove(t.notTop),this.onTop&&this.onTop.call(this))},notTop:function(){var e=this.elem.classList,t=this.classes;e.contains(t.notTop)||(e.add(t.notTop),e.remove(t.top),this.onNotTop&&this.onNotTop.call(this))},bottom:function(){var e=this.elem.classList,t=this.classes;e.contains(t.bottom)||(e.add(t.bottom),e.remove(t.notBottom),this.onBottom&&this.onBottom.call(this))},notBottom:function(){var e=this.elem.classList,t=this.classes;e.contains(t.notBottom)||(e.add(t.notBottom),e.remove(t.bottom),this.onNotBottom&&this.onNotBottom.call(this))},getScrollY:function(){return void 0!==this.scroller.pageYOffset?this.scroller.pageYOffset:void 0!==this.scroller.scrollTop?this.scroller.scrollTop:(document.documentElement||document.body.parentNode||document.body).scrollTop},getViewportHeight:function(){return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight},getElementPhysicalHeight:function(e){return Math.max(e.offsetHeight,e.clientHeight)},getScrollerPhysicalHeight:function(){return this.scroller===window||this.scroller===document.body?this.getViewportHeight():this.getElementPhysicalHeight(this.scroller)},getDocumentHeight:function(){var e=document.body,t=document.documentElement;return Math.max(e.scrollHeight,t.scrollHeight,e.offsetHeight,t.offsetHeight,e.clientHeight,t.clientHeight)},getElementHeight:function(e){return Math.max(e.scrollHeight,e.offsetHeight,e.clientHeight)},getScrollerHeight:function(){return this.scroller===window||this.scroller===document.body?this.getDocumentHeight():this.getElementHeight(this.scroller)},isOutOfBounds:function(e){var t=e<0,n=e+this.getScrollerPhysicalHeight()>this.getScrollerHeight();return t||n},toleranceExceeded:function(e,t){return Math.abs(e-this.lastKnownScrollY)>=this.tolerance[t]},shouldUnpin:function(e,t){var n=e>this.lastKnownScrollY,o=e>=this.offset;return n&&o&&t},shouldPin:function(e,t){var n=e<this.lastKnownScrollY,o=e<=this.offset;return n&&t||o},update:function(){var e=this.getScrollY(),t=e>this.lastKnownScrollY?"down":"up",n=this.toleranceExceeded(e,t);this.isOutOfBounds(e)||(e<=this.offset?this.top():this.notTop(),e+this.getViewportHeight()>=this.getScrollerHeight()?this.bottom():this.notBottom(),this.shouldUnpin(e,n)?this.unpin():this.shouldPin(e,n)&&this.pin(),this.lastKnownScrollY=e)}},n.options={tolerance:{up:0,down:0},offset:0,scroller:window,classes:{pinned:"headroom--pinned",unpinned:"headroom--unpinned",top:"headroom--top",notTop:"headroom--not-top",bottom:"headroom--bottom",notBottom:"headroom--not-bottom",initial:"headroom"}},n.cutsTheMustard=void 0!==e&&e.rAF&&e.bind&&e.classList,n},"function"==typeof define&&define.amd?define([],i):"object"===(void 0===n?"undefined":_typeof(n))?t.exports=i():o.Headroom=i();var o,i},{}],20:[function(e,t,n){var o=e("headroom.js"),i=e("date-fns/distance_in_words_to_now"),r=e("date-fns/locale/fr"),s=e("fontfaceobserver");new o(document.getElementById("masthead"),{offset:100,tolerance:10}).init();var a=new s("Raleway",{weight:400}),c=new s("Raleway",{weight:700}),u=new s("Roboto Slab",{weight:400}),d=new s("Roboto Slab",{weight:700}),l=new s("FontAwesome");Promise.all([u.load(),d.load(),a.load(),c.load(),l.load()]).then(function(){document.querySelector(".loader").style.display="none",document.getElementById("content").style.display="block",document.getElementById("footer").style.display="block",requestAnimationFrame(function(){document.getElementById("content").style.opacity=1,document.getElementById("footer").style.opacity=1})}).catch(function(){document.querySelector(".loader").style.display="none",document.getElementById("content").style.display="block",document.getElementById("footer").style.display="block",requestAnimationFrame(function(){document.getElementById("content").style.opacity=1,document.getElementById("footer").style.opacity=1})});var h=function(e,t,n){e&&(e.addEventListener?e.addEventListener(t,n):e.attachEvent("on"+t,function(){n.call(e)}))},f=function(e){27===e.keyCode&&m()},m=function(){requestAnimationFrame(function(){document.querySelector(".search-screen").style.opacity=0,new Promise(function(e){return setTimeout(e,200)}).then(function(){document.querySelector(".search-screen").style.display="none"})}),e=document,t="keyup",n=f,e&&(e.removeEventListener?e.removeEventListener(t,n):e.detachEvent("on"+t,n));var e,t,n};h(document.querySelector(".search-open"),"click",function(e){e.preventDefault(),document.querySelector(".search-screen").style.display="block",requestAnimationFrame(function(){document.querySelector(".search-screen").style.opacity=1}),document.getElementById("search-input").focus(),h(document,"keyup",f)}),h(document.querySelector(".search-close"),"click",function(e){e.preventDefault(),m()});var p=function(e){for(var t=document.querySelectorAll(e),n=0;n<t.length;n++)t[n].innerHTML=i(t[n].getAttribute("datetime"),{addSuffix:!0,locale:r})};p(".article-time time"),p(".comment-metadata time")},{"date-fns/distance_in_words_to_now":8,"date-fns/locale/fr":16,fontfaceobserver:18,"headroom.js":19}]},{},[20]);
//# sourceMappingURL=bootstrap-e65d7c1b48.js.map
