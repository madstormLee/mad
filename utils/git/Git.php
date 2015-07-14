<?
class Git {
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
		return $this->delegate( "git add $target" );
	}
	function update() {
		return $this->command( `git up` );
	}
	function info() {
		return $this->command( `git info` );
	}

	function getLines( $type='modified') {
		$files = new MadData;

		$modified = preg_grep( "/$type:/", $this->getStatus() );
		foreach( $modified as $line ) {
			$explodeLine = explode(':', $line);
			$line = trim( end($explodeLine) );
			$files->add( $line );
		}
		return $files;
	}
	private $dir = '';
	function setDir( $dir ) {
		$this->dir = $dir;
	}

	private $status = array();
	function setStatus() {
		if ( ! empty( $this->dir ) ) {
			$org = getcwd();
			chdir( $this->dir );
			$result = trim( `git status` );
			chdir( $org );
		} else {
			$result = trim( `git status` );
		}
		if ( empty( $result ) ) {
			return false;
		}
		$this->status = explode( "\n", $result );
		return $this;
	}
	function getStatus() {
		if ( empty( $this->status ) ) {
			$this->setStatus();
		}
		return $this->status;
	}
	function status() {
		$rv = $this->getTracked();

		// $rv->modified = $this->getLines( 'modified' );
		$rv->untracked = $this->getUntracked();
		return $rv;
	}
	function getTracked() {
		$rv = array();

		foreach( $this->getStatus() as $line ) {
			if ( strpos( $line, 'Untracked files') ) {
				return new MadData($rv);
			}
			if ( ! preg_match( '/(modified|deleted):/', $line ) ) {
				continue;
			}

			$line = trim( substr( $line, 1 ) );
			list($key, $value) = explode(':', $line);
			$value = trim($value);

			if ( ! isset( $rv[$key] ) ) {
				$rv[$key] = array();
			}
			$rv[$key][] = $value;
		}
		return new MadData( $rv );
	}
	function getUntracked() {
		$rv = array();

		$switch = false;
		foreach( $this->getStatus() as $line ) {
			if ( strpos( $line, 'Untracked files') ) {
				$switch = true;
			}
			if ( $switch == false ) continue;

			$line = trim( substr( $line, 1 ) );
			if ( empty( $line ) || ! file_exists( $line ) ) continue;
			$rv[] = $line;
		}
		return new MadData( $rv );
	}
}
