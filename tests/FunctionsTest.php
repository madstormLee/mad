<?
class FunctionTest extends PHPUnit_Framework_TestCase {
	/**
	 * @dataProvider ckKeyProvider
	 */
	function testCkKeyTest( $key, $array, $default=false ) {
		$this->assertEquals( $default, ckKey( $key, $array, $default ) );
	}
	function ckKeyProvider() {
		$array = array(
			1 => true,
			2 => true,
			3 => true,
			4 => true,
			'test' => true,
			'this' => true,
			'is' => true,
			'in' => true,
		);
		return array(
			array(1,$array, $array[1]),
			array(2,$array, $array[2]),
			array(3,$array, $array[3]),
			array('this',$array, $array['this']),
			array('in',$array, $array['in']),
			array('not',$array),
			array('exists',$array),
			array('inArray',$array),
		);
	}
	/**
	 * @dataProvider ckValueProvider
	 */
	function testCkValueTest( $value, $array, $default=false ) {
		$this->assertEquals( $default, ckValue( $value, $array ) );
	}
	function ckValueProvider() {
		$array = array(
			1,
			2,
			3,
			4,
			'test',
			'this',
			'is',
			'in',
		);
		return array(
			array(1,$array, $array[0]),
			array(2,$array, $array[1]),
			array(4,$array, $array[3]),
			array('this',$array, $array[5]),
			array('in',$array, $array[7]),
			array('not',$array),
			array('exists',$array),
			array('inArray',$array),
		);
	}
}
