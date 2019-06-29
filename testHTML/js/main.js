"use strict";

var g_sBackEnd = 'http://localhost/jsonphp/';
var g_bEncryptionRedCod = true;
var g_iIdLanguage = 0; // English = 0, Spanish = 1
var g_bReCaptcha = false;
var g_sSession = 'sfavevf5fA';
var g_iPrivateKey = 15628;
var g_sPrivateKey = "a5vbFgFFG4Fd2";

var g_sDirmain;

$(function(){
    g_sDirmain = $("#dirmain").val();
});

/*
*/
function closeSession(){
    setSession('');
    goTo('', '');
}


/*
*/
function updatePage(){
    window.location.reload(true);
}

/*
*/
function setSession(sCode){
    localStorage.setItem(g_sSession+"session", sCode);
}

/*
*/
function getSession(){
    let sSession = localStorage.getItem(g_sSession+"session");
    if(sSession == null){
        sSession = '';
    }

    return sSession;
}

/*
*/
function setMessage(sMessage){
    sessionStorage.setItem(g_sSession+'message', sMessage);
}

/*
*/
function getMessage(){
    let sMessage = sessionStorage.getItem(g_sSession+'message');
    sessionStorage.setItem(g_sSession+'message', '');
    if(sMessage == null){
        sMessage = '';
    }

    return sMessage;
}

/*
*/
function sendEmail(aEmail){
    let oAjax = {
        url: g_sBackEnd+'module/email/send',
        type: 'post',
        data: {}
    }

    $.each(aEmail, function(i, v){
        let iId = v.id;
        let sCod = v.cod;

        oAjax.data = {
            'id': iId,
            'cod': sCod
        };
        $.ajax(oAjax).done(function(oResponse){
        }).fail(function(){});
    });
}

/*
*/
function goTo(sUrl, sParametersGet){
    location.href = g_sDirmain+sUrl+'?'+sParametersGet;
}

/*
*/
function goTo_w(sUrl){
    window.open(sUrl);
}

/*
*/
function validateSession(bSession){
    let sSessionCode = getSession();

    let oAjax = {
        url: g_sBackEnd+'module/publicData/appRegistration',
        type: 'post',
        data: {}
    }
    $.ajax(oAjax).done(function(oResponse){
        if(oResponse.status == 1){
            let aResponse = oResponse.response;
            let iId = aResponse.id;
            let sRegCod = aResponse.registration_code;
            sRegCod = getDecodeRegCod(sRegCod);

            oAjax = {
                url: g_sBackEnd+'module/user/validateSession',
                type: 'post',
                data: {
                    'id': iId,
                    'registration_code': sRegCod,
                    'code': sSessionCode
                }
            }
            $.ajax(oAjax).done(function(oResponse){
                if(oResponse.status != 1){
                    setSession('');
                    if(bSession){
                        goTo('', '');
                    }
                }else{
                    oResponse = oResponse.response;
                    let iProfile = oResponse.profile;
                    
                    if(!bSession){
                        goTo('dashboard', '');
                    }
                }
            }).fail(function(){});
        }else{
            setMessage(oResponse.text.client);
            setSession('');
            if(bSession){
                goTo('', '');
            }
        }
    }).fail(function(){});
}

/*
*/
function getParameterBysName(sName){
    sName = sName.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + sName + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/*
*/
function getDecodeRegCod(sRegCod){
	if(g_bEncryptionRedCod){
		let aRegCod = sRegCod.split('.');
		let iRegCod = 0;

    	$.each(aRegCod, function(i, v){
    		let iDato = parseInt(v);
    		let iDato2 = iDato+g_iPrivateKey;
    		iRegCod += iDato2;
    	});

    	sRegCod = String(iRegCod);
        sRegCod += g_sPrivateKey;
        sRegCod = md5(sRegCod);
	}

	return sRegCod;
}
