<?
class MadStat extends MadProgram {
	function __construct(){
		parent::__construct();
	}
	function fileCounter($file='counter'){
		if(file_exists($file)){
			$count=intval( file_get_contents($file) );
		}
		$count++;

		file_put_contents($file, $count);

		return $count;
	}
}
