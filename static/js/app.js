webpackJsonp([1],{"+skl":function(t,e){},DQph:function(t,e){},E99L:function(t,e){},NHnr:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=a("7+uW"),r=a("7t+N"),s=a.n(r),i={name:"App",components:{},data:function(){return{path:this.$store.state.path_curent}},computed:{data:function(){var t=window.MENU;return this.formatMenu(t,"")}},mounted:function(){},methods:{formatMenu:function(t,e){var a=this,n=[];for(var r in t){var s={};isNaN(r)?function(){var i=e=e+"/"+r;s.title=r,s.expand=!0,s.render=function(t,e){e.root,e.node;var n=e.data;return t("span",{style:{display:"inline-block",width:"100%"}},[t("span",[t("Icon",{props:{type:"ios-folder-outline"},style:{marginRight:"8px"}}),t("a",{props:{type:"text"},style:{fontSize:"14px"},on:{click:function(){a.getParent(i)}}},n.title)])])},s.children=a.formatMenu(t[r],e),n.push(s)}():function(){var i=e+"/"+t[r];s.title=a.formatTitle(t[r]),s.render=function(t,e){e.root,e.node;var n=e.data;return t("span",{style:{display:"inline-block",width:"100%"}},[t("span",[t("Icon",{props:{type:"ios-paper-outline"},style:{marginRight:"8px"}}),t("a",{props:{type:"text"},style:{fontSize:"14px"},on:{click:function(){a.goto(i)}}},n.title)])])},n.push(s)}()}return n},formatTitle:function(t){var e=t.split("_");return t.replace(e[0]+"_","").replace(".qwk","")},goto:function(t){window.location.href="index.php?to="+encodeURIComponent(t)},getParent:function(t){"/add"!==this.$route.path&&"/edit"!==this.$route.path||(this.$store.state.path_selected=t)},edit:function(){var t=this;s.a.ajax({url:"save.php",method:"post",type:"json",data:{file:window.CURPATH,action:"check"},success:function(e){0==e.err?t.$router.push({path:"/edit"}):t.$Message.error(e.msg)}})}}},o={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"layout"},[a("Layout",[a("Header",[a("Menu",{attrs:{mode:"horizontal",theme:"dark","active-name":"1"}},[a("div",{staticClass:"layout-logo"},[t._v("qWiKi")]),t._v(" "),a("div",{staticClass:"layout-nav"},[a("MenuItem",{attrs:{name:"1"}},[a("router-link",{attrs:{to:"/add"}},[a("Icon",{attrs:{type:"edit"}}),t._v("\n                        写文档\n                      ")],1)],1)],1)])],1),t._v(" "),a("Layout",[a("Sider",{style:{background:"#fff"},attrs:{"hide-trigger":""}},[a("Tree",{attrs:{data:t.data,render:t.renderContent}})],1),t._v(" "),a("Layout",{style:{padding:"0 24px 24px"}},[a("Breadcrumb",{style:{margin:"24px 0"}},t._l(t.$store.state.path_curent,function(e,n){return a("BreadcrumbItem",[t._v("\n                      "+t._s(e)+"\n                      "),n===t.$store.state.path_curent.length-1&&"/add"!==t.$route.path&&"/edit"!==t.$route.path?a("span",[a("a",{attrs:{href:"javascript:void(0);"},on:{click:t.edit}},[a("Icon",{attrs:{type:"compose"}})],1)]):t._e()])})),t._v(" "),a("Content",{style:{padding:"24px",minHeight:"280px",background:"#fff"}},[a("router-view")],1)],1)],1)],1)],1)},staticRenderFns:[]};var d=a("VU/8")(i,o,!1,function(t){a("E99L")},"data-v-65acd46a",null).exports,l=a("/ocq"),c=a("OS1Z"),u={name:"Index",data:function(){return{attachments:window.ATTACHMENTS}},computed:{html:function(){var t=window.HTML.html,e=c.markdownIt.render(t);return e=e.replace(/(\n\n)+/g,"\n"),this.nl2br(e)}},methods:{nl2br:function(t,e){return(t+"").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1"+(e||void 0===e?"<br />":"<br>")+"$2")}}},p={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"markdown-body",domProps:{innerHTML:t._s(t.html)}}),t._v(" "),t.attachments.length>0?a("div",{staticClass:"attachs"},[a("div",[t._v("附件")]),t._v(" "),a("ul",t._l(t.attachments,function(e,n){return a("li",[a("a",{attrs:{href:"attachments/"+e.url,target:"_blank"}},[a("Icon",{attrs:{type:"android-attach"}}),t._v(" "+t._s(e.name))],1)])}))]):t._e()])},staticRenderFns:[]};var h=a("VU/8")(u,p,!1,function(t){a("DQph")},"data-v-e3dbdda8",null).exports,m=a("mvHQ"),f=a.n(m),v=(a("pw1w"),a("mtWM")),g=a.n(v),_={name:"Add",components:{mavonEditor:c.mavonEditor},data:function(){return{tag:0,title:"",attachments:[],default_files:[],html:"",edit:0}},mounted:function(){if("/add"===this.$route.path)this.$store.state.path_curent=["","新增文档"],this.$store.state.path_selected="/",this.edit=0;else{this.$store.state.path_curent=window.PATH;var t=window.PATH.slice(0,-1).join("/");this.$store.state.path_selected=(""===t?"/":"")+t,this.title=window.TITLE,this.default_files=window.ATTACHMENTS,this.attachments=this.formatAttach(window.ATTACHMENTS),this.html=window.HTML.html,this.edit=1}},methods:{$imgAdd:function(t,e){var a=this,n=new FormData;n.append("image",e),n.append("type","image"),g()({url:"upload.php",method:"post",data:n,headers:{"Content-Type":"multipart/form-data"}}).then(function(e){var n=e.data;0==n.err?a.$refs.md.$img2Url(t,"images/"+n.file.url):a.$Message.error(n.msg)})},successHandle:function(t,e,a){t.file&&(t.file.relname=e.name),this.attachments.push(t.file),t.err>0&&this.$Message.error(t.msg)},errHandle:function(t,e,a){this.$Message.error(t)},removeFile:function(t,e){var a=-1;for(var n in this.attachments)this.attachments[n].relname===t.name&&(a=n);-1!==a&&this.attachments.splice(a,1)},saveHtml:function(t){var e=this;if(""==this.title)return this.$Message.error("请填写标题"),!1;s.a.ajax({url:"save.php",method:"post",type:"json",data:{path:this.$store.state.path_selected,title:this.title,content:t,attachments:f()(this.unformatAttach(this.attachments)),file:window.CURPATH,edit:this.edit},success:function(t){0==t.err?(e.$Message.success(t.msg),window.location.href="index.php?to="+t.to):e.$Message.error(t.msg)}})},formatAttach:function(t){for(var e=0;e<t.length;e++)t[e].relname=t[e].name;return t},unformatAttach:function(t){for(var e=[],a=0;a<t.length;a++){var n={};n.name=t[a].name,n.url=t[a].url,e.push(n)}return e}}},w={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"editor"}},[a("div",{staticClass:"mt15"},[a("Row",[a("Col",{attrs:{span:"8"}},[a("Input",{staticStyle:{width:"100%",height:"50"},attrs:{placeholder:"path"},model:{value:t.$store.state.path_selected,callback:function(e){t.$set(t.$store.state,"path_selected",e)},expression:"$store.state.path_selected"}})],1),t._v(" "),a("Col",{attrs:{span:"2"}}),t._v(" "),a("Col",{attrs:{span:"14"}},[a("Input",{staticStyle:{width:"100%",height:"50","margin-left":"20px"},attrs:{placeholder:"title"},model:{value:t.title,callback:function(e){t.title=e},expression:"title"}})],1)],1)],1),t._v(" "),a("div",{staticClass:"mt15"},[a("Upload",{attrs:{multiple:"false",type:"drag","on-error":t.errHandle,"on-success":t.successHandle,"on-remove":t.removeFile,"default-file-list":t.default_files,action:"upload.php"}},[a("div",{staticStyle:{padding:"20px 0"}},[a("Icon",{staticStyle:{color:"#3399ff"},attrs:{type:"ios-cloud-upload",size:"52"}}),t._v(" "),a("p",[t._v("Click or drag attachments here to upload")])],1)])],1),t._v(" "),a("div",{staticClass:"mt15"},[a("mavon-editor",{ref:"md",staticStyle:{height:"100%"},attrs:{value:t.html},on:{imgAdd:t.$imgAdd,save:t.saveHtml}})],1)])},staticRenderFns:[]};var y=a("VU/8")(_,w,!1,function(t){a("pZwk")},"data-v-0120e67a",null).exports;n.default.use(l.a);var $=new l.a({routes:[{path:"/",name:"Index",component:h},{path:"/add",name:"Add",component:y},{path:"/edit",name:"Add",component:y}]}),x=a("BTaQ"),T=a.n(x),A=(a("+skl"),a("NYxO"));n.default.config.productionTip=!1,n.default.use(T.a),n.default.use(A.a);var k=new A.a.Store({state:{path_selected:"/",path_curent:window.PATH},mutations:{}});new n.default({el:"#app",router:$,store:k,components:{App:d},template:"<App/>"})},pZwk:function(t,e){},pw1w:function(t,e){}},["NHnr"]);
//# sourceMappingURL=app.js.map