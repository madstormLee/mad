<?
class MadBackup {
	private $conn;
	private $system;
	private $dir;
	private $date;

	function Backup() {
		include TOOLSDIR.'/conn.php';
		$this->conn = $conn;

		$this->date = date('Ymd_Hi');
		$this->dir = $_SERVER['DOCUMENT_ROOT'].'/../backup';
		$this->system = ( isset($_ENV['TERM']) && $_ENV['TERM']=='linux' )?'linux':'windows';

		$mode = empty($_GET['mode']) ? null : $_GET['mode'];
		if ( $mode ) $this->$mode();

		print $this->view();
	}
	function backup_file(){
		extract( $this->conn );

		if($this->system == 'windows'){
			$file_name = $this->date.'_'. $db .'.zip';
			`alzip -a ../*.* $file_name`;
			`move $file_name {$this->dir}`;
		} else {
			$file_name=$this->date.'_'. $db .'.tar';
			`tar -cf $file_name ../*`;
			`mv $file_name {$this->dir}`;
		}
	}
	function backup_db(){
		extract( $this->conn );

		$file_name=$this->date . '_' . $db . '.dump';
		`mysqldump -u$id -p$pw --databases $db > {$this->dir}/$file_name`;
	}
	function download(){
		$source=$_GET['location'];
		$tempdir='temp';
		if( ! is_dir($tempdir) ) mkdir($tempdir);

		if ($this->system == 'windows') {
			$source = str_replace('/', '\\',$source);
			`copy $source $tempdir`;
		} else {
			`cp $source $tempdir`;
		}

		$file_name=basename($source);
		$href=$tempdir.'/'.$file_name;

		$rv = "<div class='download'>";
		$rv .= "<a href='$href'>$file_name</a>";
		$rv .= '</div>';
		print $rv;
	}
	function remove(){
		$lo=$_GET['location'];
		if ( is_file($lo) ) unlink($lo);
	}
	function remove_temp(){
		if( is_dir('temp') ) {
			if( $this->system == 'windows' )
				`rd /s/q temp`;
			else
				`rm -rf temp`;
		}
	}
	function menu() {
		include MAD . '/views/backup/menu.html';
	}
	function view(){
		$rv = css('/mad/views/css/backup');
		$rv .= "<div class='backup'>";
		$d = dir($this->dir);
		while (false !== ($entry = $d->read())) {
			$href="$this->dir/$entry";
			if(!is_dir($href)){
				$rv .= "<ul class='downloadLink'>
					<li><a href='?mode=download&location=$href'>$entry</a></li>
					<li><a href='?mode=remove&location=$href' class='btn01'>remove</a></li>
					</ul>";
			}
		}
		$d->close();
		$rv .= "</div>";
		$rv .= $this->menu();
		return $rv;
	}
}
