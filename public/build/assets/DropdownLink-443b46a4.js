import{aD as h,aI as w,h as c,aR as b,o as i,f as v,b as o,r,i as d,bq as f,a as k,w as p,n as g,q as x,c as C,u as $,j as S}from"./app-8bacd1d7.js";const E={class:"relative"},D={__name:"Dropdown",props:{align:{type:String,default:"right"},width:{type:String,default:"48"},contentClasses:{type:String,default:"py-1 bg-gray-800 border border-gray-700"}},setup(a){const t=a,l=n=>{e.value&&n.key==="Escape"&&(e.value=!1)};h(()=>document.addEventListener("keydown",l)),w(()=>document.removeEventListener("keydown",l));const m=c(()=>({48:"w-48"})[t.width.toString()]),y=c(()=>t.align==="left"?"origin-top-left left-0":t.align==="right"?"origin-top-right right-0":t.align==="bottom-left"?"origin-bottom-left left-0 bottom-full ml-6":"origin-top"),e=b(!1);return(n,s)=>(i(),v("div",E,[o("div",{onClick:s[0]||(s[0]=u=>e.value=!e.value)},[r(n.$slots,"trigger")]),d(o("div",{class:"fixed inset-0 z-40",onClick:s[1]||(s[1]=u=>e.value=!1)},null,512),[[f,e.value]]),k(x,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"transform opacity-0 scale-95","enter-to-class":"transform opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"transform opacity-100 scale-100","leave-to-class":"transform opacity-0 scale-95"},{default:p(()=>[d(o("div",{class:g(["absolute z-50 mt-2 rounded-md shadow-lg",[m.value,y.value]]),style:{display:"none"},onClick:s[2]||(s[2]=u=>e.value=!1)},[o("div",{class:g(["rounded-md ring-1 ring-black ring-opacity-5",a.contentClasses])},[r(n.$slots,"content")],2)],2),[[f,e.value]])]),_:3})]))}},_={key:1,class:"cursor-pointer block w-full px-4 py-2 text-left text-sm leading-5 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"},z={__name:"DropdownLink",props:{href:String},setup(a){return(t,l)=>a.href?(i(),C($(S),{key:0,href:a.href,class:"block w-full px-4 py-2 text-left text-sm leading-5 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:bg-gray-700 transition duration-150 ease-in-out"},{default:p(()=>[r(t.$slots,"default")]),_:3},8,["href"])):(i(),v("span",_,[r(t.$slots,"default")]))}};export{z as _,D as a};