<?=$phpOpen?>
class <?=$name?>Controller extends MadController {
	function indexAction() {
	}
	function writeAction() {
		$this->model->fetch( $this->params->id );
	}
	function saveAction() {
		return $this->model->setData( $this->params )->save();
	}
	function deleteAction() {
		return $this->model->delete( $this->params->id );
	}
}
