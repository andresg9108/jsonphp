"use strict";

$(function(){
    setView();
});

/*
*/
function setView(){
    validateSession(false);
    
    let sMessage = getErrorMessage();
    $("#messageerr").html(sMessage);
}

/*
*/
function checkInAction(){
    let sFieldNameEmail = 'email';
    let sTextEmail = 'There is already a registered user with this email.';
    let sFieldNameUser = 'user';
    let sTextUser = 'Choose another username.';
    
    if(validateCheckInAction()){
        let sName = $("#name").val();
        let sLastName = $("#last_name").val();
        let sEmail = $("#email").val();
        let sUser = $("#user").val();
        let sPassword = $("#password").val();
        let sResponse = '';
        if(g_bReCaptcha){
            sResponse = $("#g-recaptcha-response").val();
        }

        let oDatos = {};
        let sUrl = 'administration/publicData/appRegistration';
        $.when($.post(g_sBackEnd+sUrl, oDatos), $.post(g_sBackEnd+sUrl, oDatos))
        .then(function(oResponse1, oResponse2){
            if(oResponse1[0].status == 1 && oResponse2[0].status == 1){
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
                            if(oResponse.status == 1){
                                let sResponse = oResponse.text.client;
                                oResponse = oResponse.response;
                                let aEmail = oResponse.email;

                                $.when(sendEmail(aEmail))
                                .then(function(oResponse){
                                    setErrorMessage(sResponse);
                                    updatePage();
                                })
                                .fail(function(){});
                            }else{
                                setErrorMessage(oResponse.text.client);
                                updatePage();
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
            }else{
                setErrorMessage(oResponse1[0].text.client);
                goTo('', '');
            }
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

    sFieldName = 'name';
    sText = 'You must add a name.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'You must add a valid name.';
    if(!validateNameOrLastName(sFieldName, sText)){return false;}

    sFieldName = 'last_name';
    sText = 'You must add a surname.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'You must add a valid surname.';
    if(!validateNameOrLastName(sFieldName, sText)){return false;}

    sFieldName = 'email';
    sText = 'You must add an email.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'Add a valid email.';
    if(!validateEmail(sFieldName, sText)){return false;}

    sFieldName = 'user';
    sText = 'You must add a user.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'You must add a valid user and include at least 5 characters. Permitted characters: a, b, c ... 0, 1, 2, 3 ... hyphen (-), underscore (_) and period (.). Do not include accents of Spanish (Ej: á), the letter ñ, or spaces.';
    if(!validateUsername(sFieldName, sText)){return false;}

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