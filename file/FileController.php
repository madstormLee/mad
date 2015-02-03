<?
class FileController extends MadController {
	function indexAction() {
		$this->model = new MadDir;
		$model = $this->model;
		$get = $this->params;

		$model->h1 = 'File Index';

		if ( ! $get->dir || ! is_dir( $get->dir ) ) {
			$get->dir = $_SERVER['DOCUMENT_ROOT'];
		}
		$get->pattern = '*.php';
		if ( ! isset($get->pattern) ) {
			$get->pattern = '*';
		}
		$model->setDir( $get->dir );
		$model->setPattern( $get->pattern );

		$this->view->model = $model;
	}
	function dirAction() {
		$this->indexAction();
	}
	function filesAction() {
		$this->indexAction();
	}
	function openAction() {
		$params = $this->params;
		$model = $this->model;
		if ( $params->dir ) {
			$this->model->setDir( $params->dir );
		}
	}
	function viewAction() {
		$get = $this->params;
		if ( ! $get->file ) {
			$get->file = 'data';
		}
		$get->file = realpath( $get->file );
		$model = new MadFile( $get->file );
		$this->view->model = $model;
	}
	function writeContentsAction() {
	}
	function saveContentsAction() {
		throw new Exception( 'not yet' );
	}
	function viewRawAction() {
		$contents = htmlSpecialChars( file_get_contents( $this->params->file ) );
		return "<pre>$contents</pre>";
	}
	function renameAction() {
		$file = new MadFile( $this->get->file );
		$this->view->file = $file;
	}
	function mvAction() {
		$post = $this->post;
		if ( ( ! $post->file ) || ( ! $post->name ) ) {
			throw new Exception( 'error' );
		}
		$file = new MadFile( $post->file );
		return $file->rename( $post->name );
	}
	function saveDirAction() {
		$post = $this->post;
		if ( $post->baseDir ) {
			$post->dirName = $post->baseDir . '/' . $post->dirName;
		}
		return @mkdir( $post->dirName, 0755, true );
	}
	function downloadAction() {
		$model = new MadFile( $this->params->file );
		if ( ! $model->isFile() ) {
			return 'No target';
		}
		return $model->download();
	}
	function uploadAction() {
		$POST_MAX_SIZE = ini_get('post_max_size');
		$unit = strtoupper(substr($POST_MAX_SIZE, -1));
		$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

		if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
			header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
			throw new Exception( "POST exceeded maximum allowed size." );
			exit(0);
		}

		// Settings
		// $save_path = "uploads/";
		$save_path = $_SESSION['upload_dir'] . '/';
		$upload_name = "Filedata";
		$max_file_size_in_bytes = 2147483647;
		$extension_whitelist = array("jpg", "gif", "png");

		$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';

		// Other variables	
		$MAX_FILENAME_LENGTH = 260;
		$file_name = "";
		$file_extension = "";

		$uploadErrors = array(
				0=>"There is no error, the file uploaded with success",
				1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
				2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
				3=>"The uploaded file was only partially uploaded",
				4=>"No file was uploaded",
				6=>"Missing a temporary folder"
				);


		// Validate the upload
		if (!isset($_FILES[$upload_name])) {
			throw new Exception("No upload found in \$_FILES for " . $upload_name);
			exit(0);
		} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
			print $uploadErrors[$_FILES[$upload_name]["error"]];
			exit(0);
		} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
			throw new Exception("Upload failed is_uploaded_file test.");
			exit(0);
		} else if (!isset($_FILES[$upload_name]['name'])) {
			throw new Exception("File has no name.");
			exit(0);
		}

		// Validate the file size (Warning: the largest files supported by this code is 2GB)
		$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			throw new Exception("File exceeds the maximum allowed size");
			exit(0);
		}

		if ($file_size <= 0) {
			throw new Exception("File size outside allowed lower bound");
			exit(0);
		}


		// Validate file name (for our purposes we'll just remove invalid characters)
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			throw new Exception("Invalid file name");
			exit(0);
		}


		// Validate that we won't over-write an existing file
		if (file_exists($save_path . $file_name)) {
			throw new Exception("File with this name already exists");
			exit(0);
		}

		// Validate file extension
		$path_info = pathinfo($_FILES[$upload_name]['name']);
		$file_extension = $path_info["extension"];
		$is_valid_extension = false;
		foreach ($extension_whitelist as $extension) {
			if (strcasecmp($file_extension, $extension) == 0) {
				$is_valid_extension = true;
				break;
			}
		}
		if (!$is_valid_extension) {
			throw new Exception("Invalid file extension");
			exit(0);
		}

		file_put_contents( 'uploads/log.txt', $save_path . $file_name , FILE_APPEND );

		// Process the file
		if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
			throw new Exception("File could not be saved.");
			exit(0);
		}
		exit(0);
	}
}
