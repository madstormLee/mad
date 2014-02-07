<?
class Itemcategory extends MadModel {
	function getNextOrder() {
		return $this->db->max( $this->table, 'orderNumber', "parentid='$this->parentid'") + 1;
	}
	static function getIdFromName( $label ) {
		return MadDb::create()->query( "select id from itemcategory where label like '$label' limit 1" )->getFirst();
	}
	static function getIdIncludeSubs( $categoryid ) {
		if ( is_string( $categoryid  ) ) {
			$categoryids = $categoryid;
		} else if ( $categoryid instanceof MadData ) {
			$categoryids = $categoryid->implode(',');
		}
		$subs =  MadDb::create()->query( "select id from itemcategory where parentid in ( $categoryids )" )->getData()->dic('id')->implode(',');
		if ( $subs ) {
			$categoryids .= ",$subs";
		}
		return $categoryids;
	}
}
