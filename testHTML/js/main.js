"use strict";

var g_sBackEnd = 'http://localhost/jsonphp/';
var g_bEncryptionRedCod = true;
var g_iPrivateKey = 15628;
var g_sPrivateKey = "a5vbFgFFG4Fd2";

$(function(){
});

function getParameterBysName(sName){
    sName = sName.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + sName + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}