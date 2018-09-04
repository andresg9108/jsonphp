"use strict";

/*
*/
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
        if(oResponse.status == 1){
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
                if(oResponse.status == 1){
                    oResponse = oResponse.response;
                    let iIdEUser = oResponse.ideuser;
                    let sCodeEUser = oResponse.codeeuser;

                    $("#ideuser").val(iIdEUser);
                    $("#codeeuser").val(sCodeEUser);
                }else{
                    setErrorMessage(oResponse.text.client);
                    goTo('recoverPassword/', '');
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

/*
*/
function recoverPasswordAction(){
    if(validateRecoverPassword()){
        let iIdEUser = $("#ideuser").val();
        let sCodeEUser = $("#codeeuser").val();
        let sPassword = $("#password").val();
        let sResponse = '';
        if(g_bReCaptcha){
            sResponse = $("#g-recaptcha-response").val();
        }

        let oDatos = {};
        let sUrl = 'administration/publicData/appRegistration';
        $.when($.post(g_sBackEnd+sUrl, oDatos))
        .then(function(oResponse){
            if(oResponse.status == 1){
                oResponse = oResponse.response;
                let iId = oResponse.id;
                let sRegCod = oResponse.registration_code;
                sRegCod = getDecodeRegCod(sRegCod);

                let oDatos1 = {
                    'id': iId,
                    'registration_code': sRegCod,
                    'response': sResponse,
                    'ideuser': iIdEUser,
                    'codeeuser': sCodeEUser,
                    'password': sPassword

                };
                let sUrl1 = 'administration/user/sendRecoverPassword';
                $.when($.post(g_sBackEnd+sUrl1, oDatos1))
                .then(function(oResponse){
                    setErrorMessage(oResponse.text.client);
                    if(oResponse.status == 1){
                        goTo('', '');
                    }else{
                        goTo('recoverPassword/', '');
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

    return false;
}

/*
*/
function validateRecoverPassword(){
    let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'password';
    sText = 'You must add a password.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'The password must have at least 5 characters.';
    if(!validatePassword(sFieldName, sText)){ return false; }

    sFieldName = 'rpassword';
    sText = 'You must repeat the password.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'password';
    sFieldName2 = 'rpassword';
    sText = 'Passwords do not match.';
    if(!validatePasswords(sFieldName, sFieldName2, sText)){ return false; }

    sText = 'You must complete the Captcha for security.';
    if(!validateReCaptcha(sText)){return false;}

    return true;
}