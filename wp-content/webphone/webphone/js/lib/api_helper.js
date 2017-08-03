function HandleEventMessage(event){var res=event.data;if(api_helper.isNull(res))return void webphone_api.Log("ERROR, webphone_api window.onmessage message is NULL");if((res.indexOf("webphone_api.")>=0||"initialize_connection"===res)&&(parent_page_i=event.source,origindomain_i=event.origin),"webphone_api.getEvents"===res)return void webphone_api.getEvents(function(e){SendMessageToParent('getEvents_IFRAME("'+e+'")')});if("webphone_api.onLoaded"===res)return void webphone_api.onLoaded(function(){SendMessageToParent("onLoaded_IFRAME()")});if("webphone_api.onStart"===res)return void webphone_api.onStart(function(){SendMessageToParent("onStart_IFRAME()")});if("webphone_api.onRegistered"===res)return void webphone_api.onRegistered(function(){SendMessageToParent("onRegistered_IFRAME()")});if("webphone_api.onUnRegistered"===res)return void webphone_api.onUnRegistered(function(){SendMessageToParent("onUnRegistered_IFRAME()")});if("webphone_api.onCallStateChange"===res)return void webphone_api.onCallStateChange(function(e,n,i,p,a){SendMessageToParent('onCallStateChange_IFRAME("'+e+'", "'+n+'", "'+i+'", "'+p+'", "'+a+'")')});if("webphone_api.onChat"===res)return void webphone_api.onChat(function(e,n,i){SendMessageToParent('onChat_IFRAME("'+e+'", "'+n+'", "'+i+'")')});if("webphone_api.onCdr"===res)return void webphone_api.onCdr(function(e,n,i,p,a){SendMessageToParent('onCdr_IFRAME("'+e+'", "'+n+'", "'+i+'", "'+p+'", "'+a+'")')});if(res.indexOf("webphone_api.getaudiodevicelist")>=0){var dev="",pos=res.indexOf("#");return pos>0&&(dev=res.substring(pos+1)),api_helper.isNull(dev)&&(dev=""),dev=api_helper.Trim(dev),void webphone_api.getaudiodevicelist(dev,function(e){SendMessageToParent('getaudiodevicelist_IFRAME("'+e+'")')})}if(res.indexOf("webphone_api.getaudiodevice")>=0){var dev="",pos=res.indexOf("#");return pos>0&&(dev=res.substring(pos+1)),api_helper.isNull(dev)&&(dev=""),dev=api_helper.Trim(dev),void webphone_api.getaudiodevice(dev,function(e){SendMessageToParent('getaudiodevice_IFRAME("'+e+'")')})}if(res.indexOf("webphone_api.getvolume")>=0){var dev="",pos=res.indexOf("#");return pos>0&&(dev=res.substring(pos+1)),api_helper.isNull(dev)&&(dev=""),dev=api_helper.Trim(dev),void webphone_api.getvolume(dev,function(e){SendMessageToParent('getvolume_IFRAME("'+e+'")')})}if(res.indexOf("webphone_api.getsipheader")>=0){var header="",pos=res.indexOf("#");return pos>0&&(header=res.substring(pos+1)),api_helper.isNull(header)&&(header=""),header=api_helper.Trim(header),void webphone_api.getsipheader(header,function(e){SendMessageToParent('getsipheader_IFRAME("'+e+'")')})}if(res.indexOf("webphone_api.getsipmessage")>=0){var params="",pos=res.indexOf("#");return pos>0&&(params=res.substring(pos+1)),void webphone_api.getsipmessage(params[0],params[1],function(e){SendMessageToParent('getsipmessage_IFRAME("'+e+'")')})}if("webphone_api.ondisplay"===res)return void webphone_api.ondisplay(function(e,n){SendMessageToParent('ondisplay_IFRAME("'+e+'", "'+n+'")')});if("webphone_api.getworkdir"===res)return void webphone_api.getworkdir(function(e){SendMessageToParent('getworkdir_IFRAME("'+e+'")')});if("webphone_api.getlastinvite"===res)return void webphone_api.getlastinvite(function(e){SendMessageToParent('getlastinvite_IFRAME("'+e+'")')});if("webphone_api.onLog"===res)return void webphone_api.onLog(function(e){SendMessageToParent('onLog_IFRAME("'+e+'")')});if(res.indexOf("webphone_api.getregfailreason")>=0){var ext="",pos=res.indexOf("#");return pos>0&&(ext=res.substring(pos+1)),api_helper.isNull(ext)&&(ext=""),ext=api_helper.Trim(ext),void webphone_api.getregfailreason(function(e){SendMessageToParent('getregfailreason_IFRAME("'+e+'")')},ext)}if(res.indexOf("webphone_api.setparameter")>=0){var param="",value="",pos=res.indexOf(",");return void(pos>0?(param=res.substring(0,pos),api_helper.isNull(param)&&(param=""),value=res.substring(pos+1),api_helper.isNull(value)&&(value=""),pos=param.indexOf("("),pos>0&&(param=param.substring(pos+1)),pos=value.lastIndexOf(")"),pos>0&&(value=value.substring(0,pos)),param=api_helper.Trim(param),value=api_helper.Trim(value),webphone_api.setparameter(param,value)):webphone_api.Log("ERROR, webphone_api: window.onmessage invalid setparameter: "+res))}if(res.indexOf("webphone_api.")>=0)try{eval(res)}catch(errin){webphone_api.LogEx("ERROR, api_helper window.onmessage eval: "+res,errin)}else"initialize_connection"!==res&&webphone_api.Log("EVENT, webphone_api: window.onmessage unhandled message: "+res)}function SendMessageToParent(e){try{if(api_helper.isNull(parent_page_i))return void webphone_api.Log("ERROR, webphone_api: SendMessageToParent, parent is NULL");parent_page_i.postMessage(e,origindomain_i)}catch(n){webphone_api.LogEx("ERROR, webphone_api: SendMessageToParent ",n)}}function IsIeVersion(e){try{if(void 0===e||null===e)return!1;var n=navigator.userAgent,i=n.indexOf("MSIE "),p=0;if(i>0&&(p=parseInt(n.substring(i+5,n.indexOf(".",i)),10),e===p))return!0}catch(a){LogEx("wphone IsIeVersion:",a)}return!1}function onInit(){flashapi_public.onInit()}function onEvent(e){flashapi_public.onEvent(e)}function onDebug(e){flashapi_public.onDebug(e)}function onConnected(e){flashapi_public.onConnected(e)}function onDisconnected(){flashapi_public.onDisconnected()}function onLogin(e,n,i){flashapi_public.onLogin(e,n,i)}function onLogout(e,n){flashapi_public.onLogout(e,n)}function onCallState(e,n){flashapi_public.onCallState(e,n)}function onIncomingCall(e,n,i,p,a){flashapi_public.onIncomingCall(e,n,i,p,a)}function onHangup(e,n){flashapi_public.onHangup(e,n)}function onDisplayUpdate(e,n,i){flashapi_public.onDisplayUpdate(e,n,i)}function onMakeCall(e,n,i){flashapi_public.onMakeCall(e,n,i)}function onAttach(e){flashapi_public.onAttach(e)}function webphonetojs(e){try{webphone_public.webphone_started=!0,window.webphone_pollstatus=!1,"undefined"!=typeof common_public&&null!==common_public?common_public.ReceiveNotifications(e):alert("webphonetojs common_public is not defined")}catch(n){"undefined"!=typeof common_public&&null!==common_public&&common_public.PutToDebugLogException(2,"wphone webphonetojs: ",n)}}try{console&&console.log&&console.log("Loading webphone API...")}catch(e){}var api_helper=function(){function e(e,arguments){a(e)||e.length<1||(n(),a(l)&&(l=[]),a(arguments)&&(arguments=[]),arguments.unshift(e),arguments.unshift(p().toString()),l.push(arguments))}function n(){a(d)&&(d=setInterval(function(){if(++h>1e4||h>1e4&&(a(l)||l.length<1||!0===webphone_api.webphone_loaded))return void 0!==d&&null!==d&&clearInterval(d),d=null,l=[],void(h=0);if(!(a(l)||l.length<1)&&!0===webphone_api.webphone_loaded){var e=l.shift();if(a(e)||e.length<2)return;var n=0;try{n=o(e[0])}catch(s){}e.shift();var t=e[0];if(a(t)||t.length<1)return void webphone_api.Log("ERROR, handle API function queue invalid name: "+t);if(p()-n>6e5)return void webphone_api.Log("ERROR, handle API function queue: "+t+" (too late)");e.shift();var r="";a(e)||(r=e.toString()),webphone_api.Log("EVENT, handle API function queue: "+t+" ("+r+");"),i(t,e)}},15))}function i(e,arguments){var n=window.plhandler[e];"function"==typeof n&&n.apply(window,arguments)}function p(){var e=new Date;return"undefine"!=typeof e&&null!==e?e.getTime():0}function a(e){try{return void 0===e||null===e}catch(n){}return!0}function t(e){try{return void 0!==e&&null!=e&&(e=e.toString(),!(null==(e=e.replace(/\s+/g,""))||e.length<1)&&!isNaN(e))}catch(n){}return!1}function o(e){try{return a(e)||!t(e)?null:(e=r(e," ",""),parseInt(e,10))}catch(n){}return null}function r(e,n,i){try{return a(e)||a(n)||a(i)?"":(e=e.toString(),e.split(n).join(i))}catch(p){}return""}function s(e){try{return a(e)||e.lenght<1?"":(e=e.toString(),e.replace(/^\s+|\s+$/g,""))}catch(n){}return e}var l=[],d=null,h=0;return{AddToQueue:e,StrToInt:o,Trim:s,IsNumber:t,isNull:a}}();webphone_api.parameters.issdk=!0,"undefined"==typeof window.pageissdk||null===window.pageissdk||0!=window.pageissdk&&"false"!=window.pageissdk||(webphone_api.parameters.issdk=!1),webphone_api.webrtc_socket=null,webphone_api.webphone_loaded=!1,webphone_api.dont_remove_remote_stream=!1,webphone_api.rt_loaded=!1,webphone_api.rt_canplay=!1,webphone_api.rbt_loaded=!1,webphone_api.rbt_canplay=!1,webphone_api.isscreensharecall=!1,webphone_api.iswebrtcengineworking=0,webphone_api.startInner=function(){return"undefined"==typeof plhandler||null===plhandler?(api_helper.AddToQueue("Start",[webphone_api.parameters,!1]),!1):plhandler.Start(webphone_api.parameters,!1)},webphone_api.getEvents=function(e){e&&"function"==typeof e&&(webphone_api.evcb=e)},webphone_api.stopengine=function(e){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.StopEngine(e):""},webphone_api.isserviceinstalled=function(e){if(!e||"function"!=typeof e)return void webphone_api.Log("ERROR, webphone_api: isserviceinstalled callback not defined");"undefined"!=typeof plhandler&&null!==plhandler?plhandler.IsServiceInstalled(e):(webphone_api.Log("ERROR, webphone_api: isserviceinstalled plhandler is not defined"),e(!1))},webphone_api.caniusewebrtc=function(){return"undefined"!=typeof plhandler&&null!==plhandler&&plhandler.CanIUseWebrtc()},webphone_api.getcallto=function(){return"undefined"!=typeof webphone_api.parameters.callto&&null!==webphone_api.parameters.callto?webphone_api.parameters.callto:""},webphone_api.sendchatiscomposing=function(e){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.SendChatIsComposing(e):""},webphone_api.GetIncomingDisplay=function(e){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.GetIncomingDisplay(e):""},webphone_api.HTTPKeepAlive=function(){"undefined"!=typeof plhandler&&null!==plhandler&&plhandler.HTTPKeepAlive()},webphone_api.GetOneStunSrv=function(){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.GetOneStunSrv():""},webphone_api.HandleWebrtcCodecs=function(e){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.HandleWebrtcCodecs(e):e},webphone_api.InsertApplet=function(e){"undefined"==typeof plhandler||null===plhandler?api_helper.AddToQueue("InsertApplet",[e]):plhandler.InsertApplet(e)},webphone_api.RecEvt=function(e){webphone_api.evcb&&"function"==typeof webphone_api.evcb&&webphone_api.evcb(e)},webphone_api.onLoadedCb=function(){webphone_api.loadedcb&&"function"==typeof webphone_api.loadedcb&&webphone_api.loadedcb()},webphone_api.onStartCb=function(){webphone_api.startcb&&"function"==typeof webphone_api.startcb&&webphone_api.startcb()},webphone_api.onRegisteredCb=function(){webphone_api.registeredcb&&"function"==typeof webphone_api.registeredcb&&webphone_api.registeredcb()},webphone_api.onUnRegisteredCb=function(e){webphone_api.unregisteredcb&&"function"==typeof webphone_api.unregisteredcb&&webphone_api.unregisteredcb(e)},webphone_api.onRegisterFailedCb=function(e){webphone_api.registerfailedcb&&"function"==typeof webphone_api.registerfailedcb&&webphone_api.registerfailedcb(e)},webphone_api.onCallStateChangeCb=function(e,n,i,p,a){if(webphone_api.callstatechangecb&&"function"==typeof webphone_api.callstatechangecb){try{webphone_api.Log("webphone: onCallStateChange: "+e+","+n+","+i+","+p+","+a)}catch(e){}webphone_api.callstatechangecb(e,n,i,p,a)}},webphone_api.onChatCb=function(e,n,i){webphone_api.chatcb&&"function"==typeof webphone_api.chatcb&&webphone_api.chatcb(e,n,i)},webphone_api.onCdrCb=function(e,n,i,p,a,t,o,r){webphone_api.cdrcb&&"function"==typeof webphone_api.cdrcb&&webphone_api.cdrcb(e,n,i,p,a,t,o,r)},webphone_api.onDTMFCb=function(e,n){webphone_api.cddtmf&&"function"==typeof webphone_api.cddtmf&&webphone_api.cddtmf(e,n)},webphone_api.onLogCb=function(e){webphone_api.logcb&&"function"==typeof webphone_api.logcb&&webphone_api.logcb(e)},webphone_api.onDisplayCb=function(e,n){webphone_api.displaycb&&"function"==typeof webphone_api.displaycb&&webphone_api.displaycb(e,n)};var dnotcb=null;webphone_api.GetDisplayableNotifications=function(e){e&&"function"==typeof e&&(dnotcb=e)},webphone_api.RecDisplayableNotifications=function(e){dnotcb&&"function"==typeof dnotcb&&dnotcb(e)},webphone_api.enterkeypress=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.EnterKeyPress():webphone_api.Log("ERROR, webphone_api: enterkeypress plhandler is not defined")},webphone_api.filetransfercallback=function(e){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.FileTransferCallback(e):webphone_api.Log("ERROR, webphone_api: filetransfercallback plhandler is not defined")},webphone_api.gettelsearchname=function(e,n){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.GetTelsearchName(e,n):(webphone_api.Log("ERROR, webphone_api: gettelsearchname plhandler is not defined"),"")},webphone_api.bwanswer=function(e){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.bwanswer(e):webphone_api.Log("ERROR, webphone_api: bwanswer plhandler is not defined")},webphone_api.onappexit=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.onappexit():webphone_api.Log("ERROR, webphone_api: onappexit plhandler is not defined")},webphone_api.needratingrequest=function(e){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.needratingrequest(e):webphone_api.Log("ERROR, webphone_api: needratingrequest plhandler is not defined")},webphone_api.ismobilebrowser=function(){return"undefined"!=typeof plhandler&&null!==plhandler?plhandler.IsMobileBrowser():(webphone_api.Log("ERROR, webphone_api: ismobilebrowser plhandler is not defined"),!1)},webphone_api.helpwindow=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.HelpWindow():webphone_api.Log("ERROR, webphone_api: helpwindow plhandler is not defined")},webphone_api.settingspage=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.SettingsPage():webphone_api.Log("ERROR, webphone_api: settingspage plhandler is not defined")},webphone_api.dialpage=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.DialPage():webphone_api.Log("ERROR, webphone_api: dialpage plhandler is not defined")},webphone_api.messageinboxpage=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.MessageInboxPage():webphone_api.Log("ERROR, webphone_api: messageinboxpage plhandler is not defined")},webphone_api.messagepage=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.MessagePage():webphone_api.Log("ERROR, webphone_api: messagepage plhandler is not defined")},webphone_api.addcontactpage=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.AddContactPage():webphone_api.Log("ERROR, webphone_api: addcontactpage plhandler is not defined")},webphone_api.unregisterEngine=function(e){"undefined"!=typeof plhandler&&null!==plhandler&&plhandler.UnregisterEngine(e)},webphone_api.GetBrowser=function(){try{var e=null,n=navigator.userAgent.toLowerCase();-1!==n.indexOf("edge")?("Edge",e="Edge"):-1!==n.indexOf("msie")&&-1===n.indexOf("opera")?("MSIE",e="MSIE"):-1!==n.indexOf("trident")||-1!==n.indexOf("Trident")?("MSIE",e="MSIE"):-1!==n.indexOf("iphone")?("Netscape Family",e="iPhone"):-1!==n.indexOf("firefox")&&-1===n.indexOf("opera")?("Netscape Family",e="Firefox"):-1!==n.indexOf("chrome")?("Netscape Family",e="Chrome"):-1!==n.indexOf("safari")?("Netscape Family",e="Safari"):-1!==n.indexOf("mozilla")&&-1===n.indexOf("opera")?("Netscape Family",e="Other"):-1!==n.indexOf("opera")?("Netscape Family",e="Opera"):("?",e="unknown")}catch(i){webphone_api.LogEx("wphone: GetBrowser",i)}return e},webphone_api.GetBrowserVersion=function(){try{var e=-1,n=webphone_api.GetBrowser(),i=navigator.userAgent.toLowerCase();if("Chrome"===n){var p=i.indexOf("chrome");p>0&&(i=i.substring(p+6)),null!=i&&(i=i.replace("/","")),p=i.indexOf("."),p>0&&(i=i.substring(0,p)),null!=i&&(i=api_helper.Trim(i),api_helper.IsNumber(i)&&(e=api_helper.StrToInt(i)))}else if("Firefox"===n){var p=i.indexOf("firefox");p>0&&(i=i.substring(p+7)),api_helper.isNull(i)||(i=i.replace("/","")),p=i.indexOf("."),p>0&&(i=i.substring(0,p)),api_helper.isNull(i)||(i=api_helper.Trim(i),api_helper.IsNumber(i)&&(e=api_helper.StrToInt(i)))}else if("MSIE"===n){var a=window.navigator.userAgent,t=a.indexOf("MSIE ");t>0&&(e=parseInt(a.substring(t+5,a.indexOf(".",t)),10));var o=a.indexOf("Trident/");if(o>0){var r=a.indexOf("rv:");e=parseInt(a.substring(r+3,a.indexOf(".",r)),10)}var s=a.indexOf("Edge/");s>0&&(e=parseInt(a.substring(s+5,a.indexOf(".",s)),10))}else if("Edge"===n){var p=i.indexOf("edge");p>0&&(i=i.substring(p+4)),api_helper.isNull(i)||(i=i.replace("/","")),p=i.indexOf("."),p>0&&(i=i.substring(0,p)),api_helper.isNull(i)||(i=api_helper.Trim(i),api_helper.IsNumber(i)&&(e=api_helper.StrToInt(i)))}!api_helper.isNull(e)&&api_helper.IsNumber(e)||(e=-1)}catch(l){webphone_api.LogEx("wphone: GetBrowserversion",l)}return e},webphone_api.SupportHtml5=function(){try{return!!document.createElement("canvas").getContext}catch(e){webphone_api.LogEx("wphone: SupportHtml5",e)}return!1},webphone_api.SupportHtml5=function(){try{return!!document.createElement("canvas").getContext}catch(e){webphone_api.LogEx("wphone: SupportHtml5",e)}return!1},webphone_api.SetCookie=function(e,n,i){try{if(void 0===e||null===e||void 0===n||null===n)return!1;var p="";if(void 0!==i&&null!==i){var a=new Date;a.setTime(a.getTime()+24*i*60*60*1e3),p="; expires="+a.toGMTString()}else p="";document.cookie=e+"="+n+p+"; path=/",webphone_api.Log("EVENT, apicookie saved to cookie: "+e+"="+n)}catch(t){webphone_api.LogEx("ERROR, file: SetCookie: ",t)}},webphone_api.GetCookie=function(e){try{if(void 0===e||null===e)return"";for(var n=e+"=",i=document.cookie.split(";"),p=0;p<i.length;p++){for(var a=i[p];" "===a.charAt(0);)a=a.substring(1,a.length);if(0===a.indexOf(n)){var t=a.substring(n.length,a.length);return webphone_api.Log("EVENT, apicookie read: "+e+"="+t),t}}}catch(o){webphone_api.LogEx("ERROR, file: GetCookie ",o)}return""},webphone_api.getlogsex=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.getlogsex():webphone_api.Log("ERROR, webphone_api: getlogsex plhandler is not defined")},webphone_api.importcontacts=function(){"undefined"!=typeof plhandler&&null!==plhandler?plhandler.ImportContacts():webphone_api.Log("ERROR, webphone_api: importcontacts plhandler is not defined")},webphone_api.getmaxchromeversionforjava=function(){try{var e=webphone_api.parameters.javamaxchromeversion;(void 0===e||null===e||e.length<1||!1===api_helper.IsNumber(e))&&(e="42");return api_helper.StrToInt(e)}catch(n){webphone_api.LogEx("ERROR, webphone_api: getmaxchromeversionforjava ",n)}return 42},webphone_api.getstringresource=function(e){try{if("undefined"!=typeof plhandler&&null!==plhandler)return plhandler.getstringresource(e);webphone_api.Log("ERROR, webphone_api: getstringresource plhandler is not defined")}catch(n){webphone_api.LogEx("ERROR, webphone_api: getstringresource ",n)}return""},webphone_api.ShowToast=function(e,n,i){try{"undefined"!=typeof plhandler&&null!==plhandler?plhandler.ShowToast(e,n,i):webphone_api.Log("ERROR, webphone_api: ShowToast plhandler is not defined")}catch(p){webphone_api.LogEx("ERROR, webphone_api: ShowToast ",p)}},webphone_api.AlertDialog=function(e,n,i){try{"undefined"!=typeof plhandler&&null!==plhandler?plhandler.AlertDialog(e,n,i):webphone_api.Log("ERROR, webphone_api: AlertDialog plhandler is not defined")}catch(p){webphone_api.LogEx("ERROR, webphone_api: AlertDialog ",p)}},webphone_api.flagrestartwebrtc=!0,webphone_api.flashdeepdetect=!1;var parent_page_i=null,origindomain_i="";window.addEventListener?window.addEventListener("message",HandleEventMessage,!1):window.attachEvent?window.attachEvent("message",HandleEventMessage):webphone_api.Log("ERROR, webphone_api: addEventListener message cannot attach event listener"),webphone_api.cacheMediaStream=!0,webphone_api.API_SetParameter=function(e,n){return webphone_api.setparameter(e,n)},webphone_api.API_SetCredentials=function(e,n,i,p,a){return plhandler.API_SetCredentials(e,n,i,p,a)},webphone_api.API_SetCredentialsMD5=function(e,n,i,p){return plhandler.API_SetCredentialsMD5(e,n,i,p)},webphone_api.API_Start=function(){return webphone_api.start()},webphone_api.API_StartStack=function(){return webphone_api.start()},webphone_api.API_Register=function(e,n,i,p,a){return webphone_api.setparameter("serveraddress",e),webphone_api.setparameter("sipusername",n),webphone_api.setparameter("password",i),webphone_api.setparameter("displayname",a),webphone_api.start()},webphone_api.API_Unregister=function(){return webphone_api.unregister()},webphone_api.API_CheckVoicemail=function(e){return plhandler.API_CheckVoicemail(e)},webphone_api.API_SetLine=function(e){return plhandler.API_SetLine(e)},webphone_api.API_GetLine=function(){return plhandler.API_GetLine(line)},webphone_api.API_GetLineStatus=function(e){return plhandler.API_GetLineStatus(e)},webphone_api.API_Call=function(e,n){return webphone_api.call(n)},webphone_api.API_CallEx=function(e,n,i){return webphone_api.API_Call(e,n,0)},webphone_api.API_Hangup=function(e,n){return webphone_api.hangup()},webphone_api.API_Accept=function(e){return webphone_api.accept()},webphone_api.API_Reject=function(e){return webphone_api.reject()},webphone_api.API_Forward=function(e,n){return plhandler.API_Forward(e,n)},webphone_api.API_Transfer=function(e,n){return webphone_api.transfer(n)},webphone_api.API_MuteEx=function(e,n,i){return webphone_api.mute(n,i)},webphone_api.API_IsMuted=function(e){return plhandler.API_IsMuted(e)},webphone_api.API_IsOnHold=function(e){return plhandler.API_IsOnHold(e)},webphone_api.API_Hold=function(e,n){return webphone_api.hold(n)},webphone_api.API_Conf=function(e){return webphone_api.conference(e)},webphone_api.API_Dtmf=function(e,n){return webphone_api.dtmf(n)},webphone_api.API_SendChat=function(e,n,i){return webphone_api.sendchat(n,i)},webphone_api.API_AudioDevice=function(){return webphone_api.audiodevice()},webphone_api.API_SetVolume=function(e,n){return webphone_api.setvolume(e,n)},webphone_api.API_GetAudioDeviceList=function(e){return plhandler.API_GetAudioDeviceList(e)},webphone_api.API_GetAudioDevice=function(e){return plhandler.API_GetAudioDevice(e)},webphone_api.API_SetAudioDevice=function(e,n,i){return plhandler.API_SetAudioDevice(e)},webphone_api.API_GetVolume=function(e){return plhandler.API_GetVolume(e)},webphone_api.API_PlaySound=function(e,n,i,p,a,t,o,r,s){return plhandler.PlaySound(e,n,i,p,a,t,o,r,s)},webphone_api.LogEx=function(e,n){api_helper.isNull(e)||(api_helper.isNull(n)||(e="ERROR,"+e+" "+n),webphone_api.Log(e))},webphone_api.Log=function(e){api_helper.isNull(e)||e.length<1||console&&console.log&&(console.error&&e.toLowerCase().indexOf("error")>-1?console.error(e):console.log(e))};var isie8iframe=!1;try{IsIeVersion(8)&&window.self!==window.top&&(isie8iframe=!0)}catch(err){}(IsIeVersion(6)||IsIeVersion(7)||isie8iframe)&&(window.location.href="oldieskin/wphone.htm");var maxv_chrm=webphone_api.getmaxchromeversionforjava(),wpbasedir=webphone_api.getbasedir2();try{console.log("base diectory - webphonebasedir(scrips): "+wpbasedir)}catch(err){}var ua=navigator.userAgent;api_helper.isNull(ua)&&(ua=""),ua=ua.toLowerCase(),("Safari"===webphone_api.GetBrowser()&&ua.indexOf("windows")<1||"Edge"===webphone_api.GetBrowser())&&document.write('<script type="text/javascript" src="'+wpbasedir+'js/lib/adapter.js"><\/script>'),document.write('<link rel="stylesheet" href="'+wpbasedir+'css/pmodal.css" />'),("Chrome"!==webphone_api.GetBrowser()||"Chrome"===webphone_api.GetBrowser()&&webphone_api.GetBrowserVersion()<=maxv_chrm)&&document.write('<script type="text/javascript" src="'+wpbasedir+'js/lib/mwpdeploy.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/lib/stringres.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/themes.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/lib/lib_softphone.js"><\/script>');var sdktmp=webphone_api.parameters.issdk;void 0===sdktmp||null===sdktmp||1==sdktmp||"true"==sdktmp||sdktmp.length<1||(document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_settings.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_newuser.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_messagelist.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_message.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_logview.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_internalbrowser.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_filters.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_filetransfer.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_dialpad.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_contactslist.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_contactdetails.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_callhistorylist.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_callhistorydetails.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_call.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_addeditcontact.js"><\/script>'),document.write('<script type="text/javascript" src="'+wpbasedir+'js/softphone/_accounts.js"><\/script>'));