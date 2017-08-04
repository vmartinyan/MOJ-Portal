//document.write('<script type="text/javascript" src="webphone_api.js"></script>');

/** Customizations */
var call_button_text = '<i class="icon moon-phone3"></i>';      // text showed on call button
var hangup_button_text = '<i class="icon moon-phone-hang-up"></i>';      // text showed on hangup button
var call_button_color = '#43b61b';      // call button color
var hangup_button_color = '#e83232';    // hangup button color
var status_text_color = '#ffffff';      // color of displayed status messages
var button_width = 180;                 // width of button in pixels
var button_height = 70;                 // height of button in pixels
var button_radius = 5;                  // button corner radius in pixels, higher values will result in a round button
var chatwindow_title = 'Chat';          // chat window header-title; can be text or html
var chatwindow_default_state = 0;       // default state of the chat window: 0=open, 1=collapsed

/**For floating button*/
var float_button = false;               // if set to true the button will float over the content of the webpage
var float_distance_from_top = -1;       // distance in pixels from the top of the page. -1 means disabled
var float_distance_from_left = -1;      // distance in pixels from the left of the page. -1 means disabled
var float_distance_from_bottom = -1;    // distance in pixels from the bottom of the page. -1 means disabled
var float_distance_from_right = -1;     // distance in pixels from the right of the page. -1 means disabled

/** End of Customizations */










var button_minwidth = 120;               // if width is less then this value, then show icon instead of text
var started = 0; // 0=not started, 1=register not received(wait longer before making the call), 2=register received, so we can make call

var c2k_btn = null;
var isfirstcall = true; // wait before placing the first call
var demotext = null;
var ELIMIT = 2000;

var calltonr = '';
function Start()
{
    PutToDebugLog(2, 'EVENT, Click2Call Start');
   /* if (GetAutoaction() === 1)
    {
        started = 1;
    }
    else */if (webphone_api.start() === true)
    {
        started = 1;
    }
}

webphone_api.onRegistered(function ()
{
    started = 2;
    PutToDebugLog(2, 'EVENT, Click2Call onRegistered received');
});

/** This callback function will be called on every call state change.
 * --PARAMETERS --
 * status: can have following values: callSetup, callRinging, callConnected, callDisconnected
 * direction: 1 (outgoing), 2 (incoming)
 * peername: is the other party username
 * peerdisplayname: is the other party display name if any
 * line: the status refers to this line*/
webphone_api.onCallStateChange(function (status, direction, peername, peerdisplayname, line)
{
    var lastoop = 0;
    try{
    if (status === 'callSetup')
    {
        lastoop = 1;
        SetButtonState(lastnr, true);
        lastoop = 2;

    // if it's an incoming call, then display popup with Accept/Reject buttons
        if (direction === 2)
        {
            lastoop = 3;
            AcceptRejectPopup(peername);
        }
        lastoop = 4;
    }
    else if (status === 'callConnected')
    {
        lastoop = 5;
        try{
        if (!isNull(armodal))
        {
            lastoop = 6;
            armodal.close();
            lastoop = 7;
        }
    }catch (ein) { ; }
    }
    else if (status === 'callDisconnected')
    {
        lastoop = 8;
        SetButtonState(lastnr);
        lastoop = 9;

    // close AcceptReseject popup on call finished, if it's still open
        if (!isNull(armodal))
        {
            lastoop = 10;
            armodal.close();
            lastoop = 11;
            armodal = null;
        }
    }
    lastoop = 12;
    } catch(err) { PutToDebugLogException(2, 'click2call: onCallStateChange (' + lastoop.toString() + ')', err); }
});

/** Custom popup with Accept/Reject buttons displayed on incoming call
 * This is just an example, you can design/use your own custom popup*/
var armodal = null;
function AcceptRejectPopup(from)
{
    try{
    if (!isNull(armodal))
    {
        armodal.show();
        return;
    }
    armodal = picoModal(
    {
        content: 
            '<div id="ce_modal" class="modal" style="color: #212121;">'+
                '<div id="ce_modal_header" class="modal_header_custom" style="height: 2.2em; line-height: 2.2em; margin: 0; background: #e8e8e8; text-align: center; color: #212121; font-weight: bold;">' +
                    'Incoming call' +
                '</div>' +
                '<div id="ce_modal_content" class="modal_content" style="font-size: .8em; padding: 1em;">' +
                    '<div id="ce_modal_content_inner">' +
                        'Incoming call from: ' + from +
                    '</div>' +
                '</div>' +
                '<div id="ce_modal_footer" class="modal_footer" style="height: 2.2em; margin: 0; background: #e8e8e8; text-align: center; color: #ffffff; font-weight: bold;">' +
                    '<button id="btn_np_positive" style="width: 50%; height: 2.28em; margin-top: .1em; font-size: .9em; color: #212121; font-weight: bold; background: #cecece; border: .1em solid #b8b8b8; border-radius: .2em; cursor: pointer;">Accept</button>' +
                    '<button id="btn_np_negative" style="width: 50%; height: 2.28em; margin-top: .1em; font-size: .9em; color: color: #212121; font-weight: bold; background: #cecece; border: .1em solid #b8b8b8; border-radius: .2em; cursor: pointer;">Reject</button>' +
                '</div>' +
            '</div>',
        //content: "Ah, the pitter patter of tiny feet in huge combat boots.<br><button>Test</button>",
        overlayStyles: { backgroundColor: "#565656", opacity: 0.6 },
        modalStyles:
        {
            padding: "0",
            margin: "0",
            //top: "0",
            border: ".2em solid #d8d8d8",
            borderRadius: ".4em",
            //width: '65%',
            width: 'auto',
            //height: '100%',
            background: "#ffffff", fontFamily: "sans-serif",
        },
        //closeHtml: "<span>Close</span>",
        closeButton: false,
        overlayClose: false,
        closeStyles:
        {
            background: "#eeeeee", position: "absolute", top: ".2em", right: ".3em", textAlign: "center",
            fontSize: "1.2em", fontWeight: "bold", border: ".15em solid #bbb", borderRadius: ".8em",
            paddingLeft: ".25em", paddingRight: ".25em", cursor: "pointer",
        },

        //comment: custom classes
        //overlayClass: "customShadow",
        //modalClass: "customModal",
        //closeClass: "customClose"

        // events
    }).afterCreate(function (modal)
    {
        ;
    })
    .beforeShow(function (modal, event)
    {
        ;
    })
    .afterShow(function (modal)
    {
        ;
    })
    .beforeClose(function (modal, event)
    {
        ;
    })
    .afterClose(function(modal)
    {
        modal.destroy(); // must be called, otherwise on next show() the onclick will not work
        armodal = null;
    });
    
    armodal.show();
    
    var btn_pos = document.getElementById('btn_np_positive');
    if (!isNull(btn_pos))
    {
    // fallback for IE7, IE8 addEventListener
        if (window.addEventListener)
        {
            window.addEventListener('click', HandleEventBtnPos);
        }
        else if (window.attachEvent)
        {
            window.attachEvent('click', HandleEventBtnPos);
        }
        
        function HandleEventBtnPos(event)
        {
            armodal.close();
            PutToDebugLog(5,"EVENT, click2call AcceptRejectPopup Accept onclick");
            webphone_api.accept();
        }
    }
    
    var btn_neg = document.getElementById('btn_np_negative');
    if (!isNull(btn_neg))
    {
    // fallback for IE7, IE8 addEventListener
        if (window.addEventListener)
        {
            window.addEventListener('click', HandleEventBtnNeg);
        }
        else if (window.attachEvent)
        {
            window.attachEvent('click', HandleEventBtnNeg);
        }

        function HandleEventBtnNeg(event)
        {
            armodal.close();
            PutToDebugLog(5,"EVENT, click2call AcceptRejectPopup Reject onclick");
            webphone_api.reject();
        }
    }
    } catch(err) { PutToDebugLogException(2, 'click2call: AcceptRejectPopup', err); }
}


var calltimer = null;
var save_completed = false;
function Click2Call(nr, isvideo)
{
    lastnr = nr;
    
    if (save_completed === false)
    {
        setTimeout(function () { save_completed = false; }, 20000); // save only every 20 sec

        SaveLocalstorageConfig();
        var serveraddress = webphone_api.parameters['serveraddress'];
        var username = webphone_api.parameters['username'];
        var callto = webphone_api.getcallto();

    // don't request server, user, password if it's started from and set from URL
        if (isNull(calltonr) || calltonr.length < 1)
        {
            if (isNull(serveraddress) || serveraddress.length < 3) { alert('VoIP serveraddress is not set.\n It can be set in "click2call_example.html"'); return; }
            if (isNull(username) || username.length < 3) { alert('VoIP accounts username is not set.\n It can be set in "click2call_example.html"'); return; }
            if (ELIMIT < 2 && (isNull(callto) || callto.length < 3)) { alert('Destination number (callto) is not set.\n It can be set in "click2call_example.html"'); return; }
        }

        save_completed = true;
    }
    
    if (started < 1)
    {
        Start();

        //put status to started after 45 seconds, even if register was not received
        setTimeout(function ()
        {
            if (started < 2)
            {
                PutToDebugLog(2, 'WARNING, Click2Call status set to STARTED=2 manually');
                started = 2;
            }
        }, 45000);
    }
    
    if (!isNull(calltimer)) { clearTimeout(calltimer); }
    calltimer = null;
    
    
    calltimer = setTimeout(function ()
    {
        if (started < 2)
        {
            Click2Call(nr);
            return;
        }

        var destnr = webphone_api.getcallto();
    // get callto from DIV title - used in case multiple click to call  buttons are on a webpage
        var cdiv = document.getElementById('c2k_container_' + nr);
        if (!isNull(cdiv) && !isNull(cdiv.getAttribute('title')) && cdiv.getAttribute('title').length > 0)
        {
            destnr = cdiv.getAttribute('title');
        }
        
        PutToDebugLog(2, 'EVENT, Click2Call called, id: ' + nr + '; number: ' + destnr);
    
        if (webphone_api.isincall() === false) // make a call
        {
            var timeout = 1;
            if (isfirstcall)
            {
                isfirstcall = false;
                timeout = 800;
            }
            
            if (isvideo === true)
            {
                setTimeout(function ()
                {
                    PutToDebugLog(2, 'EVENT, Click2Call initiate Videocall to: ' + destnr);
                    webphone_api.videocall(Trim(destnr));
                }, timeout);
            }else
            {
                setTimeout(function ()
                {
                    PutToDebugLog(2, 'EVENT, Click2Call initiate Call to: ' + destnr);
                    webphone_api.call(Trim(destnr));
                }, timeout);
            }
        }else
        {
            PutToDebugLog(2, 'EVENT, Click2Call Hangup');
            webphone_api.hangup();
            SetButtonState(nr);
        }
    }, 100); // !!! IMPORTANT: timeout must be less then plhandler.Start timeout:  if (laststarttick > 0 && now - laststarttick < 150)
}

var loglevel = null;
var lastnot = '';
function DisplayStatus(msg_orig)
{
    try{
    var msg = msg_orig;
    
    if (isNull(loglevel))
    {
        loglevel = 1;
        try{ loglevel = parseInt(webphone_api.parameters['loglevel'], 10); } catch(err) {  }
    }
    
    if (isNull(msg) || msg.length < 1) { msg = '&nbsp;'; }
    
    if (msg.indexOf('ERROR') >= 0)
    {
        msg = msg.replace('ERROR', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
        
        msg = '<span style="color:red;">' + msg + '</span>';
    }
    else if (msg.indexOf('WARNING') >= 0)
    {
        msg = msg.replace('WARNING', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
        
        msg = '<span style="color: #ff6600;">' + msg + '</span>';
    }
    else if (msg.indexOf('STATUS') >= 0 || msg.indexOf('EVENT') >= 0)
    {
        msg = msg.replace('STATUS', '');
        msg = msg.replace('EVENT', '');
        msg = Trim(msg);
        
        if (msg.indexOf(',') === 0)
        {
            msg = msg.replace(',', '');
            msg = Trim(msg);
        }
    }
    
    if ((msg.toLowerCase()).indexOf('registered') >= 0 || (msg.toLowerCase()).indexOf('authenticated successfully') >= 0)
    {
        started = 2;
    }
    
    for (var i = 0; i < ELIMIT; i++)
    {
        var text_status = document.getElementById('c2k_status_' + i);
        if (!isNull(text_status)) { text_status.innerHTML = msg; }
        var chat_status = document.getElementById('chat_status_' + i);
        if (!isNull(chat_status)){ chat_status.innerHTML = msg; }
    }
    
    if (loglevel > 1 && lastnot !== msg_orig)
    {
        PutToDebugLog(2, 'NOT: ' + msg_orig);
        lastnot = msg_orig;
    }
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: DisplayStatus', err); }
}

function GetAutoaction()
{
    try{
    //autoaction from URL
    var url = window.location.href;
    if (!isNull(url) && url.indexOf('autoaction=') > 0)
    {
        url = decodeURIComponent(url);
        url = Trim(url);
        var ret = url.substring(url.indexOf('autoaction=') + 11);
        if (!isNull(ret) && ret.length > 0)
        {
            ret = ret.substring(0, 1);
            if (!isNull(ret) && api_helper.IsNumber(ret))
            {
                return api_helper.StrToInt(ret);
            }
        }
    }
    
    if (!isNull(webphone_api.parameters) && !isNull(webphone_api.parameters['autoaction']) && !isNaN(webphone_api.parameters['autoaction']))
    {
        return webphone_api.parameters['autoaction'];
    }
    
    var ret = parseInt(webphone_api.getparameter('autoaction'), 10);
    
    if (!isNull(ret) && !isNaN(ret)) { return ret; }
    
    } catch(err) { PutToDebugLogException(2, 'live_demo: GetAutoaction', err); }
    return 0;
}

// Populate settings
var LONG_CLICK_DELAY = 1000;
var longclick_initiated = 0;
var alreadycalled = false;

webphone_api.onLoaded(function ()
{
    try{
    if (alreadycalled === true) { return; }
    alreadycalled = true;
    
    webphone_api.getEvents(function (evt)
    {
        ProcessNotifications(evt);
    });
    
    webphone_api.GetDisplayableNotifications(function (msg)
    {
        DisplayStatus(msg);
    });
    
    // boost webrtc engine priority a little callto/to is set, because we have to wait a longer for the java engine to load
    if (webphone_api.caniusewebrtc() === true)
    {
        var pr = 0;
        var prstr = webphone_api.getparameter('enginepriority_webrtc');
        if (!isNull(prstr) && api_helper.IsNumber(prstr))
        {
            pr = api_helper.StrToInt(prstr);
            if (pr === 2)
            {
                PutToDebugLog(2, 'EVENT, click2call boost WebRTC priority to: 3');
                webphone_api.setparameter('enginepriority_webrtc', '3');
                pr = 3;
            }
        }
    }
    
    if (ELIMIT < 1) { ELIMIT = 2000; }
    for (var i = 0; i < ELIMIT; i++)
    {
        if (isNull(document.getElementById('c2k_container_' + i)))
        {
            ELIMIT = i;
            break;
        }
        //<br /><button id="c2k_btn" class="cl_c2k_btn" title="Initiate call"><span id="c2k_status" class="cl_c2k_status"></span><br><span id="c2k_label" class="cl_c2k_label">Call</span></button>
    }
    if (!isNull(document.body) && isNull(document.getElementById('loader')))
    {
        // <iframe style="display:none" height="0" width="0" id="loader"></iframe>
        var loader = document.createElement('iframe');
            loader.style.display = "none";
            loader.style.height = "0";
            loader.style.width = "0";
            loader.id = "loader";
        document.body.appendChild(loader);
    }
    var altcall = document.getElementById('c2k_alternative_url');
    if (!isNull(altcall))
    {
        var ct = webphone_api.getcallto();
        if (!isNull(ct) && ct.length > 0)
        {
            altcall.src = 'tel://' + ct;
            altcall.innerHTML = ct;
        }
        if (webphone_api.SupportHtml5() === true)
        {
            altcall.style.display = 'none';
        }
    }

    demotext = document.getElementById('demo_text');
    if (!isNull(demotext))
    {
        var conf = '<div style="text-align: center;">' +
            '<br />' +
            '<label for="mdemo_serveraddress" title="VoIP server IP address or domain name">Serveraddress:</label>' +
            '<input type="text" name="mdemo_serveraddress" id="mdemo_serveraddress" placeholder="VoIP server address" title="VoIP server IP address or domain name" /><br />' +
            '<label for="mdemo_username" title="SIP account username">Username:</label>' +
            '<input type="text" name="mdemo_username" id="mdemo_username" placeholder="Username" title="SIP account username" /><br />' +
            '<label for="mdemo_password" title="SIP account password">Password:</label>' +
            '<input type="text" name="mdemo_password" id="mdemo_password" placeholder="Password" title="SIP account password" /><br />' +
            '<label for="mdemo_callto" title="Destination number to call">Callto:</label>' +
            '<input type="text" name="mdemo_callto" id="mdemo_callto" placeholder="Callto" title="Destination number to call" /><br />' +
            '<span style="font-style: italic; font-size: .85em; ">*The above form will not be displayed in your final build, these settings will be preconfigured.</span><br />' +
            '</div>';
    
        demotext.innerHTML += conf;
    }
    LoadLocalstorageConfig();
    
    var autoaction = GetAutoaction(); // 0=nothing, 1=call (default), 2=chat, 3=video call
    var dispchat = 'none';
    if (autoaction == 2) { dispchat = 'block'; }
    
    for (var i = 0; i < ELIMIT; i++)
    {
        var chtml = '<button id="c2k_btn_' + i + '" class="cl_c2k_btn" onmousedown="Btnc2kMousedown(event, ' + i + ')" oncontextmenu="Btnc2kContextmenu(event, ' + i + ')" onmouseup="Btnc2kOnmouseup(event, ' + i + ')">' +
            '<span id="c2k_status_' + i + '" class="cl_c2k_status"></span><br><br>' +
            '<span id="c2k_label_' + i + '" class="cl_c2k_label">Call</span></button>';
    
        var c2k_container = document.getElementById('c2k_container_' + i);
        
        var dispfullchatw = 'block';
        if (!isNull(chatwindow_default_state) && chatwindow_default_state > 0) { dispfullchatw = 'none'; }
        if (isNull(chatwindow_title)) { chatwindow_title = ''; }
        var chwindow = '';
        var contextmenu = '';
        if (!isNull(c2k_container))
        {
            chwindow = '' +
            '<div id="chat_box_' + i + '" class="cl_chat_box" style="display: ' + dispchat + ';">' +
                '<span class="cl_chat_w_title">' + chatwindow_title + '</span>' +
                '<button class="cl_btn_chat_collapse" onclick="ChatCollapse(' + i + ')" title="Open/Collapse"><img src="' + webphone_api.getbasedir2() + 'images/icon_collapse.png" width="12" height="8" style="border: 0;" /></button>' +
                '<div id="chat_box_container_' + i + '" class="cl_chat_box_container" style="display: ' + dispfullchatw + ';">' +
                    '<span id="chat_status_' + i + '" class="cl_chat_status">&nbsp;</span>' +
                    '<!--<div class="reg_form" id="chat_destination_container">' +
                        '<label for="destinationchat" title="Send chat to destination SIP URI or number">Destination: </label>' +
                        '<input type="text" placeholder="Chat to" id="destinationchat" value="" title="SIP URI, username, extension or phone number" />' +
                    '</div>-->' +
                    '<div id="msg_list">' +
                        '<!--<b>Me:</b><p>Hello, how are you? Hello, how are you? Hello, how are you? Hello, how are you? Hello, how are you today?</p><p class="date">Jun 05, 2014 11:59</p>-->' +
                    '</div>' +
                    '<div id="send_container">' +
                        '<input type="text" placeholder="Compose" id="message" value="" title="Enter the chat to be sent" />&nbsp;' +
                        '<button onclick="SendChat()" title="Send chat message">Send</button>' +
                    '</div>' +
                '</div>' +
            '</div>';
            
            chwindow = chwindow + '<div id="video_container" style="display: none;"></div>';

           // contextmenu = '' +
           // '<div id="optionsmenu_popup_' + i + '" class="cl_optionsmenu_popup" style="display: none;">' +
           //    '<ul class="cl_optionsmenu_list">' +
           //         '<li onclick="OptionsMenuClick(' + i + ', 1)"><span>Chat</span></li>' +
           //         '<li onclick="OptionsMenuClick(' + i + ', 2)"><span>Call</span></li>' +
           //         '<li onclick="OptionsMenuClick(' + i + ', 3)"><span>Video Call</span></li>' +
           //     '</ul>' +
           // '</div>';
        }
        
        c2k_container.innerHTML = chtml + chwindow + contextmenu;
        
        var c2k_btn = document.getElementById('c2k_btn_' + i);
        if (autoaction == 2)
        {
            if (!isNull(c2k_btn)) { c2k_btn.style.display = 'none'; }
        }
        
        if (!isNull(c2k_btn))
        {
            SetButtonState(i);

            if (button_width > 0) { c2k_btn.style.width = button_width + 'px'; }
            if (button_height > 0) { c2k_btn.style.height = button_height + 'px'; }
            if (button_radius >= 0) { c2k_btn.style.borderRadius = button_radius + 'px'; }


        // if it's a floating button
            if ((float_button == true || float_button == 'true') && !isNull(c2k_container))
            {
    //            #c2k_btn { position: fixed; right: 5px; top: 250px; }
    //            #c2k_btn:hover { right: 8px; }
                c2k_container.style.position = 'fixed';

                var fset = false;
                if (!isNull(float_distance_from_right) && float_distance_from_right >= 0)
                {
                    c2k_container.style.right = float_distance_from_right + 'px';
                    fset = true;
                }
                if (!isNull(float_distance_from_left) && float_distance_from_left >= 0)
                {
                    c2k_container.style.left = float_distance_from_left + 'px';
                    fset = true;
                }
                if (!isNull(float_distance_from_bottom) && float_distance_from_bottom >= 0)
                {
                    c2k_container.style.bottom = float_distance_from_bottom + 'px';
                    fset = true;
                }
                if (!isNull(float_distance_from_top) && float_distance_from_top >= 0)
                {
                    c2k_container.style.top = float_distance_from_top + 'px';
                    fset = true;
                }

                // must add some values, otherwise button will not be displayed
                if (fset === false)
                {
                    c2k_container.style.top = '45px';
                    c2k_container.style.left = '3px';
                }
            }
    /*        
            var float_button = '';                  // if set to true the button will float over the content of the webpage
    var float_distance_from_top = -1;       // distance in pixels from the top of the page. -1 means disabled
    var float_distance_from_left = -1;      // distance in pixels from the left of the page. -1 means disabled
    var float_distance_from_bottom = -1;    // distance in pixels from the bottom of the page. -1 means disabled
    var float_distance_from_right = -1;     // distance in pixels from the right of the page. -1 means disabled
    */
        }
        
        var text_status = document.getElementById('c2k_status_' + i);
        var chat_status = document.getElementById('chat_status_' + i);

        if (!isNull(text_status)) { text_status.style.color = status_text_color; }
        if (!isNull(chat_status)) { chat_status.style.color = status_text_color; }
    }
    

    
    
// handle call from url
    var url = window.location.href;
    url = decodeURIComponent(url);
    var pos = url.indexOf('?');
    if (pos > 0)
    {    
        url = url.substring(pos + 1, url.length);
        pos = url.indexOf('wp_callto=');
        
        if (pos > 0)
        {
            url = url.substring(pos + 10);
            
            pos = url.indexOf('&');
            if (pos < 0) { pos = url.length; }
            
            calltonr = url.substring(0, pos);
        }
    }
    
    if (!isNull(calltonr) && calltonr.length > 0)
    {
        Start();
    }
    } catch(err) { PutToDebugLogException(2, 'live_demo: onload', err); }
    
    
    webphone_api.onChat(function (from, msg, line)
    {
        if (isNull(from) || isNull(msg)) { return; }
        AddMessageToHistory(webphone_api.getcallto(), msg);
    });
    
    var ct = webphone_api.getcallto();
    if (!isNull(ct) && ct.length > 0)
    {
        if (autoaction == '1')
        {
            Click2Call(0, false);
        }
        else if (autoaction == '3')
        {
            Click2Call(0, true);
        }
    }
});

function OptionsMenuClick(nr, action)
{
    document.getElementById('optionsmenu_popup_' + nr).style.display = 'none';
    if (action == '1') // chat
    {
        var chatbox = document.getElementById('chat_box_' + nr);
        if (!isNull(chatbox))
        {
            if (chatbox.style.display === 'none')
            {
                chatbox.style.display = 'block';
            }else
            {
                chatbox.style.display = 'none'; 
            }
        }
    }
    else if (action == '2') // call
    {
        Click2Call(nr, false);
    }
    else if (action == '3') // video call
    {
        Click2Call(nr, true);
    }
}

function ChatCollapse(i)
{
    var chatboxcontainer = document.getElementById('chat_box_container_' + i);
    if (!isNull(chatboxcontainer))
    {
        if (chatboxcontainer.style.display === 'none')
        {
            chatboxcontainer.style.display = 'block';
        }else
        {
            chatboxcontainer.style.display = 'none';
        }
    }
}

function Btnc2kContextmenu(ev, nr) // handle right click
{
    ev = ev || window.event;
    ev.preventDefault();

    document.getElementById('optionsmenu_popup_' + nr).style.display = 'block'; // open options menu
    return false;
}

function Btnc2kOnmouseup(ev, nr) // handle long click/tap
{
    ev = ev || window.event;
    ev.preventDefault();

    // left mouse click
    if (ev.which == 1)
    {
        if (GetTickCount() - longclick_initiated > LONG_CLICK_DELAY)
        {
            document.getElementById('optionsmenu_popup_' + nr).style.display = 'block'; // open options menu
        }else
        {
            Click2Call(nr);
        }
    }
    // right mouse click - don't do anything, already handled by contextmenu
    else if (ev.which == 3)
    {
        //document.getElementById('optionsmenu_popup_' + i).style.display = 'block'; // open options menu
    }
    return false;
}

function Btnc2kMousedown(ev, nr) // handle right click
{
    ev = ev || window.event;
    ev.preventDefault();

    longclick_initiated = GetTickCount();
    return false;
}

function LoadLocalstorageConfig()
{
    try{
    if (!isNull(demotext)) // means it's demo version
    {
        var srv = webphone_api.getparameter('serveraddress');
        if (isNull(srv) || srv.length < 1) { srv = webphone_api.getparameter('serveraddress_user'); }
        var usr = webphone_api.getparameter('username');
        var pwd = webphone_api.getparameter('password');
        var callto = webphone_api.getcallto();

        var srvF = document.getElementById('mdemo_serveraddress');
        var usrF = document.getElementById('mdemo_username');
        var pwdF = document.getElementById('mdemo_password');
        var calltoF = document.getElementById('mdemo_callto');

        if (!isNull(srv) && srv.length > 0)
        {
            webphone_api.parameters['serveraddress'] = srv;
            if (!isNull(srvF)) { srvF.value = srv; }
        }
        if (!isNull(usr) && usr.length > 0)
        {
            webphone_api.parameters['username'] = usr;
            if (!isNull(usrF)) { usrF.value = usr; }
        }
        if (!isNull(pwd) && pwd.length > 0)
        {
            webphone_api.parameters['password'] = pwd;
            if (!isNull(pwdF)) { pwdF.value = pwd; }
        }
        if (!isNull(callto) && callto.length > 0)
        {
            webphone_api.parameters['callto'] = callto;
            if (!isNull(calltoF)) { calltoF.value = callto; }
        }
    }
    } catch(err) { PutToDebugLogException(2, "click2call: LoadLocalstorageConfig", err); }
}

function SaveLocalstorageConfig()
{
    try{
    if (!isNull(demotext)) // means it's demo version
    {
        var srvF = document.getElementById('mdemo_serveraddress');
        var usrF = document.getElementById('mdemo_username');
        var pwdF = document.getElementById('mdemo_password');
        var calltoF = document.getElementById('mdemo_callto');

        var srv = ''; var usr = ''; var pwd = ''; var callto = '';

        if (!isNull(srvF) && !isNull(srvF.value)) { srv = Trim(srvF.value); }
        if (!isNull(usrF) && !isNull(usrF.value)) { usr = Trim(usrF.value); }
        if (!isNull(pwdF) && !isNull(pwdF.value)) { pwd = Trim(pwdF.value); }
        if (!isNull(calltoF) && !isNull(calltoF.value)) { callto = Trim(calltoF.value); }

        if (srv.length > 0)
        {
            webphone_api.setparameter('serveraddress', srv);
            webphone_api.setparameter('serveraddress_user', srv);
            webphone_api.parameters['serveraddress'] = srv;
        }
        if (usr.length > 0) { webphone_api.setparameter('username', usr);       webphone_api.parameters['username'] = usr; }
        if (pwd.length > 0) { webphone_api.setparameter('password', pwd);       webphone_api.parameters['password'] = pwd; }
        if (callto.length > 0) { webphone_api.setparameter('callto', callto);      webphone_api.parameters['callto'] = callto; }
    }
    } catch(err) { PutToDebugLogException(2, "click2call: SaveLocalstorageConfig", err); }
}

function SendChat()
{
    SaveLocalstorageConfig();
    var msgF = document.getElementById('message');
    
    var to = webphone_api.getcallto(); //destination_input.value;
    var msg = msgF.value;
    
    if (isNull(to) || (Trim(to)).length < 1)
    {
        DisplayStatus('ERROR, Invalid chat destination number');
        return;
    }
    
    if (isNull(msg) || (Trim(msg)).length < 1)
    {
        DisplayStatus('ERROR, Enter chat message to be sent');
        msgF.focus();
        return;
    }
    
    msgF.value = '';
    
    AddMessageToHistory('Me', msg);
    
    webphone_api.sendchat(to, msg);
}

function AddMessageToHistory(to, message) // show messages on the page
{
    var sentmsgF = document.getElementById('msg_list');
    var msgconttent = sentmsgF.innerHTML;
    
    if (isNull(msgconttent)) { msgconttent = ''; }
    
    var item = '';
    
    if (!isNull(to) && to.length > 0)
    {
        item = '<b>' + to + ':</b><p>' + message + '</p><p class="date">' + GetDateForMessage() + '</p>';
    }else
    {
        item = '<p>' + message + '</p>';
    }
    
    msgconttent = msgconttent + item + '<br />';
    
    sentmsgF.innerHTML = msgconttent;
// scroll to bottom
    sentmsgF.scrollTop = sentmsgF.scrollHeight;
//    var d = $('#msg_list');
//    d.scrollTop(d.prop("scrollHeight"));
}

var month = new Array();
month[0] = 'Jan';
month[1] = 'Feb';
month[2] = 'Mar';
month[3] = 'Apr';
month[4] = 'May';
month[5] = 'Jun';
month[6] = 'Jul';
month[7] = 'Aug';
month[8] = 'Sep';
month[9] = 'Oct';
month[10] = 'Nov';
month[11] = 'Dec';

function GetDateForMessage()
{
    try{
    var date = new Date();

    var minutes = date.getMinutes();
    if (minutes < 10) { minutes = '0' + minutes; }

    var day = date.getDate(); // getDay returns the day of the week
    if (day < 10) { day = '0' + day; }

    var datestr = month[date.getMonth()] + ', ' + day + ' ' + date.getFullYear()+ ' '
            + date.getHours() + ':' + minutes;
    
    return datestr;

    } catch(err) { PutToDebugLogException(2, "_message: GetDateForMessage", err); }
    return '';
}


var ringingNumber = '';
function ProcessNotifications(not)
{
    try{
    if (isNull(not) || not.length < 1) { return; }
    
    not = Trim(not);
    
    var type = '';
    var line = '';
    var notifyword = '';
    
    //STATUS,1,Ringing,8888,9999,2,8888
    var pos = not.indexOf(',');
    if (pos > 0)
    {
        type = Trim(not.substring(0, pos));
        not = Trim(not.substring(pos + 1));
    }
    
    if ((not.toLowerCase()).indexOf('starting engine') >= 0)
    {
        started = 1;
    }
    
// get line
    pos = not.indexOf(',');
    if (pos > 0)
    {
        line = Trim(not.substring(0, pos));
        notifyword = Trim(not.substring(pos + 1));
    }else
    {
        notifyword = not;
    }
    
    var notifywordcontent = '';
    
// clear junk of notifyword's end
    pos = notifyword.indexOf(',');
    if (pos > 0)
    {
        notifywordcontent = Trim(notifyword.substring(pos + 1));
        notifyword = Trim(notifyword.substring(0, pos));
    }
    
    
// handle incoming call
    /*if (type === 'STATUS')
    {
        if (notifyword === 'Ringing')
        {
            SetButtonState(lastnr, true);
        }
        
        if (notifyword === 'Call Finished' || notifyword === 'Finished')
        {
            SetButtonState(lastnr);
        }
    }*/
    } catch(err) { PutToDebugLogException(2, 'live_demo: ProcessNotifications', err); }
}

var lastnr = '0';
function SetButtonState(nr, forcehangup)
{
    try{
    lastnr = nr;
    var btn = document.getElementById('c2k_btn_' + nr);
    var label = document.getElementById('c2k_label_' + nr);
    
    if (!isNull(btn))
    {
        var isincall = webphone_api.isincall();
        // set button text or image based on width
        if (isincall === true || forcehangup === true)
        {
            btn.style.background = hangup_button_color;
            if (button_width < button_minwidth)
            {
                btn.innerHTML = '<img src="' + webphone_api.getbasedir2() + 'images/icon_hangup.png" border="0" />';
            }else
            {
                if (!isNull(label)) { label.innerHTML = hangup_button_text; }
            }
        }else
        {
            btn.style.background = call_button_color;
            if (button_width < button_minwidth)
            {
                btn.innerHTML = '<img src="' + webphone_api.getbasedir2() + 'images/icon_call.png" border="0" />';
            }else
            {
                if (!isNull(label)) { label.innerHTML = call_button_text; }
            }
        }
    }
    } catch(err) { PutToDebugLogException(2, 'live_demo: SetButtonState', err); }
}

// ------------------ helper functions

function isNull (variable)
{
    try{
    if (typeof (variable) === 'undefined' || variable === null)
    {
        return true;
    }else
    {
        return false;
    }
    } catch(err) { PutToDebugLogException(2, "common: isNull", err); }
    
    return true;
}

function Trim(str)
{
    try{
    if (isNull(str) || str.lenght < 1) { return ''; }
    
    str = str.toString();
    return str.replace(/^\s+|\s+$/g, ''); 
    
    } catch(err) { PutToDebugLogException(2, "common: Trim", err); }
    
    return str;
}

function GetTickCount()
{
    try{
    var currDate = new Date();
    //return currDate.getMilliseconds();
    return currDate.getTime();

    }catch (err) { PutToDebugLogException (2, 'common: GetTickCount', err); }
    return 0;
}

function PutToDebugLogException(level, msg, err) { PutToDebugLog(level, 'ERROR,' + msg + ' ' + err); }
function PutToDebugLog(level, msg)
{
    try{
    var currDate = new Date();
    var currHour = currDate.getHours();
    var currMin = currDate.getMinutes();
    var currSec = currDate.getSeconds();
    var currMilli = currDate.getMilliseconds();

    if (currHour < 10) { currHour = '0' + currHour; }
    if (currMin < 10) { currMin = '0' + currMin; }
    if (currSec < 10) { currSec = '0' + currSec; }
    if (currMilli < 10) { currMilli = '00' + currMilli; } else if (currMilli < 100) { currMilli = '0' + currMilli; }

    var eventtime = '[' + currHour + ':' + currMin + ':' + currSec + '.' + currMilli + '] ';
    
    if (msg.indexOf("ERROR") > -1)
    {
        try { console.error('webphone: ' + eventtime + msg); } catch (e1) {  }
    }else
    {
        try { console.log('webphone: ' + eventtime + msg); } catch (e2) {  }
    }
    }catch (e) {  }
}
