import{bt as y,aD as f,aI as v,h as w,o as h,c as x,a as o,w as l,i as n,bq as c,b as a,q as i,n as p,r as b,g,m as k}from"./app-8bacd1d7.js";const _={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},B=a("div",{class:"absolute inset-0 bg-gray-900 opacity-90"},null,-1),C=[B],S={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:m}){const s=e;y(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const r=()=>{s.closeable&&m("close")},d=t=>{t.key==="Escape"&&s.show&&r()};f(()=>document.addEventListener("keydown",d)),v(()=>{document.removeEventListener("keydown",d),document.body.style.overflow=null});const u=w(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(t,E)=>(h(),x(k,{to:"body"},[o(i,{"leave-active-class":"duration-200"},{default:l(()=>[n(a("div",_,[o(i,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:l(()=>[n(a("div",{class:"fixed inset-0 transform transition-all",onClick:r},C,512),[[c,e.show]])]),_:1}),o(i,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:l(()=>[n(a("div",{class:p(["mb-6 bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",u.value])},[e.show?b(t.$slots,"default",{key:0}):g("",!0)],2),[[c,e.show]])]),_:3})],512),[[c,e.show]])]),_:3})]))}};export{S as _};