<?php

/*********************************************************************
 *                                                                   *
 *    Image Resizer - a handy PHP class for image resizing           *
 *   _____________________________________________________________   *
 *                                                                   *
 *           FILE :  class.resizer.php                               *
 *           DATE :  February 04, 2006                               *
 *       CODED BY :  Blagovest Buyukliev <hitman@bootbox.net>        *
 *   REQUIREMENTS :  GD2 Extension                                   *
 *        LICENSE :  Absolutely Free; You can send me donations :)   *
 *                                                                   *
 ********************************************************************/

if (!defined('__CLASS_RESIZER'))
	define('__CLASS_RESIZER', 1);
else return;

define('IR_CACHETABLE', 'imgcache');

define('IR_E_OK',                         1);
define('IR_E_URL_NOT_READABLE',           2);
define('IR_E_FILE_NOT_EXISTS',            3);
define('IR_E_FORMAT_UNSUPPORTED',         4);
define('IR_E_CREATEFUNC_NOT_EXISTS',      5);
define('IR_E_OUTFUNC_NOT_EXISTS',         6);
define('IR_E_OUTPUT_FORMAT_UNSUPPORTED',  7);
define('IR_E_INVALID_IMAGE',              8);
define('IR_E_NO_GD_SUPPORT',              9);
define('IR_E_NO_ASSIGNED_FILE',          10);
define('IR_E_BUFFER_NOT_READY',          11);
define('IR_E_FILE_NOT_WRITEABLE',        12);

class resizer
{
	var $type, $mime;
	var $width = 0, $height = 0;
	var $errmsgs = array();
	var $opqueue = array();
	var $source = '', $buffer = '';
	var $caching = false;
	var $createfuncs = array(
		 1 => 'imagecreatefromgif',
		 2 => 'imagecreatefromjpeg',
		 3 => 'imagecreatefrompng',
		15 => 'imagecreatefromwbmp',
	);

	function setfile ($source)
	{
		$is_url = ereg("^(http://|https://|ftp://|ftps://)", $source);

		if ($is_url && !ini_get('allow_url_fopen')) {
			$this->errmsgs[] = "setfile(): couldn't open URL because allow_url_fopen is off";
			return IR_E_URL_NOT_READABLE;
		}

		if (!$is_url && (!file_exists($source) || is_dir($source))) {
			$this->errmsgs[] = "setfile(): specified file doesn't exist";
			return IR_E_FILE_NOT_EXISTS;
		}

		if ($imageinfo = @getimagesize($source)) {
			if (!in_array($imageinfo[2], array(1, /*GIF*/ 2, /*JPEG*/ 3, /*PNG*/ 15 /*WBMP*/))) {
				$this->errmsgs[] = "setfile(): supported formats are GIF, JPEG, PNG and WBMP";
				return IR_E_FORMAT_UNSUPPORTED;
			}

			list($this->width, $this->height, $this->type) = $imageinfo;
			$i = 0;

			foreach ($this->createfuncs as $func)
				if ($this->type == ++$i && !function_exists($func)) {
					$this->errmsgs[] = "setfile(): function $func() doesn't exist";
					return IR_E_CREATEFUNC_NOT_EXISTS;
				}

			$this->source = $source;
			return IR_E_OK;
		} else {
			$this->errmsgs[] = "setfile(): invalid image";
			return IR_E_INVALID_IMAGE;
		}
	}

	function get_width ()
	{
		return $this->width;
	}

	function get_height ()
	{
		return $this->height;
	}

	function resize ($w_new, $h_new)
	{
		$w_new = round($w_new);
		$h_new = round($h_new);

		$this->width = ($w_new <= 1) ? 1 : $w_new;
		$this->height = ($h_new <= 1) ? 1 : $h_new;

		array_unshift($this->opqueue, "resize|{$this->width}|{$this->height}");
	}

	function resize_fit_region ($w_reg, $h_reg, $enlarge_smaller = true)
	{
		$w_reg = floatval($w_reg);
		$h_reg = floatval($h_reg);

		if (!$enlarge_smaller && $this->width <= $w_reg && $this->height <= $h_reg)
			return;

		if ($h_reg / $this->height * $this->width < $w_reg)
			$this->resize($h_reg / $this->height * $this->width, $h_reg);
		else
			$this->resize($w_reg, $w_reg / $this->width * $this->height);
	}

	function resize_ratio ($ratio)
	{
		$ratio = floatval($ratio);
		$this->resize($this->width * $ratio, $this->height * $ratio);
	}

	function resize_ratio_xy ($ratio_x, $ratio_y)
	{
		$ratio_x = floatval($ratio_x);
		$ratio_y = floatval($ratio_y);
		$this->resize($this->width * $ratio_x, $this->height * $ratio_y);
	}

	function resize_ratio_x ($ratio_x)
	{
		$ratio_x = floatval($ratio_x);
		$this->resize($this->width * $ratio_x, $this->height);
	}

	function resize_ratio_y ($ratio_y)
	{
		$ratio_y = floatval($ratio_y);
		$this->resize($this->width, $this->height * $ratio_y);
	}

	function resize_width ($width)
	{
		$width = floatval($width);
		$this->resize($width, $width / $this->width * $this->height);
	}

	function resize_height ($height)
	{
		$height = floatval($height);
		$this->resize($height / $this->height * $this->width, $height);
	}

	function crop ($src_x, $src_y, $w, $h)
	{
		$src_x = round($src_x);
		$src_y = round($src_y);
		$w = round($w);
		$h = round($h);

		$this->width = ($w <= 1) ? 1 : $w;
		$this->height = ($h <= 1) ? 1 : $h;

		array_unshift($this->opqueue, "crop|$src_x|$src_y|{$this->width}|{$this->height}");
	}

	function pasteimage ($file, $src_x, $src_y, $opacity = 0)
	{
		$src_x = round($src_x);
		$src_y = round($src_y);

		$opacity = round($opacity);
		$opacity < 0 && ($opacity = 0);
		$opacity > 100 && ($opacity = 100);

		array_unshift($this->opqueue, "pasteimage|$file|$src_x|$src_y|$opacity");
		return true;
	}

	function rotate_90 ($ccw = false)
	{
		$tmp = $this->width;
		$this->width = $this->height;
		$this->height = $tmp;

		array_unshift($this->opqueue, "rotate|" . ($ccw ? "" : "-") . "90");
	}

	function rotate_180 ()
	{
		array_unshift($this->opqueue, "rotate|180");
	}

	function rotate_270 ($ccw = false)
	{
		$tmp = $this->width;
		$this->width = $this->height;
		$this->height = $tmp;

		array_unshift($this->opqueue, "rotate|" . ($ccw ? "" : "-") . "270");
	}

	function flip_horizontal ()
	{
		array_unshift($this->opqueue, "flip|h");
	}

	function flip_vertical ()
	{
		array_unshift($this->opqueue, "flip|v");
	}

	function fill_buffer ($imgtype, $resample, $jpegquality = 75)
	{
		if (
			!function_exists('imagecreatetruecolor') ||
			!function_exists('imagecopyresized') ||
			!function_exists('imagecopyresampled') ||
			!function_exists('imagecopy') ||
			!function_exists('imagecopymerge') ||
			!function_exists('imagerotate') ||
			!function_exists('imagedestroy')
		) {
			$this->errmsgs[] = "fill_buffer(): no gd support";
			return IR_E_NO_GD_SUPPORT;
		}

		if (!$this->source) {
			$this->errmsgs[] = "fill_buffer(): no assigned file";
			return IR_E_NO_ASSIGNED_FILE;
		}

		switch (trim(strtolower($imgtype))) {
			case 'gif':
				if (!function_exists($outfunc = 'imagegif')) {
					$this->errmsgs[] = "fill_buffer(): function imagegif() doesn't exist";
					return IR_E_OUTFUNC_NOT_EXISTS;
				}
				$this->mime = 'image/gif';
				break;

			case 'jpg':
			case 'jpeg':
				if (!function_exists($outfunc = 'imagejpeg')) {
					$this->errmsgs[] = "fill_buffer(): function imagejpeg() doesn't exist";
					return IR_E_OUTFUNC_NOT_EXISTS;
				}
				$this->mime = 'image/jpeg';
				break;

			case 'png':
				if (!function_exists($outfunc = 'imagepng')) {
					$this->errmsgs[] = "fill_buffer(): function imagepng() doesn't exist";
					return IR_E_OUTFUNC_NOT_EXISTS;
				}
				$this->mime = 'image/png';
				break;

			case 'wbmp':
				if (!function_exists($outfunc = 'imagewbmp')) {
					$this->errmsgs[] = "fill_buffer(): function imagewbmp() doesn't exist";
					return IR_E_OUTFUNC_NOT_EXISTS;
				}
				$this->mime = 'image/vnd.wap.wbmp';
				break;

			default:
				$this->errmsgs[] = "fill_buffer(): unsupported output format";
				return IR_E_OUTPUT_FORMAT_UNSUPPORTED;
		}

		$resample = $resample ? 1 : 0;
		$this->buffer = '';

		if ($this->caching) {
			$tmp = md5_file($this->source) . $resample . $jpegquality . $imgtype;

			foreach ($this->opqueue as $op)
				$tmp .= $op;

			$checksum = md5($tmp);
			unset($tmp);
			$query = mysql_query("SELECT `id`, `contents` FROM `" . IR_CACHETABLE . "` WHERE `checksum`='$checksum'");

			if (@mysql_num_rows($query)) {
				list($id, $this->buffer) = mysql_fetch_row($query);
				mysql_query("UPDATE `" . IR_CACHETABLE . "` SET `date`=" . time() . " WHERE `id`=$id");
				unset($id);
				$this->opqueue = array();
			}
		}

		if (!$this->buffer) {
			$sizefunc = $resample ? 'imagecopyresampled' : 'imagecopyresized';
			$img = $this->createfuncs[$this->type]($this->source);

			while ($op = array_pop($this->opqueue)) {
				$op = explode("|", $op);

				switch ($op[0]) {
					case 'resize':
						$w_new = intval($op[1]);
						$h_new = intval($op[2]);
						$w_old = imagesx($img);
						$h_old = imagesy($img);
						$img_tmp = imagecreatetruecolor($w_new, $h_new);
						$sizefunc($img_tmp, $img, 0, 0, 0, 0, $w_new, $h_new, $w_old, $h_old);
						$img = $img_tmp;
						break;

					case 'crop':
						$src_x = intval($op[1]);
						$src_y = intval($op[2]);
						$w_new = intval($op[3]);
						$h_new = intval($op[4]);
						$img_tmp = imagecreatetruecolor($w_new, $h_new);
						imagecopy($img_tmp, $img, 0, 0, $src_x, $src_y, $w_new, $h_new);
						$img = $img_tmp;
						break;

					case 'pasteimage':
						$file = $op[1];

						if (!(list($w, $h, $type) = @getimagesize($file)))
							break;

						if (!array_key_exists($type, $this->createfuncs) || !function_exists($this->createfuncs[$type]))
							break;

						$img_tmp = $this->createfuncs[$type]($file);
						imagecopymerge($img, $img_tmp, intval($op[2]), intval($op[3]), 0, 0, $w, $h, 100 - intval($op[4]));
						break;

					case 'rotate':
						$img = imagerotate($img, floatval($op[1]), 1);
						break;

					case 'flip':
						$w = imagesx($img);
						$h = imagesy($img);
						$img_tmp = imagecreatetruecolor($w, $h);
						$i = -1;

						if ($op[1] == 'h') {
							while (++$i < $w)
								imagecopy($img_tmp, $img, $w - $i - 1, 0, $i, 0, 1, $h);
						}
						else while (++$i < $h) {
							imagecopy($img_tmp, $img, 0, $h - $i - 1, 0, $i, $w, 1);
						}

						$img = $img_tmp;
						break;
				}
			}

			ob_start();
			strcmp($outfunc, 'imagejpeg') ? $outfunc($img) : imagejpeg($img, '', intval($jpegquality));
			$this->buffer = ob_get_clean();
			imagedestroy($img);

			if ($this->caching)
				mysql_query("INSERT INTO `" . IR_CACHETABLE . "` VALUES (NULL, '$checksum', '" . addslashes($this->buffer) . "', " . time() . ")");
		}
		return IR_E_OK;
	}

	function flush_buffer ($output, $outfile = '')
	{
		if (!$this->buffer) {
			$this->errmsgs[] = "flush_buffer(): buffer not ready";
			return IR_E_BUFFER_NOT_READY;
		}

		if ($outfile) {
			if (!($fd = @fopen($outfile, 'wb'))) {
				$this->errmsgs[] = "flush_buffer(): file is not writeable";
				return IR_E_FILE_NOT_WRITEABLE;
			}
			fwrite($fd, $this->buffer);
			fclose($fd);
		}

		if ($output) {
			header("Content-Type: {$this->mime}");
			echo $this->buffer;
		}
		return IR_E_OK;
	}

	function last_error ()
	{
		return @$this->errmsgs[sizeof($this->errmsgs) - 1];
	}

	function clear_cache ($limit = false)
	{
		mysql_query($limit ? "DELETE FROM `" . IR_CACHETABLE . "` WHERE `date` <= " . intval($limit) : "TRUNCATE TABLE `" . IR_CACHETABLE . "`");
	}

	function set_caching ($value)
	{
		$this->caching = (bool)$value;
	}
}

?>
