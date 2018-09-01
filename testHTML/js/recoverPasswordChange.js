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