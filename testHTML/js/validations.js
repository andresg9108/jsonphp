"use strict";

/*
*/
function validateTexto(sName, sText){
    let oObject = document.getElementById(sName);
    $("#err"+sName).html('');
    if (oObject.value.replace(/^\s+/,'').replace(/\s+$/,'').length == 0) {
        oObject.focus();
        $("#err"+sName).html(sText);
        return false;
    }
    return true;
}

/*
*/
function validateEmail(sName, sText){
    let oObject = document.getElementById(sName);
    $("#err"+sName).html('');
    if (!validateValidMail(oObject.value)) {
        oObject.focus();
        $("#err"+sName).text(sText);
        return false;
    }
    return true;
}

/*
*/
function validateValidMail(sEmail){
    let sExpr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!sExpr.test(sEmail)){
        return false;
    }
    return true;
}

/*
*/
function validateCombo(sName, sText){
    let oObject = document.getElementById(sName);
    $("#err"+sName).html('');
    if (oObject.selectedIndex == 0) {
        oObject.focus();
        $("#err"+sName).html(sText);
        return false;
    }
    return true;
}

/*
*/
function validateCheck(sName, sText){
    let oObject = document.getElementById(sName);
    $("#err"+sName).html('');
    if (!oObject.checked) {
        oObject.focus();
        $("#err"+sName).text(sText);
        return false;
    }
    return true;
}

/*
*/
function validateReCaptcha(sText){
    if(g_bReCaptcha){
        let oObject = document.getElementById('g-recaptcha-response');
        if (oObject.value.replace(/^\s+/,'').replace(/\s+$/,'').length == 0) {
            oObject.focus();
            $("#errrobot").text(sText);
            return false;
        }
    }
    return true;
}

/*
*/
function validateFiles(aFile, sText){
    let bValid = false;
    $("#errfile").html('');
    $.each(aFile, function(i, v){
        if($("#"+v).val() !== ''){
            bValid = true;
        }
    });

    if(!bValid){
        $("#errfile").html(sText);
    }
    return bValid;
}

/*
*/
function validateFileExt(sNameFile){
    if (!(/.(gif|jpeg|jpg|png|GIF|JPEG|JPG|PNG)$/i.test(sNameFile))){
        return false;
    }
    return true;
}

/*
*/
function validateFileSize(iFileSize){
    if (iFileSize > 6000000){
        return false;
    }
    return true;
}