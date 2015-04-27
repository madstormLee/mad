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
			$this->query = new MadQuery( get_class($model) );
			$this->setModel( $model );
		}
	}
	function init() {
		$this->searchTotal = $this->query->searchTotal();
		$this->pageNavi = '';
		return $this;
	}
	function setParams( $params ) {
		$this->params = $params;
		return $this;
	}
	function getQuery() {
		return $this->query;
	}
	function setModel( $model ) {
		$this->model = $model;
		return $this;
	}
	function getIterator() {
		return $this->query;
	}
}

