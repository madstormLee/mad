<?
class MadFtp {
	private $server = 'madstorm.org';
	private $id = 'doginmud';
	private $pw = '12yard';

	function __construct($server,$id,$pw){
		$this->server = $server;
		$this->id = $id;
		$this->pw = $pw;
	}
	function __destruct() {
		$this->close();
	}
	function connect(){
		$this->conn_id = ftp_connect($ftp_server); 
		$login_result = ftp_login($this->conn_id, $this->id, $this->pw); 
		if ((!$conn_id) || (!$login_result)) { 
			echo "FTP connection has failed!";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
			exit; 
		} else {
			echo "Connected to $ftp_server, for user $ftp_user_name";
		}
	}
	function upload($source_file, $destination_file=''){
		if ( empty($destination_file) ) $destination_file = $source_file;

		$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); 
		if (!$upload) { 
			return false;
		} else {
			return "Uploaded $source_file to $ftp_server as $destination_file";
		}
	}
	function close() {
		ftp_close($this->conn_id); 
	}
	function download(){
	}
}
