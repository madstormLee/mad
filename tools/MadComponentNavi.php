<?
class MadComponentNavi extends MadView {
	private $model = null;
	function __construct( $model = null ) {
		$this->model = $model;
	}
	function __toString() {
		$router = MadRouter::getInstance();
		$model = $this->model;
		// temporally... not done.
?>
<nav class='clearfix'>
	<ul class='button-group round right'>
		<li><a class='small button' href='./index'>Index</a></li>
		<? if ( $router->action != 'view' ): ?>
		<li><a class='small button' href='./write'>Write</a></li>
		<? elseif ( $router->action == 'view' ): ?>
		<li><a class='small button' href='./write?file=<?=$model->getFile()?>'>Edit</a></li>
		<li><a class='small button' href='./delete?file=<?=$model->getFile()?>' data-confirm='Remove file?'>Delete</a></li>
		<? endif; ?>
	</ul>
</nav>
<?
		$rv = '';
		return $rv;
	}
}

