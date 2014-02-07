<?
class AdminUserLog extends MadModel {
	static function log( $user ) {
		$targets = array(
			'id' => 'relid',
			'userid' => 'userid',
			'level' => 'level',
		);
		$data = new MadData;
		foreach( $user as $key => $value ) {
			if ( isset( $targets[$key] ) ) {
				$target = $targets[$key];
				$data->$target = $value;
			}
		}

		$model = new self;
		$model->setData( $data );
		return $model->insert();
	}
	static function logout() {
		$db = MadDb::create();
		$log = LogUser::getInstance();
		$id = $db->max( 'admin_user_log', 'id', "relid=$log->id" );
		$query = "update admin_user_log set logout_time = now() where id=$id";
		return $db->exec( $query );
	}
}
