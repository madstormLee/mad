<?
// this is facade. and some utilities for list page.
// use query, db, pagenavi ... and some adjusting names
// todo: refactoring with no database and queries.
class MadList extends MadData {
	protected $initFlag = false;
	protected $data = array();

	protected $model = null;

	protected $query = null;

	protected $total = false;
	protected $searchTotal = false;
	protected $pageNavi = null;

	function __construct( MadDbModel $model ) {
		$this->model = $model;
		$this->query = new MadQuery( $model->getTable() );

		$this->pageNavi = new MadPageNavi( $this );
	}
	// this can be override.
	public function init() {
		if ( $this->initFlag === true || ! empty( $this->data ) ) {
			$this->initFlag = true;
			return $this;
		}
		$this->initFlag = true;
		$this->setSearchTotal();

		$this->data = $this->query->query();
		return $this;
	}
	function getQuery() {
		return $this->query;
	}
	function setQuery( MadQuery $query ) {
		$this->query = $query;
		return $this;
	}
	function getSearchTotal() {
		return $this->setSearchTotal()->searchTotal;
	}
	function setSearchTotal() {
		if ( $this->searchTotal === false ) {
			$this->searchTotal = $this->query->searchTotal();
		}
		return $this;
	}
	function getTotal() {
		return $this->setTotal()->total;
	}
	function setTotal() {
		if ( $this->total === false ) {
			$this->total = $this->query->total();
		}
		return $this;
	}
	function setRows( $limit ) {
		$this->query->limit( $limit );
		return $this;
	}
	function getRows() {
		return $this->query->limit();
	}
	function setPages( $pages = 10 ) {
		$this->pageNavi->pages = $pages;
	}
	/*********************** utility methods **********************/
	function isEmpty() {
		return ! $this->getSearchTotal();
	}
	function getData() {
		$this->init();
		return $this->data;
	}
	function getIterator() {
		$this->init();
		return $this->data;
	}
	function getPageNavi() {
		return $this->pageNavi;
	}
	function getMoreNavi( $href = './list', $param = '' ) {
		$view = new MadView('views/moreNavi.html');
		$view->rows = $this->query->limit;
		if ( $view->rows == 0 ) {
			return '';
		}
		$view->href = $href;
		$view->param = $param;
		$view->list = $this;
		if ( ! $page = MadParams::create('get')->page ) {
			$page = 1;
		}
		$view->page = $page;
		$view->nextPage = $view->page + 1;
		$view->total = $this->getSearchTotal();

		if(  $view->page * $view->rows > $view->total ) {
			return '';
		}
		return $view;
	}
	function __call( $method, $args ) {
		if ( ! method_exists( $this->query, $method ) ) {
			throw new Exception( get_class($this) . " has not $method method." );
			// actually this is need ReflextionClass.
		}
		return call_user_func_array( array( $this->query, $method ), $args );
	}
}

