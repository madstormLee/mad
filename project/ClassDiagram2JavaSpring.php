<?
class ClassDiagram2JavaSpring implements IteratorAggregate {
	private $ext = '.java';
	// 현재 a2m만을 위한 preset이다.
	private $presets = array(
			"listController" => "Project/template/javaSpring/controllers/list.java",
			"iudController" => "Project/template/javaSpring/controllers/write.java",
			"viewController" => "Project/template/javaSpring/controllers/view.java",
			"interface" => "Project/template/javaSpring/models/interface.java",
			"model" => "Project/template/javaSpring/models/implementation.java",
			);
	private $data;
	private $views;

	function __construct( ClassDiagram $classDiagram = null ) {
		$this->data = new MadData;
		$this->views = new MadData;
	}
	function setViews() {
		$suffix = new MadData( array(
			"listController" => "00L",
			"iudController" => "00U",
			"viewController" => "00V",
		));
		foreach( $this->classDiagram->packages as $package ) {
			foreach( $package->classes as $classId => $class ) {
				$viewFile = $this->presets[$classId];
				$view = new MadView( $viewFile );

				$this->package = $package;
				$this->class = $class;
				$view->setData( $this->data->get() );

				$target = str_replace( '.', '/', $package->name ) . '/' . $class->name . $suffix->$classId . $this->ext;
				$this->views->$target = $view;
			}
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
