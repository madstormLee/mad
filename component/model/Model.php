<?
class Model extends MadModel {
	protected $file='';
	protected $data;

	function fetch($file='') {
		$this->data = file_get_contents( $file );
	}
	function fetch( $file = '' ) {
		if ( empty( $file ) ) {
			return false;
		}
		if ( ! is_file( $file ) ) {
			throw new Exception(sprintf( 'no file : %s', $file) );
		}
		$this->file = $file;
		$json = new MadJson( $file );
		$this->data = $json->getData();
		return $this;
	}
	function getIndex() {
		$rv = new MadData;

		$data = MadDir::globR('model.json');
		$data = array_merge( $data, MadDir::globR('mad/*/model.json') );

		foreach( $data as $file ) {
			$table = $this->getTableName( $file );
			$model = new MadModel;
			$model->setSetting( $file );
			$install = $this->isInstall( $table );
			$rv->add( new MadData(array(
				'install' => $install,
				'table' =>	$table,
				'file' =>	$file,
				'model' =>	$model,
				'columns' =>	$this->getColumns( $table ),
			)));
		}
		return $rv;
	}
	function isInstall( $table ) {
		$query = new MadQuery($table);
		return $query->isTable();
	}
	function install() {
		$model = new MadModel;
		$model->setName( $this->getTableName( $this->file ) );
		$model->setSetting( $this->file );
		$scheme = new MadScheme( $model );
		return $this->getDb()->exec( $scheme );
	}
	function uninstall() {
		$table = $this->getTableName();
		$query = "drop table `$table`";
		return $this->getDb()->exec( $query );
	}
	function getTableName( $file = '' ) {
		if ( empty( $file ) ) {
			$file = $this->file;
		}
		return ucFirst(basename( dirname($file) ));
	}
	function getColumns( $table  ) {
		if ( ! $this->isInstall( $table ) ) {
			return new MadData;
		}
		$query = "PRAGMA table_info(`$table`)";
		$columns = $this->getDb()->query($query)->fetchAll(PDO::FETCH_CLASS);
		return new MadData( $columns );
	}
	function getDefaultFields() {
		return new MadJson('component/model/defaultFields.json');
	}
	function getExtends() {
		$cnt = preg_match('/(?<=extends )[A-ZA-z0-9_]+/', $this->data, $matches );
		if ( $cnt > 0 ) {
			return array_pop( $matches );
		}
		return '';
	}
	function getName() {
		$cnt = preg_match('/(?<=class )[A-ZA-z0-9_]+/', $this->data, $matches );
		if ( $cnt > 0 ) {
			return array_pop( $matches );
		}
		return '';
	}
	function getMethods() {
		$cnt = preg_match_all('/(?<=function )\s*[A-ZA-z0-9_]+/', $this->data, $matches );

		if ( $cnt > 0 ) {
			return new MadData( current($matches) );
		}
		return array();
	}
}
