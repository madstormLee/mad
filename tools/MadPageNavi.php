<?
class MadPageNavi extends MadView {
	private $list = null;
	private $pages = 10;

	function __construct( $list, $pages = 10 ) {
		parent::__construct( MAD . '/component/view/pageNavi.html' );
		$this->list = $list;
	}
	function __toString() {
		$list = $this->list;

		$this->total = $list->searchTotal();
		if ( $this->total == 0 ) {
			return '';
		}
		$this->rows = $list->getRows();
		if ( ! $page = MadParams::create('get')->page ) {
			$page = 1;
		}
		$this->currentPage = $page;

		$this->lastPage = ceil( $this->total / $this->rows );
		if ( $this->currentPage > $this->lastPage ) {
			$this->currentPage = $this->lastPage;
		}
		$this->endPage = ceil( $this->currentPage / $this->pages ) * $this->pages;
		$this->startPage = $this->endPage - $this->pages + 1;

		if($this->endPage > $this->lastPage) {
			$this->endPage = $this->lastPage;
		}
		$this->pageUnits = range( $this->startPage, $this->endPage );

		if( $this->currentPage > $this->pages ) {
			$this->prevPage = $this->startPage - 1;
		}
		$this->nextFirstPage = $this->currentPage * $this->rows;
		if( $this->endPage < $this->lastPage ) {
			$this->nextPage = $this->startPage + $this->pages;
		}

		$get = MadRouter::getInstance()->params;
		$this->queryString = $get->except( 'page' );

		return parent::__toString();
	}
}
