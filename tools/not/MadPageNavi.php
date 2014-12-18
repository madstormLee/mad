<?
class MadPageNavi extends Mad {
	private $rowPerPage;
	private $maxPage;
	private $total;
	private $view;

	function __construct( Mad $list ) {
		parent::__construct();
	}
	function __toString() {
		return $this->class;
	}
}
