<?
class MadTreeView {
	protected $data;
	function __construct( $data = '' ) {
		if ( ! emtpy( $data ) ) {
			$this->setData( $data );
		}
	}
}
