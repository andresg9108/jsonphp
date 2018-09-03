"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
    let sMessage = getErrorMessage();
    $("#messageerr").html(sMessage);

    let iIdEUser = getParameterBysName('id');
    let sCodeEUser = getParameterBysName('code');

    let oDatos = {};
    let sUrl = 'administration/publicData/appRegistration';
    $.when($.post(g_sBackEnd+sUrl, oDatos))
    .then(function(oResponse){
        oResponse = oResponse.response;

        let iId = oResponse.id;
        let sRegCod = oResponse.registration_code;
        sRegCod = getDecodeRegCod(sRegCod);

        let oDatos1 = {
            'id': iId,
            'registration_code': sRegCod,
            'ideuser': iIdEUser,
            'codeeuser': sCodeEUser

        };
        let sUrl1 = 'administration/user/validateRecoverPassword';
        $.when($.post(g_sBackEnd+sUrl1, oDatos1))
        .then(function(oResponse){
        	console.log(oResponse);
        })
        .fail(function(){});
    })
    .fail(function(){});
}