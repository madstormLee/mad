<?
class AdminUserList extends MadListModel {
	public function init() {
		if ( ! $this->data->isEmpty() ) {
			return $this;
		}
		parent:: init();

		$model = new AdminUser;
		foreach( $this->data as $row ) {
			$row->levelName = $model->getLevelName( $row->level );
			$row->requestName = $model->getLevelName( $row->request );
		}
		return $this;
	}
}
