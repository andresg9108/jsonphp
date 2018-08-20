"use strict";

var g_sBackEnd = 'http://localhost/jsonphp/';
var g_bEncryptionRedCod = true;
var g_bReCaptcha = false;
var g_sSession = 'sfavevf5fA';
var g_iPrivateKey = 15628;
var g_sPrivateKey = "a5vbFgFFG4Fd2";

var sSessionCode;
var sDirmain;

$(function(){
    sDirmain = $("#dirmain").val();
});

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
        $.post(g_sBackEnd+sUrl3,oDatos3);
    });
}

/*
*/
function irA(sUrl, sParametersGet){
    location.href = sDirmain+sUrl+'?'+sParametersGet;
}

/*
*/
function irAw(sUrl){
    window.open(sUrl);
}

/*
*/
function validateSession(){
    if(sSessionCode == null){
        irA('', '');
    }else{
        if(sSessionCode == ''){
            irA('', '');
        }else{
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
                    if(!oResponse.status){
                        irA('', '');
                    }
                })
                .fail(function(){});
            })
            .fail(function(){});
        }
    }
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