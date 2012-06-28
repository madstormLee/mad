<?
class Database extends Mad {
	function __construct() {
	}
	function getList() {
		return new DatabaseList($this);
	}
}
