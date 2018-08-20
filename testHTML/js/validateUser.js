"use strict";

$(function(){
	setView();
});

function setView(){
	let iId = getParameterBysName('id');
	let sCode = getParameterBysName('code');

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
            'registration_code': sRegCod
        };
        let sUrl2 = 'administration/user/validateEmailByCode';
        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
        .then(function(oResponse){
        	console.log(oResponse);
        })
        .fail(function(){});
    })
    .fail(function(){});
}