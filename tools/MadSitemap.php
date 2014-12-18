<?
class MadSitemap extends MadJson {
	private $index = array();

	public function __construct() {
		parent::__construct('sitemap.json');
		$this->init( $this );
	}
	public function findPath( $path ) {
		$args = explode( '/', $path );
		$rv = $this->data;
		foreach( $args as $arg ) {
			if ( $rv->$args ) {
				$rv = $rv->args;
			}
		}
		return $rv;
	}
	private function init( $data, $parentId = '' ) {
		foreach( $data as $key => &$row ) {
			if( ! empty( $parentId ) ) {
				$row->id = $parentId . '/' . $key;
			} else {
				$row->id = $key;
			}
			$this->index[$row->id] = $row;
			$row->parentId = $parentId;
			$row->href = '~/' . $row->id;
			if ( ! $row->queries->isEmpty() ) {
				$row->href .= '?' . $row->queries;
			}
			if ( $row->subs ) {
				$this->init( $row->subs, $key );
			}
		}
	}
}
