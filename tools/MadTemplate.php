<?
class MadTemplate extends Mad {
	protected $data;
	protected $file;
	protected $template = '';

	function __construct( $file = '' ) {
		parent::__construct();
		$this->data = new MadData;
		if ( empty( $file ) ) {
			$file = ucFirst($this->g->controllerName) . '/' . $this->g->actionName;
		}
		$this->setView( $file );
	}
	function setView( $file ) {
		$this->setFile( $file );
	}
	function setFile( $file ) {
		$this->file = $file;
		return $this;
	}
	function setData( $data = array() ) {
		$this->data->clear();
		$this->addData( $data );
		return $this;
	}
	function addData( $data = array() ) {
		$this->data->addData( $data );
		return $this;
	}
	function getView() {
		return $this->view;
	}
	function getViewPath() {
		$file = $this->file;
		// 확장자가 없을 경우 .html로 생각한다.
		if ( 1 === count( explode('.', basename($file) ) ) ) {
			$file .= '.html';
		}
		return $file;
	}
	function isTemplate() {
		return ! empty( $this->template );
	}
	function get( $key ) {
		return $this->data->$key;
	}
	function set( $key, $value ) {
		$this->data->$key = $value;
		return $this;
	}
	function getContent() {
		$rv = '';
		$template = $this->getTemplate();
		$data = $this->data->get();
		$keys = array_keys( $data );
		foreach( $keys as &$value ) {
			$value = '{' . $value . '}';
		}
		$values = array_values( $data );
		return str_replace( $keys, $values, $template );
	}
	private function getTemplate() {
		if ( $this->isTemplate() ) {
			return $this->template;
		}
		$viewPath = $this->getViewPath();
		if ( ! is_file( $viewPath ) ) {
			return $viewPath . BR;
		}
		return $this->template = file_get_contents( $viewPath );
	}
	function save() {
		return file_put_contents( $this->file, $this ) ? 1:0;
	}
	function saveAs( $file ) {
		$content = str_replace( "", '',$this );
		$dir = dirname( $file );
		if ( ! is_dir ( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		return file_put_contents( $file,  $content ) ? 1:0;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __toString() {
		return $this->getContent();
	}
	function test() {
		printR( $this->data );
	}
}
