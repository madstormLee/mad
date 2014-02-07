<?
// this is facade. and some utilities for list page.
// use query, db, pagenavi ... and some adjusting names

class MadListModel implements IteratorAggregate {
	protected $initFlag = false;
	protected $data = null;

	protected $dbName = '';
	protected $table = '';
	protected $model = null;
	protected $config = null;

	protected $db = null;
	protected $query = null;

	protected $total = false;
	protected $searchTotal = false;
	protected $pageNavi = null;

	protected $interprets = null;

	function __construct( MadData $setting = null ) {
		$this->data = new MadData;
		// table name removes 'List' from class name conventionally.
		$className = substr( get_class( $this ) , 0, -4 );
		if ( empty( $this->table ) ) {
			$this->table = MadString::create( $className )->underscore();
		}

		$this->query = new MadQuery( $this->table );
		$this->db = MadDb::create();
		if ( ! empty( $this->dbName ) ) {
			$this->db->setDatabase( $this->dbName );
		}

		$this->pageNavi = new MadPageNavi( $this );
		$this->config = new MadJson( MadGlobals::getInstance()->dirs->configs . $className . '/list.json' );

		// convention. if no setting file.
		if ( ! ( $this->config->isFile() && $this->config->settings ) ) {
			$this->config->settings = array(
				"rows" => 20,
			);
			$this->config->rows = range( 10, 50, 10 );
		}

		$this->applySetting();
	}
	function setConnectInfo( $db ) {
		$this->db->setConnectInfo( $db );
		return $this;
	}
	function setDatabase( $dbName ) {
		$this->db->setDatabase( $dbName );
		return $this;
	}
	function setData( $data ) {
		$this->data->setData( $data );
		return $this;
	}
	// this can be override.
	public function init() {
		if ( $this->initFlag === true || ! $this->data->isEmpty() ) {
			$this->initFlag = true;
			return $this;
		}
		$this->initFlag = true;

		$this->data = $this->db->query( $this->query )->getData();
		return $this;
	}
	function curry( $listName, $column, $searchKey = 'id' ) {
		if ( ! class_exists( $listName ) ) {
			throw new Exception("no $listName class");
		}
		$this->init();
		$list = new $listName;
		$name = $list->getTable();

		$ids = $this->getData()->dic( $column )->filter()->implode(',');
		if ( empty( $ids ) ) {
			return false;
		}
		$list->where( "$searchKey in ( $ids )" )->limit();
		$listdata = $list->getData()->index( $searchKey );

		foreach( $this->data as &$row ) {
			if ( $target = $row->$column ) {;
				$row->$name = $list->$target;
			} else {
				$row->$name = array();
			}
		}

		return $this;
	}
	public function getHeaders() {
		$this->init();
		if ( $this->data[0] ) {
			return $this->data[0]->getKeys();
		}
		return $this->db->explain( $this->table )->dic('column_name');
	}
	function isField( $field ) {
		if ( ! $this->model->isConfig() ) {
			return false;
		}
		return ! ! $this->config->$field;
	}
	protected function applySetting() {
		$settings = $this->config->settings;

		if ( ! empty( $settings->order) ) {
			if ( ! $this->config->orderables   ) {
				$this->query->order( $settings->order );
			} elseif ( $this->config->orderables->in( $settings->order ) ) {
				$this->query->order( $settings->order );
			}
		}

		if ( ! empty( $settings->rows ) ) {
			if ( ! $this->config->rows  ) {
				$this->query->limit( $settings->rows );
			} elseif ( $this->config->rows->in( $settings->rows ) ) {
				$this->query->limit( $settings->rows );
			}
		}

		/*********************** searches ********************/
		if ( $this->config->searchables ) {
			foreach( $this->config->searchables as $field => $method ) {
				if ( ! empty( $settings->$field ) ) {
					$this->$method( $field, $settings->$field );
				}
			}
		}
	}
	function getTable() {
		return $this->table;
	}
	function setTable( $table ) {
		$this->table = $table;
		$this->query->setFrom( $table );
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
			$this->searchTotal = $this->db->total( $this->query->from, $this->query->where );
		}
		return $this;
	}
	function getTotal() {
		return $this->setTotal()->total;
	}
	function setTotal() {
		if ( $this->total === false ) {
			$this->total = $this->db->total( $this->table );
		}
		return $this;
	}
	function setRows( $limit ) {
		$this->query->limit( $limit );
		return $this;
	}
	function getRows() {
		return $this->query->getRows();
	}
	function setPages( $pages = 10 ) {
		$this->pageNavi->pages = $pages;
	}
	/********************** config access ***********************/
	function getConfig( $target = '' ) {
		if ( ! empty( $target ) ) {
			return $this->config->$target;
		}
		return $this->config;
	}
	protected function addSetting( $data ) {
		if( ! $settings = $this->config->settings ) {
			$settings = $this->config->settings = array();
		}
		foreach( $data as $key => $value ) {
			$settings->$key = $value;
		}
		return $this;
	}
	function getSetting( $target = '' ) {
		if ( ! empty( $target ) ) {
			return $this->config->settings->$target;
		}
		return $this->config->settings;
	}
	function getFieldData( $field ) {
		return $this->model->getConfig($field)->data;
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
	function interpret( $target ) {
		if ( ! $data = $this->interprets->$target ) {
			return $this;
		}
		foreach( $this->data as $row ) {
			$name = $target . 'Name';
			$row->$name = $data->{$row->$target};
		}
		return $this;
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
		if ( ! $page = MadParam::create('get')->page ) {
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
	function getOrderParam( $order ) {
		if ( ! $this->config->orderables ) {
			return '';
		}
		if ( $this->config->orderables->in( $order ) ) {
			return MadParam::replace("order=$order");
		}
		return '';
	}
	/*********************** search tools ************************/
	function autoSearch( MadData $searches ) {
		return false;
		$searches->filter(); // this not work with 0.
		$query = $this->query;
		$this->searchables = new MadJson();
		foreach( $searches as $key => $value ) {
			if ( ! $search = $this->searchables->$key ) {
				continue;
			}
			if ( ! $search = $search->search ) {
				$search = "{key}='{value}'";
			}

			$temp = array(
					'{key}' => $key,
					'{value}' => $value,
					);
			$keys = array_keys( $temp );
			$values = array_values( $temp );

			$query->where( $key . str_replace( $keys, $values, $search ) );
		}
	}
	function search( $field, $values ) {
		if ( ! $this->isField( $field ) ) {
			throw new Exception('Search field not exists!');
		}
		$type = $this->model->getConfig()->$field->type;

		if ( $type == 'date' ) {
			$this->searchDate( $field, $values );
		} elseif ( in_array( $type, array( 'radio', 'checkbox', 'select' ) ) ) {
			$this->searchIn( $field, $values );
		} else {
			$this->searchText( $field, $values );
		}
		return $this;
	}
	function searchText( $field, $value ) {
		if ( ! $this->isField( $field ) ) {
			throw new Exception('Search field not exists!');
		}
		$this->query->where( "$field like '$value%'" );
		return $this;
	}
	function searchFulltext( $field, $value ) {
		$this->query->where( "$field like '%$value%'" );
		return $this;
	}
	function searchIn( $field, $values = '' ) {
		if ( empty( $values ) ) {
			return $this;
		}
		if ( ! $values instanceof MadData ) {
			if ( ! is_array( $values ) ) {
				$values = array( $values );
			}
			$values = new MadData( $values );
		}
		$data = filter_var_array( $values->getData(), FILTER_SANITIZE_STRING );
		$values = implode( "','", $values->getData() );
		$this->query->where( "$field in ($values)" );
		return $this;
	}
	function searchInNumeric( $field, MadData $values) {
		$values = filter_var_array( $values->getData(), FILTER_SANITIZE_NUMBER_INT );
		$values = implode( ',', $values );
		$this->query->where( "$field in ($values)" );
		return $this;
	}
	function test() {
		$this->init();
		(new MadDebug)->printR( $this->data );
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __call( $method, $args ) {
		if ( ! method_exists( $this->query, $method ) ) {
			throw new Exception( get_class($this) . " has not $method method." );
			// actually this is need ReflextionClass.
		}
		return call_user_func_array( array( $this->query, $method ), $args );
	}
}
