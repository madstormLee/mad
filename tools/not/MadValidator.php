<?
/*
   MadValidator에는 $rules 와 $data가 필요하다.
   한쪽은 검사 데이터, 한쪽은 피 검사 데이터 이다.
   양쪽 모두 MadSet 형식이므로, 적절히 데이터를 가공한다.
   */
class MadValidator {
	private $data;
	private $rules;
	private $validation = false;
	private $testLog = array();

	function __construct($data=''){
		$this->data = new MadSet($data);
	}
	function setRules($rules) {
		$this->rules = new MadSet($rules);
	}
	function test() {
		print 'Rules';
		print BR;
		print_r( $this->rules );
		print BR;
		print 'Datas';
		print BR;
		print_r( $this->data );
	}
	public function minTest($value, $min) {
		return ( strlen($value) < $min ) ? false : true;
	}
	public function maxTest($value, $max) {
		return ( strlen($value) > $max ) ? false : true;
	}
	public function getTestLog() {
		return $this->testLog;
	}
	public function printTestLog() {
		foreach( $this->testLog as $name => $log ) {
			foreach( $log as $test => $trouble ) {
				print BR;
				print "$name : $test 테스트에서 $trouble";
				print BR;
			}
		}
	}
	// $key는 data와 rules의 공용 key이다.
	private function unitTest($key) {
		$rule = $this->rules->$key;
		$value = $this->data->$key;
		if ( $value === false ) {
			$this->validation = false;
			$this->testLog[$key]['EXIST']="값이 존재하지 않음";
		}
		// min testing
		if ( isset( $rule['min'] ) ) {
			if ( $this->minTest($value,$rule['min']) === false ) {
				$this->validation = false;
				$this->testLog[$key]['MIN']="값 '{$value}'는 {$rule['min']} 보다 작음";
			}
		}
		// max testing
		if ( isset( $rule['max'] ) ) {
			if ( $this->maxTest($value,$rule['max']) === false ) {
				$this->validation = false;
				$this->testLog[$key]['MAX']="값 '{$value}'는 {$rule['max']} 보다 큼";
			}
		}
	}
	function validate( $rules = '' ){
		if ( ! empty($rules) ) $this->setRules($rules);
		$this->validation = true;
		$rules = $this->rules->get();
		if ( empty($rules) ) {
			$this->testLog['RULES']['EXIST'] = "룰이 존재하지 않음.";
			return $this->validation = false;
		}

		foreach ( $rules as $unitName => $rule ) {
			$this->unitTest($unitName);
		}
		return $this->validation;
	}
	function compareId(){
		extract($this->post);
		$id = $_SESSION['id'];
		if ( empty($no) || empty($id) ) alert('아이디가 일치하지 않습니다.');
		$query = "select no from $this->table where no=$no and id='$id'";
		$q=new Q($query);
		if ( $q->rows() > 0 ) return true;
		alert('아이디가 일치하지 않습니다.');
	}
	function comparePassword(){
		extract($this->post);
		if ( empty($no) || empty($pw) ) return false;
		$query = "select no from $this->table where no=$no and pw=password('$pw')";
		$q=new Q($query);
		if ( $q->rows() > 0 ) return true;
		alert('패스워드가 일치하지 않습니다.');
	}
	function confirmPassword(){
		$pw = $_POST['pw'];
		$pw_confirm = $_POST['pw_confirm'];
		if ( $pw !== $pw_confirm ){
			alert('패스워드와 패스워드 확인이 일치하지 않습니다.');
		}
		$this->removeSet('pw_confirm');
	}
	function checkEmail(){
	}
}
