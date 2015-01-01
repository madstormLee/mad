<?
// 제작 : (주)비야 - 원동규
// 기능 : 로그인 세션 체크
// 날짜 : 2011-10-25

// 데이터 사용 인클루드
include_once($_SERVER['DOCUMENT_ROOT']."/config/"."common.php");

// 로그인이 필요한 상태에서 현재 요청된 페이지 기록
if (empty($_SESSION['_UserID'])) $_SESSION['_UrlRefer'] = $_SERVER['PHP_SELF'];

// 로그인 체크 (현재 경로, 관리자 폴더명)
$AdminLoginCheck = substr($_SERVER['PHP_SELF'], 1, strlen($_CONFIG['DIR_ADMIN']));

// 로그인이 필요한 경우 로그인 경로로 이동
if ($_CONFIG['DIR_ADMIN'] == $AdminLoginCheck)
{
	if ($_SERVER['PHP_SELF'] != $_SETUP['ADMINLOGIN'])
	{
		// 로그인이 필요한 상태
		if (empty($_SESSION['_UserID'])) {
			header("location:".$_SETUP['ADMINLOGIN']);
		}
		else {
			// 로그인이 필요없는 상태면 1회 해당 위치로 이동
			if ($_SESSION['_UrlRefer'] != "") {
				$gotoUrl = $_SESSION['_UrlRefer'];
				$_SESSION['_UrlRefer'] = "";
				header("location:".$gotoUrl);
			}
		}
	}
}
?>
