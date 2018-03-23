"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};!function(t,e){var n=function(i,d){if(!d.getElementsByClassName)return;var u,f,m=d.documentElement,o=i.Date,a=i.HTMLPictureElement,r="addEventListener",y="getAttribute",n=i[r],z=i.setTimeout,s=i.requestAnimationFrame||z,l=i.requestIdleCallback,v=/^picture$/i,c=["load","error","lazyincluded","_lazyloaded"],g={},h=Array.prototype.forEach,p=function(t,e){return g[e]||(g[e]=new RegExp("(\\s|^)"+e+"(\\s|$)")),g[e].test(t[y]("class")||"")&&g[e]},b=function(t,e){p(t,e)||t.setAttribute("class",(t[y]("class")||"").trim()+" "+e)},C=function(t,e){var n;(n=p(t,e))&&t.setAttribute("class",(t[y]("class")||"").replace(n," "))},A=function t(e,n,i){var a=i?r:"removeEventListener";i&&t(e,n),c.forEach(function(t){e[a](t,n)})},E=function(t,e,n,i,a){var o=d.createEvent("CustomEvent");return n||(n={}),n.instance=u,o.initCustomEvent(e,!i,!a,n),t.dispatchEvent(o),o},_=function(t,e){var n;!a&&(n=i.picturefill||f.pf)?n({reevaluate:!0,elements:[t]}):e&&e.src&&(t.src=e.src)},w=function(t,e){return(getComputedStyle(t,null)||{})[e]},M=function(t,e,n){for(n=n||t.offsetWidth;n<f.minSize&&e&&!t._lazysizesWidth;)n=e.offsetWidth,e=e.parentNode;return n},N=(e=[],T=[],B=e,F=function(){var t=B;for(B=e.length?T:e,x=!(W=!0);t.length;)t.shift()();W=!1},L=function(t,e){W&&!e?t.apply(this,arguments):(B.push(t),x||(x=!0,(d.hidden?z:s)(F)))},L._lsFlush=F,L),t=function(n,t){return t?function(){N(n)}:function(){var t=this,e=arguments;N(function(){n.apply(t,e)})}},S=function(t){var e,n,i=function(){e=null,t()},a=function t(){var e=o.now()-n;e<99?z(t,99-e):(l||i)(i)};return function(){n=o.now(),e||(e=z(a,99))}};var W,x,e,T,B,F,L;!function(){var t,e={lazyClass:"lazyload",loadedClass:"lazyloaded",loadingClass:"lazyloading",preloadClass:"lazypreload",errorClass:"lazyerror",autosizesClass:"lazyautosizes",srcAttr:"data-src",srcsetAttr:"data-srcset",sizesAttr:"data-sizes",minSize:40,customMedia:{},init:!0,expFactor:1.5,hFac:.8,loadMode:2,loadHidden:!0,ricTimeout:0,throttleDelay:125};for(t in f=i.lazySizesConfig||i.lazysizesConfig||{},e)t in f||(f[t]=e[t]);i.lazySizesConfig=f,z(function(){f.init&&D()})}();var R=(ct=/^img$/i,dt=/^iframe$/i,ut="onscroll"in i&&!/glebot/.test(navigator.userAgent),ft=0,mt=0,yt=-1,zt=function t(e){mt--,e&&e.target&&A(e.target,t),(!e||mt<0||!e.target)&&(mt=0)},vt=function(t,e){var n,i=t,a="hidden"==w(d.body,"visibility")||"hidden"!=w(t,"visibility");for(U-=e,Y+=e,V-=e,X+=e;a&&(i=i.offsetParent)&&i!=d.body&&i!=m;)(a=0<(w(i,"opacity")||1))&&"visible"!=w(i,"overflow")&&(n=i.getBoundingClientRect(),a=X>n.left&&V<n.right&&Y>n.top-1&&U<n.bottom+1);return a},gt=function(){var t,e,n,i,a,o,r,s,l,c=u.elements;if((G=f.loadMode)&&mt<8&&(t=c.length)){e=0,yt++,null==tt&&("expand"in f||(f.expand=500<m.clientHeight&&500<m.clientWidth?500:370),Z=f.expand,tt=Z*f.expFactor),ft<tt&&mt<1&&2<yt&&2<G&&!d.hidden?(ft=tt,yt=0):ft=1<G&&1<yt&&mt<6?Z:0;for(;e<t;e++)if(c[e]&&!c[e]._lazyRace)if(ut)if((s=c[e][y]("data-expand"))&&(o=1*s)||(o=ft),l!==o&&(K=innerWidth+o*et,Q=innerHeight+o,r=-1*o,l=o),n=c[e].getBoundingClientRect(),(Y=n.bottom)>=r&&(U=n.top)<=Q&&(X=n.right)>=r*et&&(V=n.left)<=K&&(Y||X||V||U)&&(f.loadHidden||"hidden"!=w(c[e],"visibility"))&&(q&&mt<3&&!s&&(G<3||yt<4)||vt(c[e],o))){if(_t(c[e]),a=!0,9<mt)break}else!a&&q&&!i&&mt<4&&yt<4&&2<G&&(I[0]||f.preloadAfterLoad)&&(I[0]||!s&&(Y||X||V||U||"auto"!=c[e][y](f.sizesAttr)))&&(i=I[0]||c[e]);else _t(c[e]);i&&!a&&_t(i)}},nt=gt,at=0,ot=f.throttleDelay,rt=f.ricTimeout,st=function(){it=!1,at=o.now(),nt()},lt=l&&49<rt?function(){l(st,{timeout:rt}),rt!==f.ricTimeout&&(rt=f.ricTimeout)}:t(function(){z(st)},!0),ht=function(t){var e;(t=!0===t)&&(rt=33),it||(it=!0,(e=ot-(o.now()-at))<0&&(e=0),t||e<9?lt():z(lt,e))},pt=function(t){b(t.target,f.loadedClass),C(t.target,f.loadingClass),A(t.target,Ct),E(t.target,"lazyloaded")},bt=t(pt),Ct=function(t){bt({target:t.target})},At=function(t){var e,n=t[y](f.srcsetAttr);(e=f.customMedia[t[y]("data-media")||t[y]("media")])&&t.setAttribute("media",e),n&&t.setAttribute("srcset",n)},Et=t(function(t,e,n,i,a){var o,r,s,l,c,d;(c=E(t,"lazybeforeunveil",e)).defaultPrevented||(i&&(n?b(t,f.autosizesClass):t.setAttribute("sizes",i)),r=t[y](f.srcsetAttr),o=t[y](f.srcAttr),a&&(s=t.parentNode,l=s&&v.test(s.nodeName||"")),d=e.firesLoad||"src"in t&&(r||o||l),c={target:t},d&&(A(t,zt,!0),clearTimeout(j),j=z(zt,2500),b(t,f.loadingClass),A(t,Ct,!0)),l&&h.call(s.getElementsByTagName("source"),At),r?t.setAttribute("srcset",r):o&&!l&&(dt.test(t.nodeName)?function(e,n){try{e.contentWindow.location.replace(n)}catch(t){e.src=n}}(t,o):t.src=o),a&&(r||l)&&_(t,{src:o})),t._lazyRace&&delete t._lazyRace,C(t,f.lazyClass),N(function(){(!d||t.complete&&1<t.naturalWidth)&&(d?zt(c):mt--,pt(c))},!0)}),_t=function(t){var e,n=ct.test(t.nodeName),i=n&&(t[y](f.sizesAttr)||t[y]("sizes")),a="auto"==i;(!a&&q||!n||!t[y]("src")&&!t.srcset||t.complete||p(t,f.errorClass)||!p(t,f.lazyClass))&&(e=E(t,"lazyunveilread").detail,a&&k.updateElem(t,!0,t.offsetWidth),t._lazyRace=!0,mt++,Et(t,e,a,i,n))},wt=function t(){if(!q)if(o.now()-J<999)z(t,999);else{var e=S(function(){f.loadMode=3,ht()});q=!0,f.loadMode=3,ht(),n("scroll",function(){3==f.loadMode&&(f.loadMode=2),e()},!0)}},{_:function(){J=o.now(),u.elements=d.getElementsByClassName(f.lazyClass),I=d.getElementsByClassName(f.lazyClass+" "+f.preloadClass),et=f.hFac,n("scroll",ht,!0),n("resize",ht,!0),i.MutationObserver?new MutationObserver(ht).observe(m,{childList:!0,subtree:!0,attributes:!0}):(m[r]("DOMNodeInserted",ht,!0),m[r]("DOMAttrModified",ht,!0),setInterval(ht,999)),n("hashchange",ht,!0),["focus","mouseover","click","load","transitionend","animationend","webkitAnimationEnd"].forEach(function(t){d[r](t,ht,!0)}),/d$|^c/.test(d.readyState)?wt():(n("load",wt),d[r]("DOMContentLoaded",ht),z(wt,2e4)),u.elements.length?(gt(),N._lsFlush()):ht()},checkElems:ht,unveil:_t}),k=(O=t(function(t,e,n,i){var a,o,r;if(t._lazysizesWidth=i,i+="px",t.setAttribute("sizes",i),v.test(e.nodeName||""))for(a=e.getElementsByTagName("source"),o=0,r=a.length;o<r;o++)a[o].setAttribute("sizes",i);n.detail.dataAttr||_(t,n.detail)}),P=function(t,e,n){var i,a=t.parentNode;a&&(n=M(t,a,n),(i=E(t,"lazybeforesizes",{width:n,dataAttr:!!e})).defaultPrevented||(n=i.detail.width)&&n!==t._lazysizesWidth&&O(t,a,i,n))},$=S(function(){var t,e=H.length;if(e)for(t=0;t<e;t++)P(H[t])}),{_:function(){H=d.getElementsByClassName(f.autosizesClass),n("resize",$)},checkElems:$,updateElem:P}),D=function t(){t.i||(t.i=!0,k._(),R._())};var H,O,P,$;var I,q,j,G,J,K,Q,U,V,X,Y,Z,tt,et,nt,it,at,ot,rt,st,lt,ct,dt,ut,ft,mt,yt,zt,vt,gt,ht,pt,bt,Ct,At,Et,_t,wt;return u={cfg:f,autoSizer:k,loader:R,init:D,uP:_,aC:b,rC:C,hC:p,fire:E,gW:M,rAF:N}}(t,t.document);t.lazySizes=n,"object"==("undefined"==typeof module?"undefined":_typeof(module))&&module.exports&&(module.exports=n)}(window);
//# sourceMappingURL=lazysizes-a356481305.js.map
