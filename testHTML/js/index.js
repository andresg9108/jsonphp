"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
    sessionStorage.setItem(g_sSession+'session', '');
    let sMessageErr = sessionStorage.getItem(g_sSession+'sessionMessage');
    $("#messageerr").html(sMessageErr);
}

/*
*/
function logInAction(){
    let sMessageErr = '';
    sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);

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
            if(oResponse.status){
                oResponse = oResponse.response;
                let bValid = oResponse.valid;
                let bStatus = oResponse.status;

                if(bValid){
                    if(bStatus){
                        let sCode = oResponse.code;
                        let iProfile = oResponse.profile;

                        if(iProfile == 1){
                            sessionStorage.setItem(g_sSession+'session', sCode);
                            location.href = 'dashboardAdmin';
                        }else if(iProfile == 2){
                            sessionStorage.setItem(g_sSession+'session', sCode);
                            location.href = 'dashboard';
                        }else{
                            sMessageErr = 'No tienes definido un perfil de usuario (Contacta con soporte).';
                            sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                            window.location.reload(true);
                        }
                    }else{
                        sMessageErr = 'Debes validar tu correo electrónico.';
                        sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                        window.location.reload(true);
                    }
                }else{
                    sMessageErr = 'Usuario o contraseña incorrecta.';
                    sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                    window.location.reload(true);
                }
            }else{
                sMessageErr = 'Usuario o contraseña incorrecta.';
                sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                window.location.reload(true);
            }
        })
        .fail(function(){});
    })
    .fail(function(){});

    return false;
}