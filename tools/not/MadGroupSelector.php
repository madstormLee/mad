<?
// 이 클래스는 checkbox form의 일종이다.
class MadGroupSelector {
	private $tail;
	private $group;
	private $view;
	public $currents = array();

	function __construct( $tail ) {
		$this->tail = $tail;
		$this->group = new MadGroup( $tail );
		$this->view = ROOT . 'mad/views/Forms/MadGroupSelector.html';
		$js = JsManager::getInstance();
		$js->set('/mad/js/MadGroupSelector');
	}
	function getView() {
		return $this->view;
	}
	function setView( $view ) {
		if ( is_file( $view ) ) {
			$this->view = $view;
		}
		return $this;
	}
	function setCurrents( $currents ) {
		if ( is_array( $currents ) ) {
			$this->currents = $currents;
		}
		return $this;
	}
	function selectorAction() {
		$this->tuple = $this->group->getTree();
	}
	private function dlTree($subTree ) {
		$rv = "<dl>";
		foreach( $subTree as $no => $row ) {
			$checked = '';
			if ( in_array( $no, $this->currents) ) {
				$checked = 'checked';
			}
			$id = $this->tail . $row['no'];
			$rv .= "<dt>";
			if ( ! empty($row['subTree']) ) {
				$rv .= "<a href='#subTreeOf$id'>+</a>";
			}
			$rv .= "<input type='checkbox' value='{$row['no']}' id='$id' name='{$this->tail}[]' $checked />
				<label for='$id'>{$row['name']}</label>
				</dt>";
			if ( empty($row['subTree']) ) {
				continue;
			}
			$rv .= '<dd style="display: none">';
			$rv .= $this->dlTree( $row['subTree'] );
			$rv .= '</dd>';
		}
		$rv .= "</dl>";
		return $rv;
	}
	function __toString() {
		$groupTree = $this->dlTree( $this->group->getTree() );
		ob_start();
		include $this->view;
		return ob_get_clean();
	}
}
