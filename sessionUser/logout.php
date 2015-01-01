<?
	// 제작 : (주)비야 - 원동규
	// 기능 : 로그아웃
	// 날짜 : 2011-10-25

	// 데이터 사용 인클루드
	include_once($_SERVER['DOCUMENT_ROOT']."/config/"."common.php");

	// 로그아웃
	if (!empty($_SESSION['_UserID']))
	{
		$_SESSION['_AdminUserNo']		= "";
		$_SESSION['_UserID']			= "";
		$_SESSION['_UserName']			= "";
		$_SESSION['_CodeNumber']		= "";
		$_SESSION['_AdminAuthGroupNo']	= "";
	}

	header("location:/".$_CONFIG['DIR_ADMIN']."/"); // 주소이동
?>
