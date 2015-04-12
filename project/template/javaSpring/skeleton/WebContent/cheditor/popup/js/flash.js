// ================================================================
//                       CHEditor 5.0
// ----------------------------------------------------------------
// Author: Na Chang Ho
// Homepage: http://www.chcode.com
// EMail: support@chcode.com
// Copyright (c) 1997-2010 CHSOFT
// ================================================================
var button = [
	{ alt : "", img : 'play.gif', cmd : doPlay },              
	{ alt : "", img : 'submit.gif', cmd : doSubmit },
	{ alt : "", img : 'cancel.gif', cmd : popupClose }
];

var oEditor = null;

function init(dialog) {
	oEditor = this;
	oEditor.dialog = dialog;
	
	var dlg = new Dialog(oEditor);
	dlg.showButton(button);
	
	dlg.setDialogHeight();
}

function doPlay()
{
    document.getElementById('fm_player').innerHTML = document.getElementById("fm_embed").value;
}

function doSubmit()
{
	var source = '' + oEditor.trimSpace(document.getElementById("fm_embed").value);
	if (source != '') {
		oEditor.insertFlash(source);
	}
	
	document.getElementById('fm_player').innerHTML = '';
    popupClose();
}

function popupClose() {
	document.getElementById('fm_player').innerHTML = '';
    oEditor.popupWinClose();
}