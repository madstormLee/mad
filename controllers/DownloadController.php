<?
class DownloadController extends MadController {
	function __construct() {
		parent::__construct();
		$this->setFront(MadController::MAINONLY_LAYOUT);
		if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) {
			header("Content-Type: doesn/matter");
			header("Content-Disposition: filename=$fileName");
			header("Content-Transfer-Encoding: binary");
		} else {
			Header("Content-type: file/unknown");
			Header("Content-Disposition: attachment; filename=$fileName");
			Header("Content-Description: PHP Generated Data");
		}
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	function indexAction() {
	}
	function csvAction() {
	}
	function xlsAction() {
		if ( ! $url = ckGet('url') ) {
			alert('잘못된 접근 입니다.','back','replace');
			die;
		}
		if ( ! $fileName =ckGet('fileName')) {
			$fileName = 'temp.xls';
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].$url;
		$content = file_get_contents($url);
		if ( ! $content ) {
			alert('내용이 존재하지 않습니다.','back','replace');
			
		}
		$this->main = $content;
	}
}
