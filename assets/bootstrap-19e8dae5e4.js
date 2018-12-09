"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};!function r(s,a,c){function u(t,e){if(!a[t]){if(!s[t]){var n="function"==typeof require&&require;if(!e&&n)return n(t,!0);if(d)return d(t,!0);var o=new Error("Cannot find module '"+t+"'");throw o.code="MODULE_NOT_FOUND",o}var i=a[t]={exports:{}};s[t][0].call(i.exports,function(e){return u(s[t][1][e]||e)},i,i.exports,r,s,a,c)}return a[t].exports}for(var d="function"==typeof require&&require,e=0;e<c.length;e++)u(c[e]);return u}({1:[function(e,t,n){var i=e("../parse/index.js");t.exports=function(e,t){var n=i(e).getTime(),o=i(t).getTime();return n<o?-1:o<n?1:0}},{"../parse/index.js":17}],2:[function(e,t,n){var i=e("../parse/index.js");t.exports=function(e,t){var n=i(e).getTime(),o=i(t).getTime();return o<n?-1:n<o?1:0}},{"../parse/index.js":17}],3:[function(e,t,n){var i=e("../parse/index.js");t.exports=function(e,t){var n=i(e),o=i(t);return 12*(n.getFullYear()-o.getFullYear())+(n.getMonth()-o.getMonth())}},{"../parse/index.js":17}],4:[function(e,t,n){var i=e("../parse/index.js");t.exports=function(e,t){var n=i(e),o=i(t);return n.getTime()-o.getTime()}},{"../parse/index.js":17}],5:[function(e,t,n){var s=e("../parse/index.js"),a=e("../difference_in_calendar_months/index.js"),c=e("../compare_asc/index.js");t.exports=function(e,t){var n=s(e),o=s(t),i=c(n,o),r=Math.abs(a(n,o));return n.setMonth(n.getMonth()-i*r),i*(r-(c(n,o)===-i))}},{"../compare_asc/index.js":1,"../difference_in_calendar_months/index.js":3,"../parse/index.js":17}],6:[function(e,t,n){var o=e("../difference_in_milliseconds/index.js");t.exports=function(e,t){var n=o(e,t)/1e3;return 0<n?Math.floor(n):Math.ceil(n)}},{"../difference_in_milliseconds/index.js":4}],7:[function(e,t,n){var v=e("../compare_desc/index.js"),y=e("../parse/index.js"),g=e("../difference_in_seconds/index.js"),x=e("../difference_in_months/index.js"),w=e("../locale/en/index.js");t.exports=function(e,t,n){var o=n||{},i=v(e,t),r=o.locale,s=w.distanceInWords.localize;r&&r.distanceInWords&&r.distanceInWords.localize&&(s=r.distanceInWords.localize);var a,c,u={addSuffix:Boolean(o.addSuffix),comparison:i};0<i?(a=y(e),c=y(t)):(a=y(t),c=y(e));var d,l=g(c,a),h=c.getTimezoneOffset()-a.getTimezoneOffset(),f=Math.round(l/60)-h;if(f<2)return o.includeSeconds?l<5?s("lessThanXSeconds",5,u):l<10?s("lessThanXSeconds",10,u):l<20?s("lessThanXSeconds",20,u):l<40?s("halfAMinute",null,u):s(l<60?"lessThanXMinutes":"xMinutes",1,u):0===f?s("lessThanXMinutes",1,u):s("xMinutes",f,u);if(f<45)return s("xMinutes",f,u);if(f<90)return s("aboutXHours",1,u);if(f<1440)return s("aboutXHours",Math.round(f/60),u);if(f<2520)return s("xDays",1,u);if(f<43200)return s("xDays",Math.round(f/1440),u);if(f<86400)return s("aboutXMonths",d=Math.round(f/43200),u);if((d=x(c,a))<12)return s("xMonths",Math.round(f/43200),u);var m=d%12,p=Math.floor(d/12);return m<3?s("aboutXYears",p,u):m<9?s("overXYears",p,u):s("almostXYears",p+1,u)}},{"../compare_desc/index.js":2,"../difference_in_months/index.js":5,"../difference_in_seconds/index.js":6,"../locale/en/index.js":13,"../parse/index.js":17}],8:[function(e,t,n){var o=e("../distance_in_words/index.js");t.exports=function(e,t){return o(Date.now(),e,t)}},{"../distance_in_words/index.js":7}],9:[function(e,t,n){t.exports=function(e){return e instanceof Date}},{}],10:[function(e,t,n){var i=["M","MM","Q","D","DD","DDD","DDDD","d","E","W","WW","YY","YYYY","GG","GGGG","H","HH","h","hh","m","mm","s","ss","S","SS","SSS","Z","ZZ","X","x"];t.exports=function(e){var t=[];for(var n in e)e.hasOwnProperty(n)&&t.push(n);var o=i.concat(t).sort().reverse();return new RegExp("(\\[[^\\[]*\\])|(\\\\)?("+o.join("|")+"|.)","g")}},{}],11:[function(e,t,n){t.exports=function(){var i={lessThanXSeconds:{one:"less than a second",other:"less than {{count}} seconds"},xSeconds:{one:"1 second",other:"{{count}} seconds"},halfAMinute:"half a minute",lessThanXMinutes:{one:"less than a minute",other:"less than {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"about 1 hour",other:"about {{count}} hours"},xHours:{one:"1 hour",other:"{{count}} hours"},xDays:{one:"1 day",other:"{{count}} days"},aboutXMonths:{one:"about 1 month",other:"about {{count}} months"},xMonths:{one:"1 month",other:"{{count}} months"},aboutXYears:{one:"about 1 year",other:"about {{count}} years"},xYears:{one:"1 year",other:"{{count}} years"},overXYears:{one:"over 1 year",other:"over {{count}} years"},almostXYears:{one:"almost 1 year",other:"almost {{count}} years"}};return{localize:function(e,t,n){var o;return n=n||{},o="string"==typeof i[e]?i[e]:1===t?i[e].one:i[e].other.replace("{{count}}",t),n.addSuffix?0<n.comparison?"in "+o:o+" ago":o}}}},{}],12:[function(e,t,n){var u=e("../../_lib/build_formatting_tokens_reg_exp/index.js");t.exports=function(){var t=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],n=["January","February","March","April","May","June","July","August","September","October","November","December"],o=["Su","Mo","Tu","We","Th","Fr","Sa"],i=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],r=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],s=["AM","PM"],a=["am","pm"],c=["a.m.","p.m."],e={MMM:function(e){return t[e.getMonth()]},MMMM:function(e){return n[e.getMonth()]},dd:function(e){return o[e.getDay()]},ddd:function(e){return i[e.getDay()]},dddd:function(e){return r[e.getDay()]},A:function(e){return 1<=e.getHours()/12?s[1]:s[0]},a:function(e){return 1<=e.getHours()/12?a[1]:a[0]},aa:function(e){return 1<=e.getHours()/12?c[1]:c[0]}};return["M","D","DDD","d","Q","W"].forEach(function(n){e[n+"o"]=function(e,t){return function(e){var t=e%100;if(20<t||t<10)switch(t%10){case 1:return e+"st";case 2:return e+"nd";case 3:return e+"rd"}return e+"th"}(t[n](e))}}),{formatters:e,formattingTokensRegExp:u(e)}}},{"../../_lib/build_formatting_tokens_reg_exp/index.js":10}],13:[function(e,t,n){var o=e("./build_distance_in_words_locale/index.js"),i=e("./build_format_locale/index.js");t.exports={distanceInWords:o(),format:i()}},{"./build_distance_in_words_locale/index.js":11,"./build_format_locale/index.js":12}],14:[function(e,t,n){t.exports=function(){var i={lessThanXSeconds:{one:"moins d’une seconde",other:"moins de {{count}} secondes"},xSeconds:{one:"1 seconde",other:"{{count}} secondes"},halfAMinute:"30 secondes",lessThanXMinutes:{one:"moins d’une minute",other:"moins de {{count}} minutes"},xMinutes:{one:"1 minute",other:"{{count}} minutes"},aboutXHours:{one:"environ 1 heure",other:"environ {{count}} heures"},xHours:{one:"1 heure",other:"{{count}} heures"},xDays:{one:"1 jour",other:"{{count}} jours"},aboutXMonths:{one:"environ 1 mois",other:"environ {{count}} mois"},xMonths:{one:"1 mois",other:"{{count}} mois"},aboutXYears:{one:"environ 1 an",other:"environ {{count}} ans"},xYears:{one:"1 an",other:"{{count}} ans"},overXYears:{one:"plus d’un an",other:"plus de {{count}} ans"},almostXYears:{one:"presqu’un an",other:"presque {{count}} ans"}};return{localize:function(e,t,n){var o;return n=n||{},o="string"==typeof i[e]?i[e]:1===t?i[e].one:i[e].other.replace("{{count}}",t),n.addSuffix?0<n.comparison?"dans "+o:"il y a "+o:o}}}},{}],15:[function(e,t,n){var d=e("../../_lib/build_formatting_tokens_reg_exp/index.js");t.exports=function(){var t=["janv.","févr.","mars","avr.","mai","juin","juill.","août","sept.","oct.","nov.","déc."],n=["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"],o=["di","lu","ma","me","je","ve","sa"],i=["dim.","lun.","mar.","mer.","jeu.","ven.","sam."],r=["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"],s=["AM","PM"],a=["am","pm"],c=["du matin","de l’après-midi","du soir"],u={MMM:function(e){return t[e.getMonth()]},MMMM:function(e){return n[e.getMonth()]},dd:function(e){return o[e.getDay()]},ddd:function(e){return i[e.getDay()]},dddd:function(e){return r[e.getDay()]},A:function(e){return 1<=e.getHours()/12?s[1]:s[0]},a:function(e){return 1<=e.getHours()/12?a[1]:a[0]},aa:function(e){var t=e.getHours();return t<=12?c[0]:t<=16?c[1]:c[2]},Wo:function(e,t){return 1===(n=t.W(e))?"1re":n+"e";var n}};return["M","D","DDD","d","Q"].forEach(function(o){u[o+"o"]=function(e,t){return 1===(n=t[o](e))?"1er":n+"e";var n}}),["MMM","MMMM"].forEach(function(o){u["Do "+o]=function(e,t){var n=1===e.getDate()?"Do":"D";return(u[n]||t[n])(e,t)+" "+u[o](e)}}),{formatters:u,formattingTokensRegExp:d(u)}}},{"../../_lib/build_formatting_tokens_reg_exp/index.js":10}],16:[function(e,t,n){var o=e("./build_distance_in_words_locale/index.js"),i=e("./build_format_locale/index.js");t.exports={distanceInWords:o(),format:i()}},{"./build_distance_in_words_locale/index.js":14,"./build_format_locale/index.js":15}],17:[function(e,t,n){var f=e("../is_date/index.js"),m=36e5,p=6e4,v=/[T ]/,y=/:/,g=/^(\d{2})$/,x=[/^([+-]\d{2})$/,/^([+-]\d{3})$/,/^([+-]\d{4})$/],w=/^(\d{4})/,b=[/^([+-]\d{4})/,/^([+-]\d{5})/,/^([+-]\d{6})/],_=/^-(\d{2})$/,M=/^-?(\d{3})$/,T=/^-?(\d{2})-?(\d{2})$/,D=/^-?W(\d{2})$/,S=/^-?W(\d{2})-?(\d{1})$/,j=/^(\d{2}([.,]\d*)?)$/,E=/^(\d{2}):?(\d{2}([.,]\d*)?)$/,H=/^(\d{2}):?(\d{2}):?(\d{2}([.,]\d*)?)$/,Y=/([Z+-].*)$/,F=/^(Z)$/,I=/^([+-])(\d{2})$/,k=/^([+-])(\d{2}):?(\d{2})$/;function A(e,t,n){t=t||0,n=n||0;var o=new Date(0);o.setUTCFullYear(e,0,4);var i=7*t+n+1-(o.getUTCDay()||7);return o.setUTCDate(o.getUTCDate()+i),o}t.exports=function(e,t){if(f(e))return new Date(e.getTime());if("string"!=typeof e)return new Date(e);var n=(t||{}).additionalDigits;n=null==n?2:Number(n);var o=function(e){var t,n={},o=e.split(v);if(y.test(o[0])?(n.date=null,t=o[0]):(n.date=o[0],t=o[1]),t){var i=Y.exec(t);i?(n.time=t.replace(i[1],""),n.timezone=i[1]):n.time=t}return n}(e),i=function(e,t){var n,o=x[t],i=b[t];if(n=w.exec(e)||i.exec(e)){var r=n[1];return{year:parseInt(r,10),restDateString:e.slice(r.length)}}if(n=g.exec(e)||o.exec(e)){var s=n[1];return{year:100*parseInt(s,10),restDateString:e.slice(s.length)}}return{year:null}}(o.date,n),r=i.year,s=function(e,t){if(null===t)return null;var n,o,i,r;if(0===e.length)return(o=new Date(0)).setUTCFullYear(t),o;if(n=_.exec(e))return o=new Date(0),i=parseInt(n[1],10)-1,o.setUTCFullYear(t,i),o;if(n=M.exec(e)){o=new Date(0);var s=parseInt(n[1],10);return o.setUTCFullYear(t,0,s),o}if(n=T.exec(e)){o=new Date(0),i=parseInt(n[1],10)-1;var a=parseInt(n[2],10);return o.setUTCFullYear(t,i,a),o}if(n=D.exec(e))return r=parseInt(n[1],10)-1,A(t,r);if(n=S.exec(e)){r=parseInt(n[1],10)-1;var c=parseInt(n[2],10)-1;return A(t,r,c)}return null}(i.restDateString,r);if(s){var a,c=s.getTime(),u=0;return o.time&&(u=function(e){var t,n,o;if(t=j.exec(e))return(n=parseFloat(t[1].replace(",",".")))%24*m;if(t=E.exec(e))return n=parseInt(t[1],10),o=parseFloat(t[2].replace(",",".")),n%24*m+o*p;if(t=H.exec(e)){n=parseInt(t[1],10),o=parseInt(t[2],10);var i=parseFloat(t[3].replace(",","."));return n%24*m+o*p+1e3*i}return null}(o.time)),o.timezone?(d=o.timezone,a=(l=F.exec(d))?0:(l=I.exec(d))?(h=60*parseInt(l[2],10),"+"===l[1]?-h:h):(l=k.exec(d))?(h=60*parseInt(l[2],10)+parseInt(l[3],10),"+"===l[1]?-h:h):0):(a=new Date(c+u).getTimezoneOffset(),a=new Date(c+u+a*p).getTimezoneOffset()),new Date(c+u+a*p)}var d,l,h;return new Date(e)}},{"../is_date/index.js":9}],18:[function(e,a,t){!function(){function i(e,t){document.addEventListener?e.addEventListener("scroll",t,!1):e.attachEvent("scroll",t)}function x(e){this.a=document.createElement("div"),this.a.setAttribute("aria-hidden","true"),this.a.appendChild(document.createTextNode(e)),this.b=document.createElement("span"),this.c=document.createElement("span"),this.h=document.createElement("span"),this.f=document.createElement("span"),this.g=-1,this.b.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.c.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.f.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.h.style.cssText="display:inline-block;width:200%;height:200%;font-size:16px;max-width:none;",this.b.appendChild(this.h),this.c.appendChild(this.f),this.a.appendChild(this.b),this.a.appendChild(this.c)}function w(e,t){e.a.style.cssText="max-width:none;min-width:20px;min-height:20px;display:inline-block;overflow:hidden;position:absolute;width:auto;margin:0;padding:0;top:-999px;white-space:nowrap;font-synthesis:none;font:"+t+";"}function r(e){var t=e.a.offsetWidth,n=t+100;return e.f.style.width=n+"px",e.c.scrollLeft=n,e.b.scrollLeft=e.b.scrollWidth+100,e.g!==t&&(e.g=t,!0)}function b(e,t){function n(){var e=o;r(e)&&e.a.parentNode&&t(e.g)}var o=e;i(e.b,n),i(e.c,n),r(e)}function e(e,t){var n=t||{};this.family=e,this.style=n.style||"normal",this.weight=n.weight||"normal",this.stretch=n.stretch||"normal"}var _=null,o=null,n=null,t=null;function s(){return null===t&&(t=!!document.fonts),t}function M(e,t){return[e.style,e.weight,function(){if(null===n){var e=document.createElement("div");try{e.style.font="condensed 100px sans-serif"}catch(e){}n=""!==e.style.font}return n}()?e.stretch:"","100px",t].join(" ")}e.prototype.load=function(e,t){var m=this,p=e||"BESbswy",v=0,y=t||3e3,g=(new Date).getTime();return new Promise(function(h,f){if(s()&&!function(){if(null===o)if(s()&&/Apple/.test(window.navigator.vendor)){var e=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))(?:\.([0-9]+))/.exec(window.navigator.userAgent);o=!!e&&parseInt(e[1],10)<603}else o=!1;return o}()){var e=new Promise(function(n,e){!function t(){(new Date).getTime()-g>=y?e(Error(y+"ms timeout exceeded")):document.fonts.load(M(m,'"'+m.family+'"'),p).then(function(e){1<=e.length?n():setTimeout(t,25)},e)}()}),t=new Promise(function(e,t){v=setTimeout(function(){t(Error(y+"ms timeout exceeded"))},y)});Promise.race([t,e]).then(function(){clearTimeout(v),h(m)},f)}else n=function(){function n(){var e;(e=-1!=s&&-1!=a||-1!=s&&-1!=c||-1!=a&&-1!=c)&&((e=s!=a&&s!=c&&a!=c)||(null===_&&(e=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent),_=!!e&&(parseInt(e[1],10)<536||536===parseInt(e[1],10)&&parseInt(e[2],10)<=11)),e=_&&(s==t&&a==t&&c==t||s==u&&a==u&&c==u||s==d&&a==d&&c==d)),e=!e),e&&(l.parentNode&&l.parentNode.removeChild(l),clearTimeout(v),h(m))}var o=new x(p),i=new x(p),r=new x(p),s=-1,a=-1,c=-1,t=-1,u=-1,d=-1,l=document.createElement("div");l.dir="ltr",w(o,M(m,"sans-serif")),w(i,M(m,"serif")),w(r,M(m,"monospace")),l.appendChild(o.a),l.appendChild(i.a),l.appendChild(r.a),document.body.appendChild(l),t=o.a.offsetWidth,u=i.a.offsetWidth,d=r.a.offsetWidth,function e(){if((new Date).getTime()-g>=y)l.parentNode&&l.parentNode.removeChild(l),f(Error(y+"ms timeout exceeded"));else{var t=document.hidden;!0!==t&&void 0!==t||(s=o.a.offsetWidth,a=i.a.offsetWidth,c=r.a.offsetWidth,n()),v=setTimeout(e,50)}}(),b(o,function(e){s=e,n()}),w(o,M(m,'"'+m.family+'",sans-serif')),b(i,function(e){a=e,n()}),w(i,M(m,'"'+m.family+'",serif')),b(r,function(e){c=e,n()}),w(r,M(m,'"'+m.family+'",monospace'))},document.body?n():document.addEventListener?document.addEventListener("DOMContentLoaded",function e(){document.removeEventListener("DOMContentLoaded",e),n()}):document.attachEvent("onreadystatechange",function e(){"interactive"!=document.readyState&&"complete"!=document.readyState||(document.detachEvent("onreadystatechange",e),n())});var n})},"object"===(void 0===a?"undefined":_typeof(a))?a.exports=e:(window.FontFaceObserver=e,window.FontFaceObserver.prototype.load=e.prototype.load)}()},{}],19:[function(e,t,n){var o,i;o=this,i=function(){var e={bind:!!function(){}.bind,classList:"classList"in document.documentElement,rAF:!!(window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame)};function t(e){this.callback=e,this.ticking=!1}function o(e,t){var n;t=function e(t){if(arguments.length<=0)throw new Error("Missing arguments in extend function");var n,o,i,r=t||{};for(o=1;o<arguments.length;o++){var s=arguments[o]||{};for(n in s)"object"!==_typeof(r[n])||(i=r[n])&&"undefined"!=typeof window&&(i===window||i.nodeType)?r[n]=r[n]||s[n]:r[n]=e(r[n],s[n])}return r}(t,o.options),this.lastKnownScrollY=0,this.elem=e,this.tolerance=(n=t.tolerance)===Object(n)?n:{down:n,up:n},this.classes=t.classes,this.offset=t.offset,this.scroller=t.scroller,this.initialised=!1,this.onPin=t.onPin,this.onUnpin=t.onUnpin,this.onTop=t.onTop,this.onNotTop=t.onNotTop,this.onBottom=t.onBottom,this.onNotBottom=t.onNotBottom}return window.requestAnimationFrame=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame,t.prototype={constructor:t,update:function(){this.callback&&this.callback(),this.ticking=!1},requestTick:function(){this.ticking||(requestAnimationFrame(this.rafCallback||(this.rafCallback=this.update.bind(this))),this.ticking=!0)},handleEvent:function(){this.requestTick()}},o.prototype={constructor:o,init:function(){if(o.cutsTheMustard)return this.debouncer=new t(this.update.bind(this)),this.elem.classList.add(this.classes.initial),setTimeout(this.attachEvent.bind(this),100),this},destroy:function(){var e=this.classes;for(var t in this.initialised=!1,e)e.hasOwnProperty(t)&&this.elem.classList.remove(e[t]);this.scroller.removeEventListener("scroll",this.debouncer,!1)},attachEvent:function(){this.initialised||(this.lastKnownScrollY=this.getScrollY(),this.initialised=!0,this.scroller.addEventListener("scroll",this.debouncer,!1),this.debouncer.handleEvent())},unpin:function(){var e=this.elem.classList,t=this.classes;!e.contains(t.pinned)&&e.contains(t.unpinned)||(e.add(t.unpinned),e.remove(t.pinned),this.onUnpin&&this.onUnpin.call(this))},pin:function(){var e=this.elem.classList,t=this.classes;e.contains(t.unpinned)&&(e.remove(t.unpinned),e.add(t.pinned),this.onPin&&this.onPin.call(this))},top:function(){var e=this.elem.classList,t=this.classes;e.contains(t.top)||(e.add(t.top),e.remove(t.notTop),this.onTop&&this.onTop.call(this))},notTop:function(){var e=this.elem.classList,t=this.classes;e.contains(t.notTop)||(e.add(t.notTop),e.remove(t.top),this.onNotTop&&this.onNotTop.call(this))},bottom:function(){var e=this.elem.classList,t=this.classes;e.contains(t.bottom)||(e.add(t.bottom),e.remove(t.notBottom),this.onBottom&&this.onBottom.call(this))},notBottom:function(){var e=this.elem.classList,t=this.classes;e.contains(t.notBottom)||(e.add(t.notBottom),e.remove(t.bottom),this.onNotBottom&&this.onNotBottom.call(this))},getScrollY:function(){return void 0!==this.scroller.pageYOffset?this.scroller.pageYOffset:void 0!==this.scroller.scrollTop?this.scroller.scrollTop:(document.documentElement||document.body.parentNode||document.body).scrollTop},getViewportHeight:function(){return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight},getElementPhysicalHeight:function(e){return Math.max(e.offsetHeight,e.clientHeight)},getScrollerPhysicalHeight:function(){return this.scroller===window||this.scroller===document.body?this.getViewportHeight():this.getElementPhysicalHeight(this.scroller)},getDocumentHeight:function(){var e=document.body,t=document.documentElement;return Math.max(e.scrollHeight,t.scrollHeight,e.offsetHeight,t.offsetHeight,e.clientHeight,t.clientHeight)},getElementHeight:function(e){return Math.max(e.scrollHeight,e.offsetHeight,e.clientHeight)},getScrollerHeight:function(){return this.scroller===window||this.scroller===document.body?this.getDocumentHeight():this.getElementHeight(this.scroller)},isOutOfBounds:function(e){var t=e<0,n=e+this.getScrollerPhysicalHeight()>this.getScrollerHeight();return t||n},toleranceExceeded:function(e,t){return Math.abs(e-this.lastKnownScrollY)>=this.tolerance[t]},shouldUnpin:function(e,t){var n=e>this.lastKnownScrollY,o=e>=this.offset;return n&&o&&t},shouldPin:function(e,t){var n=e<this.lastKnownScrollY,o=e<=this.offset;return n&&t||o},update:function(){var e=this.getScrollY(),t=e>this.lastKnownScrollY?"down":"up",n=this.toleranceExceeded(e,t);this.isOutOfBounds(e)||(e<=this.offset?this.top():this.notTop(),e+this.getViewportHeight()>=this.getScrollerHeight()?this.bottom():this.notBottom(),this.shouldUnpin(e,n)?this.unpin():this.shouldPin(e,n)&&this.pin(),this.lastKnownScrollY=e)}},o.options={tolerance:{up:0,down:0},offset:0,scroller:window,classes:{pinned:"headroom--pinned",unpinned:"headroom--unpinned",top:"headroom--top",notTop:"headroom--not-top",bottom:"headroom--bottom",notBottom:"headroom--not-bottom",initial:"headroom"}},o.cutsTheMustard=void 0!==e&&e.rAF&&e.bind&&e.classList,o},"function"==typeof define&&define.amd?define([],i):"object"===(void 0===n?"undefined":_typeof(n))?t.exports=i():o.Headroom=i()},{}],20:[function(e,t,n){var o=e("headroom.js"),i=e("date-fns/distance_in_words_to_now"),r=e("date-fns/locale/fr"),s=e("fontfaceobserver");new o(document.getElementById("masthead"),{offset:100,tolerance:10}).init();var a=new s("Raleway",{weight:400}),c=new s("Raleway",{weight:700}),u=new s("Roboto Slab",{weight:400}),d=new s("Roboto Slab",{weight:700}),l=new s("FontAwesome");Promise.all([u.load(),d.load(),a.load(),c.load(),l.load()]).then(function(){document.querySelector(".loader").style.display="none",document.getElementById("content").style.display="block",document.getElementById("footer").style.display="block",requestAnimationFrame(function(){document.getElementById("content").style.opacity=1,document.getElementById("footer").style.opacity=1})}).catch(function(){document.querySelector(".loader").style.display="none",document.getElementById("content").style.display="block",document.getElementById("footer").style.display="block",requestAnimationFrame(function(){document.getElementById("content").style.opacity=1,document.getElementById("footer").style.opacity=1})});var h=function(e,t,n){e&&(e.addEventListener?e.addEventListener(t,n):e.attachEvent("on"+t,function(){n.call(e)}))},f=function(e){27===e.keyCode&&m()},m=function(){var e,t,n;requestAnimationFrame(function(){document.querySelector(".search-screen").style.opacity=0,new Promise(function(e){return setTimeout(e,200)}).then(function(){document.querySelector(".search-screen").style.display="none"})}),e=document,t="keyup",n=f,e&&(e.removeEventListener?e.removeEventListener(t,n):e.detachEvent("on"+t,n))};h(document.querySelector(".search-open"),"click",function(e){e.preventDefault(),document.querySelector(".search-screen").style.display="block",requestAnimationFrame(function(){document.querySelector(".search-screen").style.opacity=1}),document.getElementById("search-input").focus(),h(document,"keyup",f)}),h(document.querySelector(".search-close"),"click",function(e){e.preventDefault(),m()});var p=function(e){for(var t=document.querySelectorAll(e),n=0;n<t.length;n++)t[n].innerHTML=i(t[n].getAttribute("datetime"),{addSuffix:!0,locale:r})};p(".article-time time"),p(".comment-metadata time")},{"date-fns/distance_in_words_to_now":8,"date-fns/locale/fr":16,fontfaceobserver:18,"headroom.js":19}]},{},[20]);
//# sourceMappingURL=bootstrap-19e8dae5e4.js.map