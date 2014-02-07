<?
class SitemapTree extends MadJson {
	private $treeView;
	function __construct( $file ) {
		parent::__construct( $file );
		$treeView = function ( $data, $depth = 0, $visible = true ) use ( &$treeView ) {
			++$depth;
			$rv = "<dl class='depth$depth'>\n";
			foreach( $data as $location => $values ){
				$menu = "<ul class='buttons'>
					<li><a class='view' href='view?location=$location'>보기</a><li>
					<li><a class='view' href='write?location=$location'>편집</a><li>
					<li><a class='write' href='writeSub?location=$location'>추가</a><li>
					<li><a class='remove' href='remove?location=$location'>삭제</a><li>
					</ul>";
				$rv .= "<dt>
					<span class='label'>$location ( $values->label ) :</span>
					<span class='action'>$values->action</span>
					<span class='menu'>$menu</span>
					</dt>";
				if ( $values->subDir ) {
					$display = $visible ? '' : " style='display: none'";
					$rv .= "<dd$display>" . $treeView( $values->subDir, $depth ) ."</dd>\n";
				}
			}
			$rv .= "</dl>\n";
			return $rv;
		};
		$this->treeView = $treeView;
	}
	public function setTreeView( $treeView ) {
		$this->treeView = $treeView;
	}
	public function find( $target ) {
		return $this->findSub( $this->data, $target );
	}
	private function findSub( $data, $target ) {
		foreach( $data as $key => $value ) {
			if ( $key == $target ) {
				return $value;
			}
			if ( $value->subDir ) {
				if ( $result = $this->findSub( $value->subDir, $target ) ) {
					return $result;
				}
			}
		}
		return false;
	}
	function __toString() {
		$func = $this->treeView;
		return $func( $this->data );
	}
}
