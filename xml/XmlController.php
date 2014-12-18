<?
class XmlController extends MadController {
	function viewAction() {
		MadHeaders::xml();
		return file_get_contents( $this->params->file );
	}
}
