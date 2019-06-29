"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
    validateSession(false);
    
    let sMessage = getMessage();
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
                url: g_sBackEnd+'module/user/logIn',
                type: 'post',
                data: {
                    'id': iId,
                    'registration_code': sRegCod,
                    'response': sResponse,
                    'user': sUser,
                    'password': sPassword
                }
            }

            $.ajax(oAjax).done(function(oResponse){
                if(oResponse.status == 1){
                    oResponse = oResponse.response;
                    let sCode = oResponse.code;
                    let iProfile = oResponse.profile;

                    $.when(setSession(sCode))
                    .then(function(){
                        goTo('dashboard/', '');
                    })
                    .fail(function(){});
                }else{
                    setMessage(oResponse.text.client);
                    updatePage();
                }
            }).fail(function(){});
        }else{
            setMessage(oResponse.text.client);
            goTo('', '');
        }
    }).fail(function(){});

    return false;
}