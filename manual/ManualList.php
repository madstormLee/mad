<?
class ManualList extends MadJson {
	protected $dir = 'views/Manual/data/';
	protected $domain = 'Manual';
	protected $file = 'json/components/Manual/data.json';
	protected $extension = 'html';

	function getDir() {
		if ( $this->domain ) {
			return "views/$this->domain/data/";
		}
		return "views/Manual/data/";
	}
	function rescan() {
		$dir = $this->getDir();
		$list = scandir( $dir );
		foreach( $list as $file ) {
			$path = $dir . $file;
			if ( is_dir( $path ) ) {
				continue;
			}
			$chunk = explode('.', $file);
			if ( end( $chunk ) != $this->extension ) {
				continue;
			}
			$ctime = filectime($path);
			$name = implode( '.', array_slice( $chunk, 0, -1 ) );

			if ( $this->$name && $this->$name->ctime == $ctime ) {
				continue;
			}

			$title = '';
			$contents = file($path);
			foreach( $contents as &$row ) {
				$row = new MadString( $row );
				$row = $row->trim();
				if ( empty( $title ) && ! $row->isEmpty() ) {
					$title = $row->stripTags()->cut( 20, '...' );
				}
			}
			$brief = ( new MadString( implode( $contents ) ))->stripTags()->cut( 100 );

			$this->data[$name] = new MadData( array(
				'title' => $title,
				'file' => $path,
				'brief' => $brief,
				'ctime' => $ctime,
			) );
		}
		$this->save();
	}
}
