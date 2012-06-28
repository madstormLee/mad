<?
class MadComment {
	private $className;
	private $viewsDir;
	private $table;
	private $responder;

	function __construct($table){
		$this->madlog = MadLog::getInstance();
		$style = CssManager::getInstance();
		$style->set('/mad/css/MadComment/base');
		$js = JsManager::getInstance();
		$js->set('/mad/js/MadComment/base');
		$this->className = __class__;
		$this->viewsDir = MADVIEWS . __class__ . '/';
		$this->table = $this->className . '_' . $table;
		$this->responder = '/mad/ajax/comment';
		if ( isset ( $_POST[$this->className] ) ) {
			$action = $_POST[$this->className].'Action';
			$this->$action();
		}
	}
	function setResponder($responder) {
		$this->responder = $responder;
	}
	function setViewsDir($viewsDir) {
		$this->viewsDir = $viewsDir;
	}
	function inside(){
		$no = $_GET['no'];
		$this->layout = new Layout('inside',$this->viewsDir);
		$this->layout->className = $this->className;
		$q = new Q("select * from $this->table where relNo=$no order by wDate desc");
		$this->layout->madArr = $q->toArray();
		$this->layout->responder = $this->responder;
	}
	function rewrite(){
		include $this->views.'/rewrite.html';
	}
	private function insAction(){
		$set = new MadSet($_POST);
		$set->remove($this->className);
		$set->decode();
		$set->add('wDate','now()');
		$query = "insert into $this->table $set";
		$q = new Q($query);
		print mysql_insert_id();
	}
	private function upAction(){
		$query = "insert into $this->table $set where no=$relNo";
	}
	private function delAction(){
		$no = $_POST['no'];
		$query = "delete from $this->table where no=$no limit 1";
		$q = new Q($query);
		print $q->getResult();
	}
	function __toString() {
		$this->inside();
		print $this->layout;
		return '';
	}
}
