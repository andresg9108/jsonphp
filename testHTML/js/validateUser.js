"use strict";

$(function(){
	setView();
});

function setView(){
	let iId = getParameterBysName('id');
	let sCode = getParameterBysName('code');
	
	console.log(iId);
	console.log(sCode);
}