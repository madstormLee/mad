<?
class MadIndex extends MadData {
	private $model = null;
	private $query = null;
	private $params = null;
	public $page = 1;
	public $pages = 1;
	public $searchTotal = 0;
	public $pageNavi = '';

	function __construct( MadModel $model=null ) {
		if ( ! empty( $model ) ) {
			$this->query = new MadQuery( $model->getName() );
			$this->setModel( $model );
		}
	}
	function init() {
		$get = MadRouter::getInstance()->params;
		if ( $get->page ) {
			$this->query->limit( 10, $get->page );
		}
		$this->searchTotal = $this->query->searchTotal();
		$this->pageNavi = '';
		return $this;
	}
	function setParams( $params ) {
		$this->params = $params;
		return $this;
	}
	function getQuery() {
		$this->init();
		return $this->query;
	}
	function setModel( $model ) {
		$this->model = $model;
		return $this;
	}
	function getIterator() {
		return $this->getQuery();
	}
	function getPageNavi() {
		if ( empty( $this->pageNavi ) ) {
			$this->pageNavi = new MadPageNavi( $this->query );
		}
		return $this->pageNavi;
	}
}
