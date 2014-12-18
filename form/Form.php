<?
// not done anything
class Form {
	function getIterator() {
		$dbname = 'designstory';
		$tablename = 'request';
		$result = mysql_list_fields($dbname,$tablename);
		$rows = mysql_num_fields($result);
		for($i=0; $i<$rows; $i++) {
			$field=mysql_field_name($result, $i);
		}
	}
}
