<?
class MadPageNavi extends MadView {
	private $list = null;

	function __construct( $list, $pages = 10 ) {
		parent::__construct( PX_ROOT . 'views/pageNavi.html' );
		$this->list = $list;
		$this->pages = $pages;
	}
	function __toString() {
		$list = $this->list;

		$this->total = $list->getSearchTotal();
		if ( $this->total == 0 ) {
			return '';
		}
		$this->rows = $list->getQuery()->limit;
		if ( ! $page = MadParam::create('get')->page ) {
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

		$this->queryString = MadParam::except( 'page' );

		return parent::__toString();
	}
}
