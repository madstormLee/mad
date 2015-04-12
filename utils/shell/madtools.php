<?
/** this program is command line initial program for madtools */
$madtools = new Madtools;
$madtools->execute();

class Madtools {
	const URL = 'http://localhost/madtools/';
	private $targetDir = '.';
	private $command = 'install';
	private $options;
	private $commands = array();

	public function __construct() {
		$this->setCommands();

		$argv = $GLOBALS['argv'];
		if ( isset( $argv[1] )  ) {
			$this->command = $argv[1];
		}
		$this->options = array_slice( $argv, 2 );

		if ( false !== strpos( get_include_path() , PHP_LIBDIR ) &&
			is_writable( PHP_LIBDIR )) {
			$this->targetDir = PHP_LIBDIR;
		}
	}
	public function execute() {
		if ( phpVersion() < "5.2" ) {
			$this->error('phpVersionIsLow');
		}
		if ( ! $this->isCommand() ) {
			$this->error( 'commandNotFound', $this->command );
		}
		$this->{$this->command}();
	}
	/****************** commands **********************/
	private function usage() {
		$data = $this->getData();
		print $data['description'];
	}
	private function help() {
	}
	private function install() {
		$project = 'madtools';
		$version = 'head';
		if ( isset( $this->options[0] ) ) {
			$project = $this->options[0];
		}
		if ( isset( $this->options[1] ) ) {
			$version = $this->options[1];
		}
		if ( is_file( $this->targetDir . '/mad/tools.php' ) ) {
			// 에러를 return할 수 있지 않을까?
			$this->error('madtoolsExists');
			return false;
		}
		// 뭔가 exceptional한 상황에 대응하고 싶지만, 일단은..
		$url = self::URL . "project/download?project=$project&version=$version";
		$contents = file_get_contents( $url );
		$destination = $this->targetDir . 'downloaded.tar.gz';
		file_put_contents( $destination, $contents );
		`tar -xzf $destination`;
		`rm -rf $destination`;
	}
	private function update() {
	}
	/************** tool methods *****************/
	private function manual( $about ) {
		if ( $about == 'commandList' ) {
			print 'commandList';
		}
	}
	private function isCommand() {
		return isset( $this->commands[$this->command] );
	}
	private function setCommands() {
		$commands = file_get_contents( self::URL . 'installer/commands' );
		$this->commands = json_decode( $commands, true );
	}
	private function error( $errorCode, $target = '' ) {
		$errors = json_decode( file_get_contents( self::URL . 'installer/errors' ), true );
		if ( ! isset( $errors[$errorCode] ) ) {
			$errorCode = 'errorCodeNotFound';
		}
		$errorText = str_replace( '{command}', $this->command, $errors[$errorCode] );
		print "Error : " . $errorText . "\n";
		if ( $errorCode == 'commandNotFound' ) {
			print $this->getCommandList();
		}
		die;
	}
	private function getCommandList() {
		return 'command list';
	}
	private function getData() {
		return $this->commands[$this->command];
	}
}
