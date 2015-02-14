<?
class Json extends MadJson {
	function getIndex() {
		return globR( '*.json' );
	}
}
