<?
class MadFront {
	private static $instance = null;

	private function __construct() {
	}
	public function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __toString() {
		try {
			$result = $this->dispatch();
			return $result;
		} catch ( Exception $e ) {
			return $e;
		}
	}
	private function dispatch() {
		$configs = MadConfigs::getInstance();
		try {
			$controller = MadController::create( $configs->router->controller );
			$action = $configs->router->action . 'Action';

			$contents = $controller->$action();
		} catch ( PDOException $e ) {
			if ( $configs->debug == true ) {
				return (new MadDebug)->printR( $e, true );
			}
			throw $e;
		} catch ( Exception $e ) {
			$message = _( $e->getMessage() );
			if ( IS_AJAX || IS_INTERNAL ) {
				return $message;
			}
			MadJs::getInstance()->alert( $message )->replaceBack();
		}

		if ( (! IS_INTERNAL) && (! IS_AJAX) &&
				( empty( $contents ) || is_numeric( $contents ) ) ) {
			MadJs::getInstance()->replaceBack();
		}

		if ( IS_AJAX ) {
			return $contents;
		}
		if ( IS_GET ) {
			$layout = MadComponent::create( $configs->layout );
			$configs->layout->contents = $contents;
			return $configs->layout;
		}
		if ( IS_POST ) {
			return $contents;
		}
	}
}
