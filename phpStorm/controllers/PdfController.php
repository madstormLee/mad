<?
// dompdf는 공식적으로 포기한다.
// 일단 한글이 나오게 한다고 해도 css를 처리할 시간이 부족하다.
// 시간은 조금 느리지만, 이미지를 이용한 처리를 사용한다.

class PdfController extends MadController {
	function __construct() {
		parent::__construct();
	}
	function downloadAction() {
		require_once( ROOT . "nomad/dompdf/dompdf_config.inc.php");

		$post = $this->post;
		if ( ! $post->paper ) {
			$post->paper = 'a4';
		}
		if ( ! $post->orientation ) {
			$post->orientation = 'portrait';
		}
		$dompdf = new DOMPDF();
		$dompdf->load_html( $post->html );
		$dompdf->set_paper( $post->paper, $post->orientation );
		$dompdf->render();

		$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
		die;
	}
	function downloadLocationAction() {
		require_once( ROOT . "nomad/dompdf/dompdf_config.inc.php");

		$data = new MadData;
		$data->paper = 'a4';
		$data->orientation = 'portrait';
		$url = "http://localhost{$this->get->url}";
		$data->html = file_get_contents( $url );

		$dompdf = new DOMPDF(); 
		$data->html = iconv('UTF-8','Windows-1250',$data->html);
		$dompdf->load_html( $data->html );
		$dompdf->set_paper( $data->paper, $data->orientation );
		$dompdf->render();

		$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
		die;
	}
}
