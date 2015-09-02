<?
class ViewController extends MadController {
	function indexAction() {
	}
	function indexViewAction() {
		$get = $this->params;
		if ( ! is_file( $get->id ) ) {
			throw new Exception('no model like ' . $get->id);
		}
		$this->view->index = new MadIndex( new $get->id );
	}
	function viewAction() {
		$file = $this->get->file;
		if ( ! is_file( $file ) ) {
			return new Exception('fileNotFound');
		}

		return file_get_contents( $file );

		$html = "file doesn't exists";
		$target = ROOT . $_SERVER['REQUEST_URI'];
		if ( is_file( $target ) ) {
			$escapes = array( 
				'<?' => '&lt;?',
				'?>' => '?&gt;',
				);
			$html = str_replace( array_keys( $escapes ), array_values( $escapes ),  file_get_contents( $target ) );
		}
		return $html;
	}
	function viewAction() {
	}
	function pageNaviAction() {
	}
	function gettextAction() {
		$get = $this->params;
		$view = new MadFile( $this->get->file );
		$contents = $view->getContents();
		$contents = str_replace( '<?', '{php', $contents );
		$contents = str_replace( '?>', 'php}', $contents );
		$contents = str_replace( '->', '.', $contents );

		$list = preg_match_all( "/<[^>]*>(.*?)<[^>]*>/", $contents, $matches );
		$list = array_filter( $matches[1] );

		$replaces = array();
		foreach( $list as $value ) {
			$replaces[$value] = '<gettext>' . $value . '</gettext>';
		}
		$contents = str_replace( array_keys( $replaces ), $replaces, $contents );
		// $contents = preg_replace( "/<([^>]*)>(.*?)<\/\1>/","<$1>{_('$2')}</$1>", $contents );

		$contents = nl2br( htmlSpecialChars( $contents ) );
		$contents = str_replace( "\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $contents );

		$this->main->list = $list;
		$this->main->view = $view;
		$this->main->contents = $contents;
	}
}
