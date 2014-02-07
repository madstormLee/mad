<?
class ListView extends MadView {
	function __construct( $list ) {
		parent::__construct( 'views/list.html' );
		$this->list = $list;
	}
}
