<?
class AdminUserLogList extends MadListModel {
	function init() {
		parent::init();
		$adminUser = new AdminUser;
		foreach( $this->data as $row ) {
			$row->levelName = $adminUser->getLevelName( $row->level );
		}
	}
}
