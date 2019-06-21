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
function checkInAction(){
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
        
        let oAjax = {
            url: g_sBackEnd+'administration/publicData/appRegistration',
            type: 'post',
            data: {}
        }
        $.ajax(oAjax).done(function(oResponse){
            if(oResponse.status == 1){
                oResponse = oResponse.response;
                let iId = oResponse.id;
                let sRegCod = oResponse.registration_code;
                sRegCod = getDecodeRegCod(sRegCod);

                oAjax = {
                    url: g_sBackEnd+'administration/user/validateEmailAndUser',
                    type: 'post',
                    data: {
                        'id': iId,
                        'registration_code': sRegCod,
                        'email': sEmail,
                        'user': sUser
                    }
                }
                $.ajax(oAjax).done(function(oResponse){
                    $("#erremail").html("");
                    $("#erruser").html("");

                    oResponse = oResponse.response;
                    let bEmail = oResponse.email;
                    let bUser = oResponse.user;

if(bEmail || bUser){

    if(bEmail){
        $("#erremail").html(oResponse.erremail);
        let oObjectE = document.getElementById("email");
        oObjectE.focus();
    }
    if(bUser){
        $("#erruser").html(oResponse.erruser);
        let oObjectU = document.getElementById("user");
        oObjectU.focus();
    }

}else{

    // START OF USER REGISTRATION
    oAjax = {
        url: g_sBackEnd+'administration/publicData/appRegistration',
        type: 'post',
        data: {}
    }
    $.ajax(oAjax).done(function(oResponse){

        if(oResponse.status == 1){
            oResponse = oResponse.response;
            iId = oResponse.id;
            sRegCod = oResponse.registration_code;
            sRegCod = getDecodeRegCod(sRegCod);

            oAjax = {
                url: g_sBackEnd+'administration/user/checkIn',
                type: 'post',
                data: {
                    'id': iId,
                    'registration_code': sRegCod,
                    'response': sResponse,
                    'name': sName,
                    'last_name': sLastName,
                    'email': sEmail,
                    'user': sUser,
                    'password': sPassword
                }
            }
            $.ajax(oAjax).done(function(oResponse){
                if(oResponse.status == 1){
                    let sResponse = oResponse.text.client;
                    oResponse = oResponse.response;
                    let aEmail = oResponse.email;

                    sendEmail(aEmail);
                    setMessage(sResponse);
                    updatePage();
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
    // END OF THE USER REGISTRATION
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
function validateCheckInAction(){
    let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'name';
    sText = g_oMGlobal.YOU_MUST_ADD_A_NAME[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_NAME[g_iIdLanguage];
    if(!validateNameOrLastName(sFieldName, sText)){return false;}

    sFieldName = 'last_name';
    sText = g_oMGlobal.YOU_MUST_ADD_A_SURNAME[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_SURNAME[g_iIdLanguage];
    if(!validateNameOrLastName(sFieldName, sText)){return false;}

    sFieldName = 'email';
    sText = g_oMGlobal.YOU_MUST_ADD_AN_EMAIL[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_EMAIL[g_iIdLanguage];
    if(!validateEmail(sFieldName, sText)){return false;}

    sFieldName = 'user';
    sText = g_oMGlobal.YOU_MUST_ADD_A_USER[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_USER[g_iIdLanguage];
    if(!validateUsername(sFieldName, sText)){return false;}

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