<?
class Svn {
	private $lastCommand = '';

	function __construct() {
	}
	function command( $command ) {
		$this->lastCommand = $command;
		$rv = trim( `$command` );
		return explode( "\n", $rv );
	}
	function getLastCommand() {
		return $this->lastCommand;
	}
	function delegate( $command ) {
		$this->lastCommand = $command;
		return file_put_contents( "data/Svn/delegate.command", $command, FILE_APPEND );
	}
	function add( $files ) {
		if ( ! $files instanceof MadData ) {
			$files = new MadData(array( $files ) );
		}
		$target = $files->implode(' ');
		return $this->delegate( "svn add $target" );
	}
	function update() {
		return $this->command( `svn up` );
	}
	function info() {
		return $this->command( `svn info` );
	}
	function status() {
		$rv = new MadData;
		$result = trim( `svn status` );
		$lines = explode( "\n", $result );
		foreach( $lines as $line ) {
			for( $i=0; $i < 8; ++$i ) {
				$row[$i] = $line[$i];
			}
			$row['file'] = substr( $line, 8 );
			$rv->add( $row );
		}
		return $rv;
	}
}
