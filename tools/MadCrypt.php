<?
// this mixed with CI and Easy Crypt.
class MadCrypt {
	private $salt = '!kQm*fF3pXe1Kbm%9';
	private $password = 'madstorm rules!';

	private $name = 'CI';
	private $key = 'c7e637739aca8a39ffaba0581fab71f7'; // md5( 'himobileapp' )
	private $cipher = MCRYPT_RIJNDAEL_128;
	private $mode = MCRYPT_MODE_CBC;

	public function __construct( $name = '' ) {
		$this->name = $name;
		if ( $name == 'CI' ) {
			$this->key = '9ee779cd2abcde48524485572c6ce2a2'; // md5( 'abcdefghijklmnopqrstuvwxyz123456' )
			$this->cipher = MCRYPT_RIJNDAEL_256;
			$this->mode = MCRYPT_MODE_CBC;
		} elseif ( $name == 'Easy' ) {
			$this->key = 'c7e637739aca8a39ffaba0581fab71f7'; // md5( 'himobileapp' )
			$this->cipher = MCRYPT_RIJNDAEL_128;
			$this->mode = MCRYPT_MODE_CBC;
		}
	}
	function getKey( $key ) {
		return $this->key;
	}
	function setKey( $key ) {
		$this->key = $key;
		return $this;
	}
	function setCipher( $cipher ) {
		$this->cipher  = $cipher;
		return $this;
	}
	function getCipher() {
		return $this->cipher;
	}
	function setSalt( $salt ) {
		$this->salt = $salt;
	}
	function setPassword( $password ) {
		$this->password = $password;
	}
	function encrypt( $decrypted ) {
		$key = hash('SHA256', $this->salt . $this->password, true);
		srand();
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
		if ( strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22 ) {
			return false;
		}
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
		// We're done!
		return $iv_base64 . $encrypted;
	}
	function decrypt( $encrypted ) {
		$key = hash('SHA256', $this->salt . $this->password, true);
		$iv = base64_decode(substr($encrypted, 0, 22) . '==');
		$encrypted = substr($encrypted, 22);
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
		$hash = substr($decrypted, -32);
		$decrypted = substr($decrypted, 0, -32);
		if (md5($decrypted) != $hash) {
			return false;
		}
		return $decrypted;
	}
	function encode( $value ) {
		if ( $this->name == 'CI' ) {
			return $this->encodeCI( $value );
		}
		return $this->encodeEasy( $value );
	}
	function encodeEasy($value) {                
		$padSize = 16 - ( strlen ($value) % 16 );
		$value = $value . str_repeat (chr ($padSize), $padSize) ;
		$output = mcrypt_encrypt ($this->cipher, $this->key, $value, $this->mode, str_repeat(chr(0),16)) ;                
		return base64_encode ($output) ;        
	}

	function encodeCI($data) {
		$init_size = mcrypt_get_iv_size($this->cipher, $this->mode);
		$iv = mcrypt_create_iv($init_size, MCRYPT_RAND);

		$rv = $iv.mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $iv);
		$rv = $this->addNoise($iv.mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $iv));
		return base64_encode( $rv );
	}
	function decode( $value ) {
		if ( $this->name == 'CI' ) {
			return $this->decodeCI( $value );
		}
		return $this->encodeEasy( $value );
	}
	function decodeEasy( $value ) {
		$value = base64_decode ($value) ;                
		$output = mcrypt_decrypt ($this->cipher, $this->key, $value, $this->mode, str_repeat(chr(0),16)) ;                

		$valueLen = strlen ($output) ;
		if ( $valueLen % 16 > 0 ) {
			$output = "";
		}

		$padSize = ord ($output{$valueLen - 1}) ;
		if ( ($padSize < 1) or ($padSize > 16) ) {
			$output = "";                // Check padding.                
		}

		for ($i = 0; $i < $padSize; $i++) {
			if ( ord ($output{$valueLen - $i - 1}) != $padSize )
				$output = "";
		}
		$output = substr ($output, 0, $valueLen - $padSize) ;

		return $output;        
	} 
	function decodeCI($data) {
		// url decoded data must replace empty space to +
		$data = str_replace( ' ', '+', $data );

		if (preg_match('/[^a-zA-Z0-9\/\+=]/', $data)) {
			return FALSE;
		}
		$data = base64_decode($data);

		$data = $this->removeNoise($data);
		$init_size = mcrypt_get_iv_size($this->cipher, $this->mode);

		if ($init_size > strlen($data)) {
			return FALSE;
		}

		$iv = substr($data, 0, $init_size);
		$data = substr($data, $init_size);
		return rtrim(mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $iv), "\0");
	}
	private function addNoise($data) {
		$keyhash = sha1($this->key);
		$keylen = strlen($keyhash);
		$str = '';

		for ($i = 0, $j = 0, $len = strlen($data); $i < $len; ++$i, ++$j) {
			if ($j >= $keylen) {
				$j = 0;
			}

			$str .= chr((ord($data[$i]) + ord($keyhash[$j])) % 256);
		}

		return $str;
	}

	private function removeNoise($data) {
		$keyhash = sha1($this->key);
		$keylen = strlen($keyhash);
		$str = '';

		for ($i = 0, $j = 0, $len = strlen($data); $i < $len; ++$i, ++$j) {
			if ($j >= $keylen) {
				$j = 0;
			}

			$temp = ord($data[$i]) - ord($keyhash[$j]);

			if ($temp < 0) {
				$temp = $temp + 256;
			}

			$str .= chr($temp);
		}

		return $str;
	}
	function __get( $key ) {
		return $this->encrypt( $key );
	}
}
