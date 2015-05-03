<?
class MadHeaders {
	public static function p3p() {
		header ('P3P : CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
	}
	public static function charset( $charset = 'UTF-8' ) {
		mb_internal_encoding($charset);
		header("Content-type: text/html;charset=$charset");
	}
	public static function utf8() {
		self::charset( 'UTF-8' );
	}
	public static function xml( $charset = 'UTF-8' ) {
		header("Content-type: text/xml;charset=$charset");
	}
	public static function revalidate() {
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	}
	public static function download( $fileName, $type='zip' ) {
		if ( $type == 'excel' ) {
			$type = 'vnd.ms-excel';
		}
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Type: application/$type");
		header("Content-Transfer-Encoding: binary");
	}
	public static function replace( $location ) {
		$location = MadRouter::getInstance()->url( $location );
		header("Location: $location");
		die;
	}
	public static function move( $location ) {
		if ( 0 !== strpos( $location, 'http' ) ) {
			$location = 'http://' . $_SERVER['HTTP_HOST'] . MadRegex::parseUrl( $location );
		}
		header("Location: $location");
		die;
	}
}
