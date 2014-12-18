<?
class Board extends MadModel {
	function save() {
		$userLog = MadUserLog::getInstance();
		if ( ! $userLog->isLogin() ) {
		}
		if ( $userLog->isAdmin() ) {
			$query = "delete from $this->table where no=$no limit 1";
		} else {
			$id = $this->userLog->getUserId();
			$query = "delete from $this->table where no=$no and id=$id limit 1";
		}
		$model->save();
		return $this->db->exec( $query );
	}
}
