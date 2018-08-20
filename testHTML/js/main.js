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

function irA(sUrl, sParametersGet){
    location.href = sDirmain+sUrl+'?'+sParametersGet;
}

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
            console.log(sSessionCode);
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