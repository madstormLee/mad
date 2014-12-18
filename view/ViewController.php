<?
class ViewController extends MadController {
	function viewAction() {
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
	function manualAction() {
		$get = $this->get;

		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');

		$this->right->setView( 'views/FileManual/viewRight.html' );
		$this->right->list = $model->getTree();

		$model = new FileManual( $get->file );

		$this->main->model = $model;
	}
	function gettextAction() {
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
	function __call( $method, $args ) {
		return $this->viewAction();
	}
}
