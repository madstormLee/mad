<?
class MadValidator {
	private $data;

	function __construct( $data = '' ) {
		$this->setData( $data );
	}
	function setData( $data ) {
		if ( empty( $data ) ) {
			return false;
		}
		$this->data = $data;
	}
	private function getArgs( $string ) {
		if ( $match = preg_match_all( "/(?<=[\"'])(?!,).*?(?=[\"'])/", $string, $args ) ) {
			return $args[0];
		}
		return array();
	}
	private function call( $command ) {
		$parts = explode( '(', $command );
		$func = explode('::', $parts[0] );

		$args = $this->getArgs( $parts[1] );

		return call_user_func_array( $func, $args );
	}
	function interpret( $result ) {
		if ( ! isset( $this->data->interpret ) ) {
			return $result;
		}
		return $this->checks( $this->data->interpret, $result ); 
	}
	function validate( $params ) {
		if ( ! isset( $this->data->validate ) ) {
			return false;
		}
		foreach( $this->data->validate as $key => $checks ) {
			if ( $result = $this->checks( $checks, $params->$key ) ) {
				return $result;
			}
		}
		return false;
	}
	function checks( $checks, $value ) {
		foreach( $checks as $function => $message ) {
			if ( $this->check( $function, $value ) ) {
				return $message;
			}
		}
		return false;
	}
	function check( $function, $value ) {
		if ( $function == 'default' ) {
			return true;
		}

		$reverse = false;
		if ( $function[0] == '!' ) {
			$reverse = true;
			$function = substr( $function, 1 );
		}
		if ( $function[0] == '/' ) {
			$result = preg_match( $function, $value );
		} else if ( $function == 'empty' ) {
			$result = empty( $value );
		} else {
			$result = $function( $value );
		}
		if ( $reverse ) {
			$result = ! $result;
		}
		return $result;
	}
}
