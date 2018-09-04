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
        if(oResponse.status == 1){
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
                if(oResponse.status == 1){
                    let sMessage = oResponse.text.client;
                    $("#validationMessage").html('<h1>'+ sMessage +'</h1>');
                }else{
                    goTo('', '');
                }
            })
            .fail(function(){});
        }else{
            setErrorMessage(oResponse.text.client);
            goTo('', '');
        }
    })
    .fail(function(){});
}