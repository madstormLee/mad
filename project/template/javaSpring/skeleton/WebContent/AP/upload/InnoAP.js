var Enc = new String();
var Prod = new String();
var Prod = "A2M_ENZEN_SOLUTION_InnoAP";

var UseUnicode = "false";

var contextPath = '/';

var ActionFilePath = new String("");
var InputName = new String("file");
var InputType = "";
var InputTypeArray = "false";
var InputNameFixed = "false";

var	DialogListHeight = "";
var ListStyle = new String("");
var ShowFullPath = "false";
var ShowStatus = "true";
var SetStatusWidth = new String("");
var BkImgURL = new String("");

var InnoAP_Cab = contextPath+"AP/upload/InnoAP5.cab";
var InnoAP_Version = "5,0,0,2185";

var InnoAP_LimitExt = new Array();

function InnoAP_CheckExt(strFileName)
{
    var bRet = false;
    if (InnoAP_LimitExt.length == 0)
	{
        return true;
	}

    var strExt = strFileName.split(".");
    var strExt2 = strExt[strExt.length-1].toLowerCase();
    for (var i = 0; i < InnoAP_LimitExt.length; i++)
    {
        var limitExt2 = InnoAP_LimitExt[i].toLowerCase();
        if (strExt2 == limitExt2)
        {
            bRet = true;
            break;
        }
    }

    if (!bRet)
        alert(strExt2 + " 파일은 등록하실 수 없습니다.");

    return bRet;
}

function InnoAP_getAbsoluteXY(obj)
{
    var top = 0;
    var left = 0;
    var retVal = new Array(2);

    do
	{
        top += obj.offsetTop;
        left += obj.offsetLeft;
    }
	while((obj = obj.offsetParent) != null);

    if (window.event != null)
	{
        retVal.x = window.event.x - left - 5;
        retVal.y = window.event.y - top;
    }

    retVal.top = top;
    retVal.left = left;

    return retVal;
}

function InnoAP_AppendDragDrop(ddObj, inputName)
{
    document.InnoAP.AppendDragDrop(ddObj, inputName);
}

function InnoAP_PtInObj(pt_x, pt_y, inObj, InputName)
{
	var objXY = InnoAP_getAbsoluteXY(inObj);

	var in_left = objXY.left - document.body.scrollLeft;
	var in_top = objXY.top - document.body.scrollTop;
	var in_right = in_left + inObj.offsetWidth;
	var in_bottom = in_top + inObj.offsetHeight;

	var retVal;
	if ( (in_left < pt_x && in_right > pt_x) &&
			(in_top < pt_y && in_bottom > pt_y) )
	{
		return true;
	}

	return false;
}

function GetInnoAPInitMulti(TotalMaxSize, UnitMaxSize, MaxFileCount, nMode, nWidth, nHeight, strID)
{
	TotalMaxSize = TotalMaxSize * 1024;
	UnitMaxSize = UnitMaxSize * 1024;

	if (nWidth == "undefined")
	{
		nWidth = "100%";
	}

	if (nHeight == "undefined")
	{
		nHeight = "100%";
	}

    var codeMSG = "codebase=\"" + InnoAP_Cab + "#version=" + InnoAP_Version + "\" ";

	var tStr =  "<object id=\"" + strID + "\" classid=\"CLSID:DC2D84BD-498D-48B1-808C-60236E7FE0C8\" " + codeMSG +
				"width=\"" + nWidth + "\" height=\"" + nHeight + "\"" +
				" VIEWASTEXT>" +

				"<param name=\"ENC\" value=\"" + Enc + "\">" +
				"<param name=\"Prod\" value=\"" + Prod + "\">" +

				"<param name=\"Action\" value=\"" + ActionFilePath + "\">" +
				"<param name=\"InputName\" value=\"" + InputName + "\">" +
				"<param name=\"InputTypeArray\" value=\"" + InputTypeArray + "\">" +
				"<param name=\"InputNameFixed\" value=\"" + InputNameFixed + "\">" +
				"<param name=\"ListStyle\" value=\"" + ListStyle + "\">" +
				"<param name=\"ShowFullPath\" value=\"" + ShowFullPath + "\">" +
				"<param name=\"ShowStatus\" value=\"" + ShowStatus + "\">" +

				"<param name=\"MaxFileCount\" value=\"" + MaxFileCount + "\">" +
				"<param name=\"MaxUnitFileSize\" value=\"" + UnitMaxSize + "\">" +
				"<param name=\"MaxTotalFileSize\" value=\"" + TotalMaxSize + "\">" +
				
				"<param name=\"UseUnicode\" value=\"" + UseUnicode + "\">" +
				"<param name=\"Language\" value=\"ko\">";

    if (InputType.length > 0)
	{
		tStr += "<param name=\"InputType\" value=\"" + InputType + "\">";
	}

    if (BkImgURL != "")
	{
		tStr += "<param name=\"BkImgURL\" value=\"" + BkImgURL + "\">";
	}

    if (DialogListHeight.length > 0)
	{
		tStr += "<param name=\"DialogListHeight\" value=\"" + DialogListHeight + "\">";
	}

	tStr += "</object>";
	
	return tStr;
}

function InnoAPInitMulti(TotalMaxSize, UnitMaxSize, MaxFileCount, nMode, nWidth, nHeight, strID)
{
    var tStr = GetInnoAPInitMulti(TotalMaxSize, UnitMaxSize, MaxFileCount, nMode, nWidth, nHeight, strID);
	document.write(tStr);

	////////////////////
	var bAvailable = false;
	var APObject = document.getElementById(strID);
	if (typeof(APObject) == 'object')
	{
		if (APObject.readyState == 4)
		{
			if (APObject.object != null)
			{
				bAvailable = true;
			}
		}
	}

	if (bAvailable)
	{
		try
		{
			if (SetStatusWidth.length > 0)
			{
				var zArr = SetStatusWidth.split('|');
				
				try
				{
					document.getElementById(strID).SetStatusWidth(0) = zArr[0];
					document.getElementById(strID).SetStatusWidth(1) = zArr[1];
					document.getElementById(strID).SetStatusWidth(2) = zArr[2];			
				}
				catch (ex) { 
				}
			}
			
			eval("On" + strID + "Load()");
		}
		catch (ex) {}
	}
	else
	{
		// �̼�ġ Ȥ�� ������Ʈ�ʿ�� ó��
	}
	////////////////////
}

function InnoAPInit(TotalMaxSize, UnitMaxSize, MaxFileCount, nMode, nWidth, nHeight)
{
    InnoAPInitMulti(TotalMaxSize, UnitMaxSize, MaxFileCount, nMode, nWidth, nHeight, "InnoAP");
}

function InnoAPSubmitMulti(apObject, obj)
{
	if (apObject == "undefined")
	{
		return true;
	}

	for (var i = 0; i < obj.length; i++)
	{
		if (obj[i].type == "checkbox")
		{
			if (obj[i].checked == true)
			{
				apObject.AppendPostData(obj[i].name, obj[i].value);
			}

		}
		else if (obj[i].type == "radio")
		{
			if (obj[i].checked == true)
			{
				apObject.AppendPostData(obj[i].name, obj[i].value);
			}

		}
		else if (obj[i].type == "select-one")
		{
			if (obj[i].options[obj[i].selectedIndex].value.length > 0)
			{
				apObject.AppendPostData(obj[i].name, obj[i].options[obj[i].selectedIndex].value);
			}
			else
			{
				apObject.AppendPostData(obj[i].name, obj[i].options[obj[i].selectedIndex].value);
			}
		}
		else if (obj[i].type == "hidden"
					|| obj[i].type == "text"
					|| obj[i].type == "textarea"
					|| obj[i].type == "password"
					|| obj[i].type == "submit")
 		{
			apObject.AppendPostData(obj[i].name, obj[i].value);
		}
	}

	apObject.StartUpload();

	return false;
}

function InnoAPSubmit(obj)
{
	return InnoAPSubmitMulti(document.InnoAP, obj)
}

function end_action_writeln(end_file_name)
{
    var oInput  = document.createElement('<input type="hidden" name="ResponseData">');
    var oForm   = document.createElement('<form name="up_end" method="post">');

    oForm.action = end_file_name;
    document.body.insertAdjacentElement("afterBegin", oForm);
    oForm.insertAdjacentElement("afterBegin", oInput);
}

document.writeln('<script for="InnoAP" event="OnUploadComplete(rd);">');
document.writeln('<!--');
document.writeln('up_end.ResponseData.value = rd;');
document.writeln('up_end.submit();');
document.writeln('//-->');
document.writeln('</script>');

function GetImageLoader(strID, strFilename, nObjectWidth, nObjectHeight, nImageWidth, nImageHeight)
{
	var classid = "clsid:F4C5757A-005C-4D9B-B2B6-3067CFF840DB";
	var codebase = "InnoAP5.cab#version=1,0,3,615";

	var str = "";
	str += '<object id="'+strID+'" classid="'+classid+'" width="' + nObjectWidth + '" height="' + nObjectHeight + '"';
	str += ' codebase="'+codebase+'"';
	str += '>';
	str += '<param name="Enc" value="'+Enc+'">';
	str += '<param name="ImageName" value="'+strFilename+'">';
	str += '<param name="ImageWidth" value="'+nImageWidth+'">';
	str += '<param name="ImageHeight" value="'+nImageHeight+'">';
	str += '</object>';

	return str;
}

function LoadMultiImageLoader(strID, nObjectWidth, nObjectHeight, strFilename, nImageWidth, nImageHeight)
{
	document.writeln(GetImageLoader(strID, strFilename, nObjectWidth, nObjectHeight, nImageWidth, nImageHeight));
}

function LoadImageLoader(nObjectWidth, nObjectHeight, strFilename, nImageWidth, nImageHeight)
{
	document.writeln(GetImageLoader("InnoImageLoader", nObjectWidth, nObjectHeight, strFilename, nImageWidth, nImageHeight));
}
