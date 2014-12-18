<?
class MadDbColumnWriter extends MadData {
	function isWritable() {
		if ( $this->autoIncrement != 'true' 
			&& $this->name != 'wDate'
			&& $this->name != 'uDate'
			) {
			return true;
		}
		return false;
	}
}
