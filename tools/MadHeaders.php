<?
class MadHeaders {
	public static function charset( $charset = 'UTF-8' ) {
		mb_internal_encoding($charset);
		header("Content-type: text/html;charset=$charset");
	}
	public static function xml( $charset = 'UTF-8' ) {
		header("Content-type: text/xml;charset=$charset");
	}
	public static function utf8() {
		self::charset( 'UTF-8' );
	}
	public static function revalidate() {
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	}
	public static function download( $fileName, $type='zip' ) {
    	Header("Content-type: file/unknown");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Type: application/$type");
		header("Content-Transfer-Encoding: binary");
	}
	public static function excelDownload( $fileName ) {
		header("Cache-Control: public");
		header( "Content-Description: File Transer" );
		header( "Content-Disposition: attachment; filename=$fileName" ); 
		header( "Content-Type: application/vnd.ms-excel" ); 
		header("Content-Transfer-Encoding: binary");
	}
}
