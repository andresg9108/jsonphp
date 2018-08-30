"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
    let sMessage = getErrorMessage();
    $("#messageerr").html(sMessage);
}

/*
*/
function logInAction(){
    let sMessageErr = '';

    let sUser = $("#user").val();
    let sPassword = $("#password").val();
    let sResponse = '';
    if(g_bReCaptcha){
        sResponse = $("#g-recaptcha-response").val();
    }

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
            'response': sResponse,
            'user': sUser,
            'password': sPassword
        };
        let sUrl2 = 'administration/user/logIn';
        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
        .then(function(oResponse){
            if(oResponse.status == 1){
                oResponse = oResponse.response;
                let sCode = oResponse.code;
                let iProfile = oResponse.profile;
                $.when(setSession(sCode))
                .then(function(){
                    if(iProfile == 1){
                        goTo('dashboardAdmin', '');
                    }else{
                        goTo('dashboard', '');
                    }
                })
                .fail(function(){});
            }else{
                setErrorMessage(oResponse.text.client);
                updatePage();
            }
        })
        .fail(function(){});
    })
    .fail(function(){});

    return false;
}