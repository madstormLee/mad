<?
// this is now based json. but will be db table base.
class ItemcategoryController extends MadController {
	function indexAction() {
		$this->main->category = ItemcategoryList::createTree( 1 );
	}
	function writeAction() {
		$get = $this->get;
		$model = new Itemcategory;
		if( ! $model->parentid = $get->parentid ) {
			$model->parentid = 0;
		}
		$model->treeid = $this->log->getId();
		$model->isOpen = true;
		$model->orderNumber = $model->getNextOrder();
		$model->insert();

		$this->main->row = $model;
		return $this->main;
	}
	function propertiesAction() {
	}
	// this need refactorying. use transaction !.
	function mergeAction() {
		$get = $this->get;
		$post = $this->post;

		if ( $this->db->total( 'itemcategory', "parentid = $get->id" ) > 0 ) {
			throw new Exception('Target has sub category!.');
		}

		$db = MadDb::create();
		$query = "update item set categoryid=$post->destination where categoryid=$get->id";
		$db->exec( $query );
		$query = "delete from itemcategory where id=$get->id";
		;
		if ( $db->exec( $query ) > 0 ) {
			return true;
		}
		return false;
	}
	function updateOrderFromJsonAction() {
		$data = json_decode( $this->post->json, 1 );
		$result = 0;
		foreach( $data as $id => $ordernumber ) {
			$q = MadDb::create()->query("update itemcategory set ordernumber=$ordernumber where id=$id");
			$result += $q->rows();
		}
		return $result;
	}
	function saveAction() {
		$model = new Itemcategory;
		return $model->setData($this->post)->save();
	}
	function deleteAction() {
		if ( $this->db->total( 'itemcategory', "parentid = $get->id" ) > 0 ) {
			throw new Exception('Target has sub category!.');
		}
		$model = new Itemcategory;
		return $model->delete( $this->get->id );
	}
}
