<%@ page import="java.io.*" %>
<%@ include file="config.jsp" %>
<%
String contentType = request.getContentType();

if ((contentType != null) && (contentType.indexOf("multipart/form-data") >= 0))
{
    DataInputStream in = new DataInputStream(request.getInputStream());

    // 컨텐츠 전체 길이
    int contentLength = request.getContentLength();

    byte dataBytes[] = new byte[contentLength];
    int byteRead = 0;
    int totalBytesRead = 0;

    while (totalBytesRead < contentLength) {
        byteRead = in.read(dataBytes, totalBytesRead, contentLength);
        totalBytesRead += byteRead;
    }

    String szFile = new String(dataBytes);

    // 원본 파일 이름을 추출한다.
    String saveFile = szFile.substring(szFile.indexOf("filename=\"") + 10);
    saveFile = saveFile.substring(0, saveFile.indexOf("\n"));
    saveFile = saveFile.substring(saveFile.lastIndexOf("\\") + 1, saveFile.indexOf("\""));
    
    int lastIndex = contentType.lastIndexOf("=");
    String boundary = contentType.substring(lastIndex + 1,contentType.length());

    // 헤더를 제외한 데이터 BODY의 시작 위치 값을 얻는다.
    int pos;
    pos = szFile.indexOf("filename=\"");
    pos = szFile.indexOf("\n", pos) + 1;
    pos = szFile.indexOf("\n", pos) + 1;
    pos = szFile.indexOf("\n", pos) + 1;

    // 파일 시작 위치 값을 얻는다.
    int startPos = ((szFile.substring(0, pos)).getBytes()).length;

    // 실제 파일 크기를 얻는다.
    //out.println(contentLength - startPos - (boundary.length() + 8));
    int dataLength = contentLength - startPos - (boundary.length() + 8);

    // 랜덤하게 파일 이름을 만든다.
    String fileName = "";
    for (int i=1; i < 21; i++) {
        int rnd = 1 + (int)(Math.random() * 52);
        rnd = (rnd > 26) ? rnd + 70 : rnd + 64;
        fileName = fileName + (char)(rnd);
    }

    int idx = saveFile.lastIndexOf('.');
    if (idx != -1) {
        String extension = saveFile.substring(idx).toLowerCase();
        fileName = fileName + extension;
    }

    String saveAsFile = SAVE_DIR + fileName;
    FileOutputStream fileOut = new FileOutputStream(saveAsFile);

    fileOut.write(dataBytes, startPos, dataLength);
    fileOut.flush();
    fileOut.close();

	// 출력
	out.println("{ fileUrl:'" + SAVE_URL + fileName + "', filePath:'" + saveAsFile +
	"', origName:'" + saveFile + "', fileName:'" + fileName + "', fileSize:'" + dataLength + "'}");
}
%>
