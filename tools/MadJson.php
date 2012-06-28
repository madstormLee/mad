<?
class MadJson extends MadData {
	protected $file = '';

	function __construct( $file = '', $data = array() ) {
		$this->load( $file, $data );
	}
	function isFile() {
		return is_file( $this->getFile() );
	}
	function getFile() {
		return $this->file;
	}
	function setFile( $file ) {
		$fileParts = explode('.', $file);
		if ( end( $fileParts ) !== 'json' ) {
			$file = $file . '.json';
		}
		$this->file = $file;
		return $this;
	}
	function load( $file = '', $data = array() ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if ( is_file ( $this->file ) ) {
			$temp = array();
			foreach( $data as $key => $unit ) {
				$key = '{' . $key . '}';
				$temp[$key] = $unit;
			}
			$content = file_get_contents( $this->file );
			$content = str_replace( array_keys( $temp ), array_values( $temp ), $content );
			$this->setFromRaw( $content );
		}
		return $this;
	}
	function setFromRaw( $json ) {
		$json = json_decode( $json, 1 );
		if( function_exists( 'json_last_error' ) && $errorNo = json_last_error() ) {
			print $this->getError( $errorNo );
			print BR;
			print "file : $this->file" . BR;
			print  get_Class($this) . ' ' . __line__ . ' : ';
			die;
		}
		$this->setData( $json );
		return $this;
	}
	function getError( $errorNo ) {
		switch ( $errorNo ) {
			case JSON_ERROR_NONE:
				return ' - No errors';
				break;
			case JSON_ERROR_DEPTH:
				return ' - Maximum stack depth exceeded';
				break;
			case JSON_ERROR_STATE_MISMATCH:
				return ' - Underflow or the modes mismatch';
				break;
			case JSON_ERROR_CTRL_CHAR:
				return ' - Unexpected control character found';
				break;
			case JSON_ERROR_SYNTAX:
				return ' - Syntax error, malformed JSON';
				break;
			case JSON_ERROR_UTF8:
				return ' - Malformed UTF-8 characters, possibly incorrectly encoded';
				break;
			default:
				return ' - Unknown error';
				break;
		}
	}
	function save() {
		if ( empty($this->data) || empty( $this->file ) ) {
			return false;
		}
		$dir = dirName( $this->file );
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		return file_put_contents( $this->file, json_encode( $this->getArray() ) ) ? 1: 0;
	}
	function getRaw() {
		$data = json_encode( $this->getArray() );

		// \u -> %로 변환. \u 가 아닌 것들은 %00X로 변환
		$data = preg_replace("/((\\\u([0-9A-F]+))|(.*?))/ie", "self::conv(\"$1\")", $data);

		// url decode
		$data = rawurldecode($data);

		// 적절히 인코딩 변환 후 출력 해보기
		$data = iconv('utf-16be', 'utf-8', $data);

		$data = $this->autoBreak( $data );
		$data = $this->autoIndent( $data );

		return implode("\n", $data);
	}
	function autoBreak( $data ) {
		$data = str_replace('{', "{\n", $data);
		$data = str_replace('}', "\n}", $data);
		$data = str_replace('[', "[\n", $data);
		$data = str_replace(']', "\n]", $data);
		$data = str_replace('",', '",' . "\n", $data);
		$data = str_replace('},', '},' . "\n", $data);
		$data = str_replace('],', '],' . "\n", $data);
		return $data;
	}
	function autoIndent( $data ) {
		$lines = explode( "\n", $data );

		$tabs = 0;
		$number = 1;
		foreach( $lines as $key => &$line ) {
			if ( false !== strpos( $line, '}' ) 
					|| false !== strpos( $line, ']' ) ) {
				--$tabs;
			}
			$tab = '';
			for( $i = 0; $i < $tabs; ++$i ) {
				$tab .= "\t";
			}
			$line = $tab . $line;
			if ( false !== strpos( $line, '{' ) 
					|| false !== strpos( $line, '[' ) ) {
				++$tabs;
			}
		}
		return $lines;
	}
	// 정규식으로 뜯어낸 문자열을 적절히 변환
	private static function conv($hex) {       
		// 빈 값이면 빈값 반환
		if ( strlen( $hex ) < 1 ) {
			return '';
		}
		// 유니코드 문자열이 아니라면 url decode 되도록 구성하여 반환
		if ( strpos($hex, '\u') !== 0 ) {
			return '%00'.$hex;
		}

		$hex = self::getFormatted($hex);

		$rv = '';
		for ($i=0; $i<strlen($hex); $i++) {
			if ($i%2==0) $rv .= '%';
			$rv .= $hex[$i];
		}

		return $rv;
	}
	// urldecode 할 수 있도록 포매팅
	private static function getFormatted($hex) {
		$hex = str_replace('\u', '', $hex);

		$max = 4;
		$len = strlen($hex);
		if ($len<$max) {
			for ($i=$len; $i<$max; $i++) $hex = '0'.$hex;
		}

		return $hex;
	}
	// 일단 []는 포기하고 {}만 처리
	private function getTab( $tabs ) {
		$tab = '';
		for( $i = 0; $i < $tabs; ++$i ) {
			$tab .= "\t";
		}
		return $tab;
	}
	function getString( $data, $tabs = 0 ) {
		$tab = $this->getTab( $tabs++ );
		$rv = "{\n";
		$contents = array();
		foreach( $data as $key => $value ) {
			$key = addCSlashes( $key, '"' );
			if ( isArray($value) ) {
				$contents[] = "$tab\t\"$key\" : " . $this->getString( $value, $tabs );
			} else {
				$value = addCSlashes( $value, '"' );
				$contents[] = "$tab\t\"$key\" : \"$value\"";
			}
		}
		$rv .= implode( ",\n", $contents );
		$rv .= "\n$tab}";
		return $rv;
	}
	function __toString() {
		return $this->getString( $this );
	}
	function test() {
		print BR;
		print $this->file;
		print BR;
		printR( $this->data );
	}
}
