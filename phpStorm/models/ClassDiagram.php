<?
class ClassDiagram extends MadJson {
	/*madTemp 대략 이런식으로 나중에 가면 될 듯 하다.
	  $package = new Package( $this->get->name );
	  $view->package = $package;
	 */
	function getControllerMethods() {
		return new MadJson( 'configs/json/mockClass.json');
	}
	function getModelMethods() {
		return new MadJson( 'configs/json/mockClassModel.json');
	}
}
