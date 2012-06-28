<?
class SiteImageController extends MadController {
	function getAction() {
		// $targetUrl = "http://www.google.com";
		$targetUrl = $this->post->targetUrl;
		$fileName = $this->post->fileName;

		$imageHost = "http://co2.a1m.co.kr";
		$url = $imageHost . "/webthumb.php?url=$targetUrl";
		$imageUrl = $imageHost . file_get_contents($url);
		$image = file_get_contents( $imageUrl );
		// temporally.
		if( $result = file_put_contents( ROOT . $fileName, $image ) ) {
			print $fileName;
		}
	}
}
