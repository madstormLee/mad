<?
class MadXmlManager {
	private $data = array();

	function __construct( $xmlFile ) {
		$this->load($xmlFile);
	}
	function load($xmlFile){
		if ( ! is_file( $xmlFile ) ) {
			return $return;
		}
		$xml = simpleXML_load_file( $xmlFile );
		return $this->data = $this->parse( $xml );
	}
	function parse( $xml ) {
		$return = array();
		$name = $xml->getName();
		$_value = trim((string)$xml);
		if(strlen($_value)==0){$_value = null;};

		if($_value!==null){
			$return = $_value;
		}

		$children = array();
		$first = true;
		foreach( $xml->children() as $elementName => $child ) {
			$value = $this->parse($child);
			if(isset($children[$elementName])){
				$attributes = $this->getAttributes($child);
				$no = '';
				if ( isset($attributes['key']) ) {
					$no = $attributes['key'][0];
				}
				if($first){
					$temp = $children[$elementName];
					unset($children[$elementName]);
					$children[$elementName][$no] = $temp;
					$first=false;
				} else {
					$children[$elementName][$no] = $value;
				}
			}
			else{
				$children[$elementName] = $value;
			}
		}
		if(count($children)>0){
			$return = array_merge($return,$children);
		}

		$attributes = array();
		return $return;
	}
	function getAttributes( $xml ) {
		$rv = array();
		foreach( $xml->attributes() as $name => $value ) {
			$rv[$name] = (string)$value;
		}
		return $rv;
	}

	function test() {
		printR( $this->data );
	}
}
