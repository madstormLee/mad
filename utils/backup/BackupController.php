<?
class BackupController extends MadController {
	function indexAction() {
	}
	function backupAction() {
		return $this->model->backup();
	}
	function patchAction() {
		if ( ! $result = $this->model->patch( $this->params->file ) ) {
			throw new Exception('Patch Error.');
		}
		return '패치가 완료되었습니다.';
	}
	function uploadAction() {
		if ( ! is_file($_FILES['patchFile']['tmp_name']) ) {
			throw new Exception( 'Upload error' );
		}
		$destination = $this->patchDir . $_FILES['patchFile']['name'];
		if ( ! is_file( $destination ) ) {
			throw new Exception( 'File already exists.' );
		}
		if ( ! move_uploaded_file($_FILES['patchFile']['tmp_name'], $destination) ) {
			throw new Exception( 'upload error.' );
		}
		return '패치 파일이 저장 되었 습니다.';
	}
	function deleteAction() {
		return $this->model->delete( $this->params->id );
	}
}
