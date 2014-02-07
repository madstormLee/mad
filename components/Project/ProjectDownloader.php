<?
class ProjectDownloader extends MadData {
	private $target = array();
	private $ext = '.tar.gz';

	function findHead( $targetDir, $project ) {
		// MadDir can do that?
		$lastVersionName = '';
		$lastVersionFile = '';
		$dir = new MadDir($targetDir);

		$dir->setType( $project );
		foreach( $dir as $file ) {
			$currentName = strstr( baseName($file), $this->ext, true );
			if ( $lastVersionName < $currentName ) {
				$lastVersionName = $currentName;
			}
			$lastVersionFile = $file;
		}
		return $lastVersionFile;
	}
	function getTarget() {
		if ( ! $this->project ) {
			throw new Exception('need project');
		}
		if ( ! $this->version || $this->version == 'head') {
			$target = $model->findHead( $targetDir, $this->project );
		} else {
			$fileName = $this->project . $this->version . $this->ext;
			$target = $targetDir . $fileName;
		}
		if ( ! is_file( $target ) ) {
			throw new Exception( $fileName . ' file not found.');
		}
	}
	function getContents() {
		return file_get_contents( $this->getTarget() );
	}
}
