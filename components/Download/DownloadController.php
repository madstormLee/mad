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
	function madtoolsAction() {
		$get = $this->get;
		$targets = array(
			'madtools' => MADTOOLS . 'madtools.php',
			'command' => 'configs/Installer/commands.json',
			'errors' => 'configs/Installer/errors.json',
			);
		$targets = new MadData( $targets );
		return file_get_contents( $targets->get( $get->target ) );
	}
	function xlsAction() {
		if ( ! $url = $this->get->url ) {
			throw new Exception( '?吒??? 立?? ?源洗?.');
		}
		if ( ! $fileName = $this->get->fileName ) {
			$fileName = 'temp.xls';
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].$url;
		$content = file_get_contents($url);
		if ( ! $content ) {
			throw new Exception('?????? 粮?????? ?式来洗?.');
		}
		$this->main = $content;
	}
}
