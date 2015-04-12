<?
class InterfaceDiagram2View implements IteratorAggregate {
	// 현재 a2m만을 위한 preset이다.
	private $presets = array(
			"list" => "Project/template/javaSpring/views/list.jsp",
			"write" =>  "Project/template/javaSpring/views/write.jsp",
			"view" => "Project/template/javaSpring/views/view.jsp",
			);
	private $ext = '.jsp';

	private $data;
	private $views;

	function __construct() {
		$this->data = new MadData;
		$this->views = new MadData;
	}
	function setViews() {
		$this->views->setData();
		$name = new MadString($this->config->name);
		$viewNamePrefix = $name->lower()->camel();
		$viewNames = new MadData( array(
				"list" => $viewNamePrefix . "00_l",
				"write" =>  $viewNamePrefix . "00_u",
				"view" => $viewNamePrefix . "00_v",
				) );
		foreach( $this->interfaceDiagram->actions as $action => $info ) {
			$target = $viewNames->$action . $this->ext;
			$viewFile = $this->presets[$action];
			$view = new MadView( $viewFile );

			$view->setData( $this->data->get() );
			$view->info = $info;
			$view->formFactory = new MadFormFactory;
			$view->viewNames = $viewNames;

			$this->views->$target = $view;
		}
		return $this;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function getIterator() {
		return $this->views;
	}
	function test() {
		$this->data->test();
	}
}
