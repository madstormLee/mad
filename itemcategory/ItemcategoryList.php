<?
class ItemcategoryList extends MadListModel {
	static function getCategoryLabel() {
		$query = "select id, label from itemcategory";
		return MadDb::create()->query( $query )->getData()->dic('id', 'label' );
	}
	static function getTreeData( $treeid ) {
		$query = "select * from itemcategory order by parentid desc, ordernumber asc";
		return MadDb::create()->query( $query )->getData()->index('id');;
	}
	static function createTree( $treeid = 1 ) {
		return new MadTree( self::getTreeData( $treeid ) );
	}
	static function createTreeWithCounts( $treeid ) {
		return new MadTree( ItemList::decorateCategoryCounts( self::getTreeData( $treeid ) ) );
	}
	function search( $key, $value ) {
		$this->query->where( "$key = '$value'" );
		return $this;
	}
	function noLimit() {
		$this->query->limit();
		return $this;
	}
}
