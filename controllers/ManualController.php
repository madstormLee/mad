<?
class ManualController extends MadController {
	function indexAction() {
		$list = new MadJson("json/Manual/mad/index");
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		$data = new MadJson("json/Manual/mad/" . $this->get->path);
		$this->main->data = $data;
		return $this->main;
	}
	function writeAction() {
		$this->js->add('/nomad/ckeditor/ckeditor');
		$form = new MadForm( new MadJson('json/Manual/forms/write') );
		$data = new MadJson("json/Manual/mad/" . $this->get->path);
		if ( ! $data->path ) {
			$data->path = $this->get->path;
		}
		$form->setData( $data );
		$this->main->form = $form;
		return $this->main;
	}
	function saveAction() {
		$post = $this->post;
		$now = date('Y-m-d h:i:s');

		$index = new MadJson("json/Manual/mad/index");
		$position = array_filter( explode( '/', $post->path ) );
		$current = $index;
		foreach( $position as $unit ) {
			if ( $current->sub ) {
				$current = $current->sub;
			}
			$current = $current->$unit;
		}
		$current->title = $post->title;
		$index->save();

		$data = new MadJson("json/Manual/mad/" . $post->path);
		$data->addData( $post );
		if ( ! $data->wDate ) {
			$data->wDate = $now;
		}
		$data->uDate = $now;
		$data->save();

		$this->js->replaceBack();
	}
	function deleteAction() {
	}
}
