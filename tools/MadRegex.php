<?
class MadRegex {
	static function firstSrc( $content ) {
		$rv = false;

		$isSrc = preg_match('/src[^>]*(jpg|jpeg|gif|png)/mi',$content, $jpg);
		if ( $isSrc ) {
			$src = eregi_replace('src=[\'"]','',array_shift($jpg));
			$rv = addSlashes($src);
		}
		return $rv;
	}
	static function getSrc( $content ) {
		$isSrc = preg_match_all('/<\s*IMG\s*\S*src=\s*["¦\'](.*?)\s*["¦\']/i', $content, $images); 
		if ( $isSrc ) {
			return $images[1];
		}
		return array();
	}
	static function absolutizeHost( $content, $host = '' ) {
		if ( empty( $host ) ) {
			$host = 'http://'.$_SERVER['HTTP_HOST'];
		}
		$rv = str_replace('../../', $host.'/', $content);
		$rv = preg_replace('/([background|src|href])=(["\'])\//i', "$1=$2$host/", $rv);
		$rv = preg_replace('/url\((["\']*)\//i', "url($1$host/", $rv);
		return $rv;
	}
	static function simpleValidateEmail($email) {
		if(!preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email))
			return false;
		else return true;
	}
	static function validateEmail($email) {
		if(!preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email)) {
			return false;
		}
		//by Femi Hasani [www.vision.to]
		list($prefix, $domain) = split("@",$email);

		if( function_exists("getmxrr") && getmxrr($domain, $mxhosts) ) {
			return true;
		} elseif (@fsockopen($domain, 25, $errno, $errstr, 5)) {
			return true;
		} else {
			return false;
		}
	}
}
