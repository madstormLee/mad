<%@ page import="java.io.*" %>
<%@ include file="config.jsp" %>
<%
	String filePath = request.getParameter("img");
    int idx = filePath.lastIndexOf('/');
	filePath = SAVE_DIR + filePath.substring(idx);

	File file = new File(filePath);
	file.delete();
%>
