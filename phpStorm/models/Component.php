<?
class Component extends MadJson {
	function getControllerMethods() {
		return new MadJson( 'configs/json/mockClass.json');
	}
	function getModelMethods() {
		return new MadJson( 'configs/json/mockClassModel.json');
	}
}

