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
function checkInAction(){
    let sMessageErr = '';
    sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);

    let sFieldNameEmail = 'r_email';
    let sTextEmail = 'Ya hay un usuario registrado con este email.';
    let sFieldNameUser = 'r_user';
    let sTextUser = 'Elige otro nombre de usuario.';
    
    if(validateCheckInAction()){
        let sName = $("#r_name").val();
        let sLastName = $("#r_last_name").val();
        let sEmail = $("#r_email").val();
        let sUser = $("#r_user").val();
        let sPassword = $("#r_password").val();
        let sResponse = '';
        if(g_bReCaptcha){
            sResponse = $("#g-recaptcha-response").val();
        }

        let oDatos = {};
        let sUrl = 'administration/publicData/appRegistration';
        $.when($.post(g_sBackEnd+sUrl, oDatos), $.post(g_sBackEnd+sUrl, oDatos))
        .then(function(oResponse1, oResponse2){
            oResponse1 = oResponse1[0].response;
            oResponse2 = oResponse2[0].response;

            let iId1 = oResponse1.id;
            let sRegCod1 = oResponse1.registration_code;
            sRegCod1 = getDecodeRegCod(sRegCod1);

            let oDatos1 = {
                'id': iId1,
                'registration_code': sRegCod1,
                'email': sEmail,
                'user': sUser
            };
            let sUrl1 = 'administration/user/validateEmailAndUser';
            $.when($.post(g_sBackEnd+sUrl1, oDatos1))
            .then(function(oResponse){
                oResponse = oResponse.response;
                let bEmail = oResponse.email;
                let bUser = oResponse.user;

                if(!bEmail && !bUser){
                    let iId2 = oResponse2.id;
                    let sRegCod2 = oResponse2.registration_code;
                    sRegCod2 = getDecodeRegCod(sRegCod2);

                    let oDatos2 = {
                        'id': iId2,
                        'registration_code': sRegCod2,
                        'response': sResponse,
                        'name': sName,
                        'last_name': sLastName,
                        'email': sEmail,
                        'user': sUser,
                        'password': sPassword
                    };
                    let sUrl2 = 'administration/user/checkIn';
                    $.when($.post(g_sBackEnd+sUrl2, oDatos2))
                    .then(function(oResponse){
                        if(oResponse.status){
                            oResponse = oResponse.response;
                            let bRegistered = oResponse.registered;
                            let aEmail = oResponse.email;

                            if(bRegistered){
                                $.when(sendEmail(aEmail))
                                .then(function(oResponse){
                                    irA('checkIn/confirm.html', '');
                                })
                                .fail(function(){});
                            }else{
                                sMessageErr = 'Ocurrió un error al intentar hacer el registro. Intentalo más tarde.';
                                sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                                window.location.reload(true);
                            }
                        }else{
                            sMessageErr = 'Ocurrió un error al intentar hacer el registro. Intentalo más tarde.';
                            sessionStorage.setItem(g_sSession+'sessionMessage', sMessageErr);
                            window.location.reload(true);
                        }
                    })
                    .fail(function(){});
                }else{
                    if(bEmail){
                        $("#err"+sFieldNameEmail).html(sTextEmail);
                        let oObjectE = document.getElementById(sFieldNameEmail);
                        oObjectE.focus();
                    }
                    if(bUser){
                        $("#err"+sFieldNameUser).html(sTextUser);
                        let oObjectU = document.getElementById(sFieldNameUser);
                        oObjectU.focus();
                    }
                }
            })
            .fail(function(){});
        })
        .fail(function(){});
    }

    return false;
}

/*
*/
function validateCheckInAction(){
    let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'r_name';
    sText = 'Debes agregar un nombre.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_last_name';
    sText = 'Debes agregar un apellido.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_email';
    sText = 'Debes agregar un email.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'Agrega un email válido.';
    if(!validateEmail(sFieldName, sText)){return false;}

    sFieldName = 'r_user';
    sText = 'Debes agregar un usuario.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_password';
    sText = 'Debes agregar un password.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_rpassword';
    sText = 'Debes repetir el password.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_password';
    sFieldName2 = 'r_rpassword';
    sText = 'Las contraseñas no coinciden.';
    if(!validatePasswords(sFieldName, sFieldName2, sText)){ return false; }

    sText = "Debes completar el Captcha por seguridad.";
    if(!validateReCaptcha(sText)){return false;}

    return true;
}