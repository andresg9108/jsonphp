"use strict";

$(function(){
	setView();
});

function setView(){
	let iIdUser = getParameterBysName('id');
	let sCodeUser = getParameterBysName('code');

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
            'id_user': iIdUser,
            'code_user': sCodeUser
        };
        let sUrl2 = 'administration/user/validateEmailByCode';
        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
        .then(function(oResponse){
        	if(oResponse.status){
                oResponse = oResponse.response;
                let bValid = oResponse.valid;

                if(bValid){
                    let sMessage = 'Has validado tu correo electrónico.';
                    $("#validationMessage").html(sMessage);
                }else{
                    irA('', '');
                }
            }else{
                irA('', '');
            }
        })
        .fail(function(){});
    })
    .fail(function(){});
}