document.observe('dom:loaded',function() {
	new IdgHwpCtrl();
});
var IdgHwpCtrl = Class.create({
MinVersion : 0x0505010C,
data: null,
hwpCtrl: null,
formats: ["HWP","HTML","TEXT","UNICODE","MSWORD"],
initialize: function() {
	this.hwpCtrl = $('HwpCtrl');
	this._VerifyVersion();
	this.hwpCtrl.SetClientName("DEBUG");
	this.InitToolBar();

	if(!HwpControl.HwpCtrl.Open(HwpControl.urlloc.value, ""))
	{
	alert("Base Path가 잘못 지정된 것 같습니다. 소스에서 BasePath 를 수정하십시요");
	}
},
_VerifyVersion: function () {
	// 설치확인
	if(pHwpCtrl.getAttribute("Version") == null)
	{
		alert("한글 컨트롤이 설치되지 않았습니다.");
		return;
	}
	//버젼 확인
	CurVersion = pHwpCtrl.Version;
	if(CurVersion < MinVersion) {
		alert ( '한글 버전이 너무 낮습니다.' );
		}
},
function InitToolBar() {
	this.hwpCtrl.SetToolBar(0, "FilePreview, Print, Separator, Undo, Redo, Separator, Cut, Copy, Paste,"
			+"Separator, ParaNumberBullet, MultiColumn, SpellingCheck, HwpDic, Separator, PictureInsertDialog, MacroPlay1");

	this.hwpCtrl.SetToolBar(1, "DrawObjCreatorLine, DrawObjCreatorRectangle, DrawObjCreatorEllipse,"
			+"DrawObjCreatorArc, DrawObjCreatorPolygon, DrawObjCreatorCurve, DrawObjCreator, DrawObjTemplateLoad,"
			+"Separator, ShapeObjSelect, ShapeObjGroup, ShapeObjUngroup, Separator, ShapeObjBringToFront,"
			+"ShapeObjSendToBack, ShapeObjDialog, ShapeObjAttrDialog");

	this.hwpCtrl.SetToolBar(2, "StyleCombo, CharShapeLanguage, CharShapeTypeFace, CharShapeHeight,"
			+"CharShapeBold, CharShapeItalic, CharShapeUnderline, ParagraphShapeAlignJustify, ParagraphShapeAlignLeft,"
			+"ParagraphShapeAlignCenter, ParagraphShapeAlignRight, Separator, ParaShapeLineSpacing,"
			+"ParagraphShapeDecreaseLeftMargin, ParagraphShapeIncreaseLeftMargin");
	this.hwpCtrl.ShowToolBar(true);

},
function URLOpen( url, format ) {
	if ( ! format ) {
		format = "HTML";
	}
	// 가능하면 format은 this.formats에 존재하는 것만 받는다.
	if(! this.hwpCtrl.Open( url , format, "code:acp;url:true") ) {
		alert("문서 열기 실패");
	}
}
});
