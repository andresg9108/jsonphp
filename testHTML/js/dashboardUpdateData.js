"use strict";

$(function(){
    setView();
});

/*
*/
function setView(){
	validateSession(true);

	let sMessage = getMessage();
    $("#messageerr").html(sMessage);
}

/*
*/
function updateDataAction(){
	if(validateUpdateDataAction()){
        let sSessionCode = getSession();
        let sName = $("#name").val();
        let sLastName = $("#last_name").val();
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
                    url: g_sBackEnd+'administration/person/update',
                    type: 'post',
                    data: {
                        'id': iId,
                        'registration_code': sRegCod,
                        'response': sResponse,
                        'code': sSessionCode,
                        'name': sName,
                        'last_name': sLastName
                    }
                }
                $.ajax(oAjax).done(function(oResponse){
                    console.log(oResponse);
                });
            }
        });
	}

	return false;
}

/*
*/
function validateUpdateDataAction(){
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

    sText = g_oMGlobal.YOU_MUST_COMPLETE_CAPTCHA[g_iIdLanguage];
    if(!validateReCaptcha(sText)){return false;}

    return true;
}