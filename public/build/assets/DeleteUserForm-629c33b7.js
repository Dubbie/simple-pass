import{o as i,f as u,r as y,aR as m,T as h,a as t,w as l,b as s,au as x,d,u as r,bz as b,n as v}from"./app-8bacd1d7.js";import{_ as k}from"./_plugin-vue_export-helper-c27b6911.js";import{_ as $}from"./InputError-3108fcc8.js";import{_ as C,a as D}from"./TextInput-aaebc765.js";import{_ as B}from"./Modal-cade75ba.js";const V={},S={class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"};function U(a,o){return i(),u("button",S,[y(a.$slots,"default")])}const _=k(V,[["render",U]]),A=["type"],K={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(a){return(o,n)=>(i(),u("button",{type:a.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"},[y(o.$slots,"default")],8,A))}},N={class:"space-y-6"},P=s("header",null,[s("h2",{class:"text-lg font-medium text-gray-900"},"Delete Account"),s("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ")],-1),T={class:"p-6"},z=s("h2",{class:"text-lg font-medium text-gray-900"}," Are you sure you want to delete your account? ",-1),E=s("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ",-1),F={class:"mt-6"},I={class:"mt-6 flex justify-end"},H={__name:"DeleteUserForm",setup(a){const o=m(!1),n=m(null),e=h({password:""}),g=()=>{o.value=!0,x(()=>n.value.focus())},f=()=>{e.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>c(),onError:()=>n.value.focus(),onFinish:()=>e.reset()})},c=()=>{o.value=!1,e.reset()};return(O,p)=>(i(),u("section",N,[P,t(_,{onClick:g},{default:l(()=>[d("Delete Account")]),_:1}),t(B,{show:o.value,onClose:c},{default:l(()=>[s("div",T,[z,E,s("div",F,[t(C,{for:"password",value:"Password",class:"sr-only"}),t(D,{id:"password",ref_key:"passwordInput",ref:n,modelValue:r(e).password,"onUpdate:modelValue":p[0]||(p[0]=w=>r(e).password=w),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:b(f,["enter"])},null,8,["modelValue","onKeyup"]),t($,{message:r(e).errors.password,class:"mt-2"},null,8,["message"])]),s("div",I,[t(K,{onClick:c},{default:l(()=>[d(" Cancel ")]),_:1}),t(_,{class:v(["ml-3",{"opacity-25":r(e).processing}]),disabled:r(e).processing,onClick:f},{default:l(()=>[d(" Delete Account ")]),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{H as default};