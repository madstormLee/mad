<%@ page language="java" contentType="text/html; charset=EUC-KR"
	pageEncoding="EUC-KR"%>
<html>
<head>
<title>InnoAP</title>
<script type="text/javascript" language="JavaScript">
<!--



function Upload()
{
	if (InnoAPSubmit(document.f_write))
	{
		document.f_write.submit();
	}
}
//-->
</script>
</head>

<body>
<form action="action.jsp" name="f_write" method="post"
	enctype="multipart/form-data">test1 : <input type="text"
	name="test1"><br>
<script language="JavaScript" src="InnoAP.js"></script>

<table border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td style="border: 1px solid #C0C0C0;"><script
			language="JavaScript">
<!--
var Enc = "waApny6yxGG4iCQDEiKdJByj4utvu1u4AlkPxE3nwonPBQ1Lz4s/nLWWZ9/HwOl99Mb4LUyc2agg2W8HtvG9P+aKMg21icSao/x+AmmU97JOf6jW2kap2dRYnpbjDvksAYPsFEz9XzoR7hOkGt6H5330cv1EKY72K2B79NYkKWEsdDXBFuBVvOTN4jER3x6IWcesb0RAvIUxsBqQx4I+WxvX3SI/qTC5C/3wpQUfh5eNQMABOLMZmAHVDcTDwbjORmnHNu1HLig=";

var InputName = "demo";
var ActionFilePath = "action.jsp";

var ListStyle = "Large Icon";
var ShowFullPath = "false";
var SetStatusWidth = "200|150|-1";

InnoAPInit(1024*100, 1024*100, 10, 0, 500, 300);
//-->
    </script></td>
	</tr>
</table>

<input type="button" value="파일찾기" onClick="document.InnoAP.OpenFile();">
<input type="button" value="전송하기" onClick="Upload();"></form>

<br>
<br>

<script for="InnoAP" event="OnUploadComplete(ResponseData);">
<!--
// ResponseData 에는 업로드 완료 후
// 화면에 표시되는 html 코드가 담겨 있습니다.
// 이 변수를 사용하여 다음 작업을 진행 하실 수 있습니다.
document.write(ResponseData);
//-->
</script>

</body>
</html>

