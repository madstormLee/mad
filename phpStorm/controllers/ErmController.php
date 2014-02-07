<?
class ErmController extends Preset {
	function __construct() {
		parent::__construct();
		$this->dirs = $this->phpStorm->dirs;
		$this->ermDir = $this->phpStorm->getDir('erm');
	}
	function indexAction() {
		$this->js->replace("$this->projectRoot$this->controllerName/list");
		return new MadView;
	}
	function viewAction() {
		$contents = htmlSpecialChars( file_get_contents( $this->get->file ) );
		return "<pre>$contents</pre>";
	}
	function viewXmlAction() {
		$this->setLayout();
		MadHeaders::xml();
		return file_get_contents( $this->get->file );
	}
	function writeAction() {
		return new MadView;
	}
	function listAction() {
		$list = new ErmList;
		$list->setDir( $this->phpStorm->getDir('erm') );

		
		$this->main->list = $list;
		return $this->main;
	}
	function writeConfigAction() {
		$erm = new Erm( $this->get->file );
		$configs = new Erm2Configs( $erm );
		
		$this->main->preview = $configs->getPreview();
		return $this->main;
	}
	function saveConfigsAction() {
		$phpStorm = $this->phpStorm;
		$configDir = $phpStorm->getDir('configs');
		$erm = new Erm( $this->get->file );

		$configs = new Erm2Configs( $erm );
		$configs->setConfigDir( $configDir );
		$configs->setData();

		$cnt = 0; foreach( $configs as $config ) {
			$config->setWriteMode( 'force' );
			$cnt += $config->save();
		}
		$this->js->alert( "$cnt 개의 config file이 생성되었습니다.")->replace('./list');
	}
	function uploadAction() {
		$uploader = new MadUploader($this->ermDir);
		if ( ! $uploader->upload() ) {
			return 'fail';
		}
		$this->js->replace( 'list' );
	}
	function deleteAction() {
		$file = $this->get->file;
		if ( is_file( $file ) && unlink( $file ) ) {
			return true;
		}
		return false;
	}
	function downloadAction() {
	}
}
