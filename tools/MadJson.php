<?
// refactoring with MadJsonView. about autoBreak and some methods.
class MadJson extends MadData {
	protected $file = '';

	function __construct( $file = '' ) {
		$this->load( $file );
	}
	function isFile() {
		return is_file( $this->getFile() );
	}
	function getFile() {
		return $this->file;
	}
	function getFileInfo() {
		if ( ! is_file( $this->file ) ) {
			throw new Exception('File Not Found');
		}
		return new SplFileInfo( $this->file );
	}
	function setFile( $file ) {
		$this->file = $file;
		return $this;
	}
	function load( $file = '', $data = array() ) {
		$this->setFile( $file );
		if ( ! is_file ( $this->file ) ) {
			return $this;
		}
		$this->setJson( file_get_contents( $this->file ) );
		return $this;
	}


	function setFromDl( $dl ) {
		$this->setData( $this->dl2Array( $dl ) );
		return $this;
	}
	function removeAttributes( $text ) {
		return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
	}
	function dl2Array( $data ) {
		// $data = preg_replace('/<(dl|dt|dd) \w+\s*=\s*[\'"][^\'"]*[\'"]>/', "<$1>", $data );
		$data = $this->removeAttributes( $data );
		$data = json_decode( json_encode( new SimpleXMLElement( $data ) ) );
		$rv = $this->parseDl( $data->dl );
		return $rv;
	}
	private function parseDl( $data ) {
		$rv = array();
		foreach( $data as $row ) {
			if ( is_object( $row->dd ) || is_array( $row->dd ) ) {
				$dl = $row->dd->dl;
				if ( ! is_array( $dl ) ) {
					$dl = array( $dl );
				}
				$rv[$row->dt] = $this->parseDl($dl);
			} else {
				$rv[$row->dt] = $row->dd;
			}
		}
		return $rv;
	}

	function setJson( $json ) {
		$json = json_decode( $json );
		if( function_exists( 'json_last_error' ) && $errorNo = json_last_error() ) {
			throw new Exception( $this->getErrorMessage( $errorNo ) );
		}
		$data = array();
		foreach( $json as $key => $row ) {
			$data[$key] = $row;
		}
		$this->setData( $data );
		return $this;
	}
	function isJson( $string ) {
	}
	function getErrorMessage( $errorNo ) {
		$messages = array(
			JSON_ERROR_NONE => ' - No errors',
			JSON_ERROR_DEPTH => ' - Maximum stack depth exceeded',
			JSON_ERROR_STATE_MISMATCH => ' - Underflow or the modes mismatch',
			JSON_ERROR_CTRL_CHAR => ' - Unexpected control character found',
			JSON_ERROR_SYNTAX => ' - Syntax error, malformed JSON',
			JSON_ERROR_UTF8 => ' - Malformed UTF-8 characters, possibly incorrectly encoded',
		);
		if ( ! $message = ckKey( $messages, $errorNo ) ) {
			$message = ' - Unknown error';
		}
		return $message;
	}
	function save() {
		if ( empty( $this->file ) ) {
			return false;
		}
		$dir = dirName( $this->file );
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		return file_put_contents( $this->file, json_encode( $this->getArray() ) ) ? 1: 0;
	}
	function unlink() {
		return unlink( $this->file );
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
	private function iconv( $charset, &$data = array() ) {
		foreach( $data as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = $this->iconv( $charset, $value );
			} else {
				$value = iconv( 'utf-8', $charset, $value );
			}
		}
		return $data;
	}
	function decoding( $charset ) {
		$this->setData( $this->iconv( $charset, $this->getArray() ) );
		return $this;
	}
	// this must go to view.
	function getString( $data, $tabs = 0 ) {
		$tab = $this->getTab( $tabs++ );
		$rv = "{\n";
		$contents = array();
		foreach( $data as $key => $value ) {
			$key = addCSlashes( $key, '"' );
			if ( is_array($value) ) {
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
		// return $this->getString( $this );
		$component = new MadComponent( 'MadJsonView' );
		$component->setAction( 'view' );
		$component->setModel( $this );
		return $component->getContents();
	}
	function getContents() {
		if ( ! empty( $this->data ) ) {
			return (string) json_encode($this->data);
		}
		return '[]';
	}
}
