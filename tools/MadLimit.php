<?
class MadLimit {
	private $rows;
	private $pages;
	private $total;
	private $view;
	private $noLimit = false;

	function __construct( $total = 0, $rows = 14, $pages = 10 ) {
		$this->total = $total;
		$this->rows = $rows;
		$this->pages = $pages;
		if ( ! $this->page = ckGet('page') ) {
			$this->page = 1;
		}
		$this->view = 'mad/views/MadPageNavi.html';
	}
	function noLimit() {
		$this->noLimit = true;
	}
	function getLastPage() {
		return ceil($this->total / $this->rows);
	}
	function setRows( $rows ) {
		$this->rows = $rows;
		return $this;
	}
	function setTotal( $total ) {
		$this->total = $total;
		return $this;
	}
	function setView($view){
		$this->view = $view;
	}
	function __toString() {
		if ( $this->noLimit == true ) {
			return '';
		}
		$start = ($this->page-1) * $this->rows;
		$rv = "limit $start, $this->rows";
		return $rv;
	}
	function getPageNavi() {
		if ( $this->total < 1 ) {
			return '';
		}
		$lastPage = $this->getLastPage();
		if ( $this->page > $lastPage ) {
			$this->page = $lastPage;
		}
		$endPage = ceil( $this->page / $this->pages ) * $this->pages;
		$startPage = $endPage - $this->pages + 1;
		if($endPage > $lastPage) {
			$endPage = $lastPage;
		}
		$pageUnits = range( $startPage, $endPage );

		$queries = explode('&', $_SERVER['QUERY_STRING']);
		foreach( $queries as $key => $query ) {
			if ( 0 === strpos( $query, 'page=') ) {
				unset( $queries[$key] );
			}
		}
		$queryString = implode('&amp;', $queries);

		$prevPage = '';
		if($this->page > $this->pages ) {
			$prevPage = $startPage - 1;
		}
		$nextPage = '';
		$nextFirstPage = $this->page * $this->rows;
		if( $endPage < $lastPage ) {
			$nextPage = $startPage + $this->pages;
		}
		include ROOT . $this->view;
		return '';
	}
	function test() {
		print $this->rows;
		print BR;
		print $this->pages;
		print BR;
		print $this->total;
		print BR;
		print $this->view;
		print BR;
	}
}
