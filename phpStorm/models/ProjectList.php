<?
// project를 위치와 상관없이 끌어오기로 관리하자.
class ProjectList extends MadData {
	function __construct( $file = 'ini/Project/list' ) {
		$data = array();
		$ini = new MadIni( $file );
		foreach( $ini as $key => $file ) {
			if ( strpos( $file, '/' ) === 0 ) {
				$file = realPath( ROOT . $file );
			}
			if ( is_file( $file ) ) {
				$data[$key] = new MadIni( $file );
			}
		}
		parent::__construct( $data );
	}
}
