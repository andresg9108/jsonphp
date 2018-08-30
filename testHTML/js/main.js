"use strict";

var g_sBackEnd = 'http://localhost/jsonphp/';
var g_bEncryptionRedCod = true;
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
function setErrorMessage(sMessage){
    sessionStorage.setItem(g_sSession+'message', sMessage);
}

/*
*/
function getErrorMessage(){
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
    $.each(aEmail, function(i, v){
        let iId = v.id;
        let sCod = v.cod;

        let sUrl3 = 'administration/email/send';
        let oDatos3 = {
            'id': iId,
            'cod': sCod
        };
        $.post(g_sBackEnd+sUrl3,oDatos3)
        .then(function(oResponse){
        });
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
function validateSession(){
    let sSessionCode = getSession();
    
    let oDatos = {};
    let sUrl = 'administration/publicData/appRegistration';
    $.when($.post(g_sBackEnd+sUrl, oDatos))
    .then(function(oResponse){
        let aResponse = oResponse.response;
        let iId = aResponse.id;
        let sRegCod = aResponse.registration_code;
        sRegCod = getDecodeRegCod(sRegCod);

        let oDatos2 = {
            'id': iId,
            'registration_code': sRegCod,
            'code': sSessionCode
        };
        let sUrl2 = 'administration/user/validateSession';
        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
        .then(function(oResponse){
            console.log(oResponse);
        })
        .fail(function(){});
    })
    .fail(function(){});
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