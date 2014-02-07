<?
class MadListView extends MadView {
	function __construct( MadListModel $list ) {
		parent::__construct( PX_ROOT . 'views/ListView/index.html' );
		$this->list = $list;
	}
}
