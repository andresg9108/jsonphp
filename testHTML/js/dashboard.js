"use strict";

$(function(){
    setView();
});

/*
*/
function setView(){
	sSessionCode = sessionStorage.getItem(g_sSession+'session');
	validateSession();
}