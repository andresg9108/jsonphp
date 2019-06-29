"use strict";

/*
*/
$(function(){
	setView();
});

/*
*/
function setView(){
    let sMessage = getMessage();
    $("#messageerr").html(sMessage);

    let iIdEUser = getParameterBysName('id');
    let sCodeEUser = getParameterBysName('code');

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
                url: g_sBackEnd+'module/user/validateRecoverPassword',
                type: 'post',
                data: {
                    'id': iId,
                    'registration_code': sRegCod,
                    'ideuser': iIdEUser,
                    'codeeuser': sCodeEUser
                }
            }
            $.ajax(oAjax).done(function(oResponse){
                if(oResponse.status == 1){
                    oResponse = oResponse.response;
                    let iIdEUser = oResponse.ideuser;
                    let sCodeEUser = oResponse.codeeuser;

                    $("#ideuser").val(iIdEUser);
                    $("#codeeuser").val(sCodeEUser);
                }else{
                    setMessage(oResponse.text.client);
                    goTo('recoverPassword/', '');
                }
            }).fail(function(){});
        }else{
            setMessage(oResponse.text.client);
            goTo('', '');
        }
    }).fail(function(){});
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
                    url: g_sBackEnd+'module/user/sendRecoverPassword',
                    type: 'post',
                    data: {
                        'id': iId,
                        'registration_code': sRegCod,
                        'response': sResponse,
                        'ideuser': iIdEUser,
                        'codeeuser': sCodeEUser,
                        'password': sPassword
                    }
                }
                $.ajax(oAjax).done(function(oResponse){
                    setMessage(oResponse.text.client);
                    if(oResponse.status == 1){
                        goTo('', '');
                    }else{
                        goTo('recoverPassword/', '');
                    }
                }).fail(function(){});
            }else{
                setMessage(oResponse.text.client);
                goTo('', '');
            }
        }).fail(function(){});
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
    sText = g_oMGlobal.YOU_MUST_ADD_A_PASSWORD[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.PASSWORD_LEAST_5_CHARACTERS[g_iIdLanguage];
    if(!validatePassword(sFieldName, sText)){ return false; }

    sFieldName = 'rpassword';
    sText = g_oMGlobal.YOU_MUST_REPEAT_THE_PASSWORD[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'password';
    sFieldName2 = 'rpassword';
    sText = g_oMGlobal.PASSWORDS_DO_NOT_MATCH[g_iIdLanguage];
    if(!validatePasswords(sFieldName, sFieldName2, sText)){ return false; }

    sText = g_oMGlobal.YOU_MUST_COMPLETE_CAPTCHA[g_iIdLanguage];
    if(!validateReCaptcha(sText)){return false;}

    return true;
}