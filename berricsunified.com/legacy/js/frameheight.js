// JavaScript Document

function sizeFrame() {
var F = document.getElementById("resultsFrame");
if(F.contentDocument) {
F.height = F.contentDocument.documentElement.scrollHeight; //
} else {

//F.height = F.contentWindow.document.body.offsetHeight; //

F.height = F.contentWindow.document.body.scrollHeight+30; //

	}
}

window.onload=sizeFrame;

