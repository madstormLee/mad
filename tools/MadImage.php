<?php
/*
 * File: SimpleImage.php
 * Author: Simon Jarvis
 * Copyright: 2006 Simon Jarvis
 * Date: 08/11/06
 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 * 
 * 
 * madstorm changed some.
 */

class MadImage {
	private $file = null;
	private $ext = 'jpg';

	private $image = null;
	private $type = 2;
	private $info = null;
	private $compression = 75;

	function __construct( $file ) {
		$this->setFile( $file );
		$this->load();
	}
	function saveAs( $file ) {
		return $this->save( $file );
	}
	function setFile( $file = '' ) {
		if ( empty( $file ) ) {
			return false;
		}
		$this->file = $file;
		return $this;
	}
	function getInfo() {
		return $this->info;
	}
	// @override
	function getExtension() {
		if ( $this->type == 1 ) {
			return 'gif';
		}
		if ( $this->type == IMAGETYPE_PNG ) {
			return 'png';
		}
		return 'jpg';
	}
	function setType( $type = IMAGETYPE_JPEG ) {
		$this->type = $type;
		return $this;
	}
	function getType() {
		return $this->type;
	}
	function getRatio() {
		$size = getimagesize( $this->image );
		return $size[1] / $size[0];
	}
	function isAnimation($filename) {
		return ! ! preg_match('#(\x00\x21\xF9\x04.{4}\x00\x2C.*){2,}#s', file_get_contents($filename));
	}
	function load( $file = '' ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if ( ! $this->isFile() ) {
			return false;
		}

		$this->info = new MadData( getImageSize( $this->file ) );
		$this->type = $this->info[2];

		if( $this->type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg($this->file);
		} elseif( $this->type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif($this->file);
		} elseif( $this->type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng($this->file);
		}
	}
	function setCompression( $compression=75 ) {
		$this->compression = $compression;
		return $this;
	}
	function save( $file = '' ) {
		if( $this->type == IMAGETYPE_JPEG ) {
			$result = imagejpeg($this->image,$file,$this->compression);
		} elseif( $this->type == IMAGETYPE_GIF ) {
			$result = imagegif($this->image,$file);
		} elseif( $this->type == IMAGETYPE_PNG ) {
			$result = imagepng($this->image,$file);
		}
		return $result;
	}
	function getWidth() {
		return imagesx($this->image);
	}
	function getHeight() {
		return imagesy($this->image);
	}
	function cropWidth( $startX, $width ) {
		$height = $this->getHeight();
		$new_image = imageCreateTrueColor($width, $height);
		imageCopyResampled($new_image, $this->image, 0, 0, $startX, 0, $width, $height, $width, $height);
		$this->image = $new_image;
	}
	function resize( $width, $height ) {
		$new_image = imageCreateTrueColor($width, $height);
		imageCopyResampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}      
	function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}
	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);
	}
	function output( $type = IMAGETYPE_JPEG ) {
		if( $this->type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image);
		} elseif( $this->type == IMAGETYPE_GIF ) {
			imagegif($this->image);
		} elseif( $this->type == IMAGETYPE_PNG ) {
			imagepng($this->image);
		}
	}
	function __toString() {
		$this->output();
		return '';
	}
}
