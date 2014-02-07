<?
class MadGd {
	public static function getRatio( $image ) {
		$size = getimagesize( $image );
		return $size[1] / $size[0];
	}
	public static function createThumb($source,$target,$thumbWidth,$thumbHeight){
		$acceptables = new MadData( array( 'jpg','jpeg','png','gif' ) );
		$ext = getExtension( $source );
		if ( ! $acceptables->in( $ext ) ) {
			return 0;
		}

		$properties = getImageSize($source);
		$createFunction = 'ImageCreateFrom'.$extName;
		$srcImage = $createFunction($source);

		$srcX = ImageSX($srcImage);
		$srcY = ImageSY($srcImage);
		if (($thumbHeight == "0") && ($thumbWidth == "0")) {
			return(0);
		} elseif ($thumbHeight == "0") {
			$scaleX = $thumbWidth/($srcX-1);
			$thumbHeight = $srcY*$scaleX;
		} elseif ($thumbWidth == "0") {
			$scaleY = $thumbHeight/($srcY-1);
			$thumbWidth = $srcX*$scaleY;
		}

		$thumbWidth = (int)($thumbWidth);
		$thumbHeight = (int)($thumbHeight);
		$targetImage = imageCreateTrueColor($thumbWidth, $thumbHeight);
		if (!imageCopyResized($targetImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcX, $srcY)) {
			$rv = 0;
		} else {
			$outputFunction = 'image'.$extName;
			if ($outputFunction($targetImage,$target)) {
				$rv = 1;
			}
		}
		imagedestroy($srcImage);
		imagedestroy($targetImage);
		return $rv;
	}
	function is_ani($filename) {
		    return (bool)preg_match('#(\x00\x21\xF9\x04.{4}\x00\x2C.*){2,}#s', file_get_contents($filename));
	}
}
