function login_process() {
	var mform = document.LoginProcess;

	if (mform.USER_ID.value != "" && mform.USER_PW.value != "") {
		data_string = "USER_ID=" + mform.USER_ID.value + "&USER_PW=" + mform.USER_PW.value;
	} else {
		alert("로그인 정보를 모두 입력하세요.");
		return;
	}

	$.ajax({
		type: "POST",
		url: "login_process.php",
		data: data_string,
		success: function(msg)
	{
		AjaxMsgListener(msg);
	}
	});
}

$(function() {
	$("input[name='USER_ID']").focus();
});
