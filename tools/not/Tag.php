<?
/************************************************
  * Tag class는 tagName에 의해 동적으로 data를 판단한다.
  * tagName이 dl이나 ul,ol인 경우 data를 associated array로 받아들이고,
  * table인 경우 matrix형(2차원 배열)으로 받는다.
  * 당연히 그에 따라서 자료형이 옳지 않을 때는 exception 처리하고,
  * 처리가 불가능한 부분에 도달하면 exception error를 내보낸다.
  * test()메소드는 tree를 반환한다.
  ***********************************************/

class Tag {
	// $id, $class, $tagName은 특별히 관리된다.
	// 특히 $id는 객체의 ID로 unique하게 관리된다.
	protected $tagName;
	protected $id;
	protected $class = array();
	protected $innerHTML = '';
	protected $attribute = array();
	protected $children = array();

	function __construct ($tagName, $set='') {
		if ( empty($set) ) { $set = array(); }
		$this->tagName = $tagName;
		$this->set( $set );
	}
	function set(array $set) {
		foreach($set as $key => $value) {
			$this->__set($key,$value);
		}
	}
	function setIni($iniFile, $flag = false) {
		if ( $flag !== false ) $flag = true;
		if ( is_file($iniFile) ) {
			$this->set(parse_ini_file($iniFile, $flag));
		}
	}
	function setHtml($htmlFile) {
		$this->innerHTML = new Layout($htmlFile);
	}
	// add()는 새로 생성한 Tag를 돌려보낸다.
	function add($tagName, $set='') {
		if ( empty($set) ) { $set = array(); }
		$child = new Tag($tagName, $set);
		if ( array_key_exists('id', $set) ) {
			$childId = $set['id'];
			$this->children[$childId] = $child;
		} else {
			$this->children[] = $child;
		}
		return $child;
	}
	function get() {
		// 여기에서 tag를 조합할 수 있지만, 표현상 makeTag()를 사용함.
		return $this->makeTag();
	}
	function __set($key,$value){
		// key값에 의해 동적으로 자료를 선별한다.
		// 자료에는 string 값과 array값이 있다.
		$keyString = array('innerHTML','id','tagName');
		$keyArray = array('class','attribute');

		if ( in_array($key, $keyString) ) {
			$this->$key = $value;
		} else if ( in_array($key,$keyArray) ) {
			$this->{$key}[] = $value;
		} else {
			$this->attribute[$key]=$value;
		}
	}
	function __get($key){
		// key값의 child가 있을 때는 우선 반환한다.
		// 때문에 chlid명이 attribute와 같은 경우 attribute에 접근 불가.
		if(array_key_exists($key,$this->children)){
			return $this->children[$key];
		} else if(array_key_exists($key,$this->attribute)){
			return $this->attribute[$key];
		}
	}
	function __toString () {
		return $this->makeTag();
	}
	function getChildren() {
		return $this->children;
	}
	function getAttributes() {
		return $this->attribute;
	}
	function getClass() {
		return $this->class;
	}
	function addClass( $className ) {
		$this->class[] = $className;
		return $this;
	}
	function removeClass( $className ) {
		unset($this->class[$className]);
	}
	function __call($method_name, $parameters){
		// add,remove로 시작하는 $method_name을 받아서 attribute를 처리
	}
	function addChild(Tag $tag){
		// 외부에서 만든 Tag를 넣을 경우에만 쓰인다.
		$this->children[$tag->getId()] = $tag;
	}
	function test() {
		print $this->innerHTML;
	}
	protected function makeTag() {
		$rv = '<' . $this->tagName;
		$rv .= empty($this->id) ? '' : " id='$this->id'";
		$rv .= $this->makeClasses();
		$rv .= $this->makeAttributes();
		$rv .= ">";
		foreach ( $this->children as $child ) {
			$rv .= $child;
		}
		$rv .= $this->innerHTML;
		$rv .= '</' . $this->tagName . ">\n";
		return $rv;
	}
	protected function makeClasses() {
		$rv = '';
		if ( ! empty($this->class) ){
			$this->class = array_unique($this->class);
			$rv = implode(' ',$this->class);
			$rv = " class='$rv'";
		}
		return $rv;
	}
	protected function makeAttributes() {
		$rv = '';
		foreach ( $this->attribute as $key => $value ) {
			$rv .= " $key='$value'";
		}
		return $rv;
	}
}
