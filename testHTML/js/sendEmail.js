"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
	let iId = getParameterBysName('id');
    let sCode = getParameterBysName('code');

	let oAjax = {
        url: g_sBackEnd+'module/email/send',
        type: 'post',
        data: {
            'id': iId,
            'cod': sCode
        }
    }
    $.ajax(oAjax).done(function(oResponse){
    	let sMessage = oResponse.text.client;

    	if(oResponse.status == 1){
    		$("#message").html(sMessage);
    	}else{
    		$("#message").html(sMessage);
    	}
    }).fail(function(){});
}