<?
class TableTag extends Tag {
	function __construct($id='', $class=''){
		parent::__construct('table');
		$this->id = $id;
		$this->class = $class;
	}
	function fromSql($q){
		$innerHTML = '';
		$innerHTML .='<thead><tr>';
		for($i=0;$i<$q->cols;$i++){
			$innerHTML .='<th>'.mysql_field_name($q->result,$i).'</th>';
		}
		$innerHTML .='</tr></thead>';
		$values = $q->toArray();
		foreach( $values as $row ) {
			$innerHTML .='<tr>';
			foreach ( $row as $value ) {
				$innerHTML .="<td>$value</td>";
			}
			$innerHTML .='</tr>';
		}
		$this->innerHTML = $innerHTML;
	}
}
