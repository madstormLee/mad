<?
class Php {
	private $option = -1; // INFO_ALL

	private $command = '';
	function command( $command='' ) {
		if ( empty( $command ) ) {
			return $this->getCommand();
		}
		$this->command = $command;
		return $this;
	}
	function getCommand() {
		return $this->command;
	}
	function getSource() {
		return highlight_string( $this->command );
	}
	function getResult() {
		ob_start();
		eval( $this->command );
		$rv = ob_get_clean();
		if ( empty( $rv ) ) {
			$rv = 'no result';
		}
		return $rv;
	}
	function setOption( $option = '' ) {
		if( empty( $option ) ) {
			return false;
		}
		if ( is_array( $option ) ) {
			$this->option = 0;
			foreach( $option as $value ) {
				$this->option |= $value;
			}
		} else {
			$this->option = $option;
		}
		return $this;
	}
	function getOption() {
		return $this->option;
	}
	function splClasses() {
		return spl_classes();
	}
	function hasOption( $option ) {
		if ( $option == -1 ) {
			return $this->option == -1;
		}
		return $this->option&$option;
	}
	function info() {
		ob_start();
		phpinfo( $this->option );
		$rv = ob_get_clean();

		return $rv;
	}
	function getOptions() {
		return new MadJson('php/options.json');
	}
	function getIndex() {
	}
}
