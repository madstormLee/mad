<?
class NomadController extends Preset {
	function indexAction() {
		return new MadView;
	}
	function projectPierAction() {
		$get = $this->get;
		$queryString = $_SERVER['QUERY_STRING'];
		$target = "/nomad/projectPier/index.php?" . $queryString;
		
		$iFrame = new IFrame( $target );
		return $iFrame;
	}
}
