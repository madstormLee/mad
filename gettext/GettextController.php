<?
class GettextController extends MadController {
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
}
