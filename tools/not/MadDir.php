<?
class MadDir {
	private $filteringRules = array();
	private $data = array();
	private $dir;
	function __construct($dirName) {
		$target = $dirName;
		if ( is_dir($target) ) {
			print $this->dir = $target;
		}
		$this->filteringRules[] = '.';
		$this->filteringRules[] = '..';
	}
	function filter($rule) {
		$this->filteringRules[] = $rule;
	}
	function remove() {
		if (is_dir($this->dir)) {
			$objects = scandir($this->dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($this->dir."/".$object) == "dir") rrmdir($this->dir."/".$object); else unlink($this->dir."/".$object);
				}
			}
			reset($objects);
			rmdir($this->dir);
		} 
	}
	function removeAll() {
	}
	function move( $dir ) {
		if ( ! file_exists( $dir ) ) {
		print $this->dir;
			return rename( $this->dir, $dir );
		}
		return false;
	}
	function get() {
		while (false !== ($entry = $this->dir->read())) {
			if ( in_array($entry, $this->filteringRules) ) continue;
			$this->data[] = $entry;
		}
		return $this->data;
	}
	function __toString() {
		$this->get();
		$rv = implode('<br />',$this->data);
		return $rv;
	}
}
