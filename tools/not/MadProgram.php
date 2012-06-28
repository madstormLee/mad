<?
class MadProgram {
	protected $tail;
	protected $table;
	protected $program;
	protected $baseMode = 'lst';
	protected $js;
	protected $css;
	protected $mode;
	private static $auto_install = true;

	function __construct( $tail ) {
		$this->tail = $tail;
		$this->program = get_class($this);
		$this->table = $this->program.'_'.$tail;
		$this->views = MADVIEWS.'/'.$this->program.'/';

		$this->acting();
		$this->setAssets();
		$this->js = JsManager::getInstance();
		$this->style = CssManager::getInstance();
	}
	function __toString(){
		$mode = $this->mode;
		$this->$mode();
		return '';
	}
	function __call($method, $parameters){
		if ( $this->mode != $this->baseMode ){
			$mode = $this->baseMode;
			$this->$mode();
		}
		else return $this->program . " has NOT \"$method\" method.";
	}
	function setMode($mode) {
		$this->mode = $mode;
	}
	protected function acting() {
		if ( self::$auto_install == true && ! is_table($this->table) ) {
			$installer = new MadInstaller();
			$installer->install($this->table);
		}
		if ( isset($_POST[$this->program]) )
			$this->posting();
		else if ( isset($_GET[$this->program]) )
			$this->mode = $_GET[$this->program];
		else
			$this->mode = $this->baseMode;
	}
	function setAssets() {
		$this->href['write'] = "?$this->program=write";
	}
	function posting() {
		$modelName = $this->program . '_Model';
		$modelFile =  MADMODELS . '/' . $modelName . '.php';
		if ( ! is_file( $modelFile ) ) {
			print $modelFile . ' 이 존재하지 않습니다.';
			die;
		}
		include $modelFile;
		$this->model = new $modelName($this->table);

		$mode = $_POST[$this->program];
		$this->model->$mode();
		replace("?$this->program=$this->baseMode");
	}
	function lst(){
		$q = new Q("select * from $this->table");
		print $q;
		print "<a href='$this->program=write'>write</a>";
	}
	function view(){
		$no = $_GET['no'];
		$q = new Q("select * from $this->table where no=$no");
		$row = $q->row();
		if ( $q->rows() > 0 ) {
			extract($row);
		}
		include $this->views . 'view.html';
	}
	function write(){
		include $this->views . 'write.html';
	}
	function rewrite(){
		include $this->views . 'rewrite.html';
	}
	function pageNavi($row_per_page){
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
		$layout = new Layout('page_navi',MAD);

		$total = Q::total($this->table);
		if ($total == 0) return '';

		$last_page = ceil($total / $row_per_page);
		$prev_page = $current_page - 1;
		$next_page = $current_page + 1;

		$arr[] = ( $current_page == 1 ) ? '&lt' : "<a href='?page=$prev_page'>&lt;</a>";
		for ( $page = 1; $page <= $last_page; $page++ ) {
			$arr[] = ( $page == $current_page ) ? "<b>$page</b>" : "<a href='?page=$page'>$page</a>";
		}
		$arr[] = ( $current_page == $last_page ) ? '&gt;' : "<a href='?page=$next_page'>&gt;</a>";

		$layout->page = $arr;

		return $layout;
	}
}
