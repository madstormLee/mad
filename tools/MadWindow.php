<?
class MadWindow extends MadView {
	function __construct( $view = '' ) {
		if ( empty( $view ) ) {
			$view = MAD . 'views/MadWindow/widget';
		}
		parent::__construct( $view );
		$this->title = 'NoTitle';
		$this->content = '';
	}
	function setTitle( $title ) {
		$this->title = $title;
		return $this;
	}
	function getTitle() {
		return $this->title;
	}
	function setContent( $content ) {
		$this->content = $content;
		return $this;
	}
	function getContent() {
		return $this->content;
	}
}
