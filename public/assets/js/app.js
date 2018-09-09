"use strict";function _classCallCheck(instance,Constructor){if(!(instance instanceof Constructor)){throw new TypeError("Cannot call a class as a function")}}function _defineProperties(target,props){for(var i=0;i<props.length;i++){var descriptor=props[i];descriptor.enumerable=descriptor.enumerable||false;descriptor.configurable=true;if("value"in descriptor)descriptor.writable=true;Object.defineProperty(target,descriptor.key,descriptor)}}function _createClass(Constructor,protoProps,staticProps){if(protoProps)_defineProperties(Constructor.prototype,protoProps);if(staticProps)_defineProperties(Constructor,staticProps);return Constructor}var Api=function(){function Api(url){_classCallCheck(this,Api);this.url=url;this.init()}_createClass(Api,[{key:"init",value:function init(){if(document.querySelector("#form")){this.form=document.querySelector("#form");this.token=document.querySelector("input[name=token]").value}}},{key:"get",value:function get(path){return fetch(this.url+path).then(function(response){return response.json()})}},{key:"post",value:function post(path){var data={fname:"Sean",lname:"Kellr",age:"26",smoker:true,email:"spkelld@gmail.com",token:this.token};return fetch(this.url+path,{method:"POST",mode:"cors",cache:"no-cache",credentials:"same-origin",headers:{"Content-Type":"application/json; charset=utf-8"},redirect:"follow",referrer:"no-referrer",body:JSON.stringify(data)}).then(function(response){return response.json()})}}]);return Api}();var api=new Api("http://localhost:8080");api.form.addEventListener("submit",function(e){e.preventDefault();api.post("/api/create").then(function(response){return console.log("Success:",JSON.stringify(response))}).catch(function(error){return console.error("Error:",error)})});