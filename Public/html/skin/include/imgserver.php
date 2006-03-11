<?php

/*********************************************************************
 *                                                                   *
 *    Image Resizer - a handy PHP class for image resizing           *
 *   _____________________________________________________________   *
 *                                                                   *
 *           FILE :  imgserver.php                                   *
 *           DATE :  February 04, 2006                               *
 *       CODED BY :  Blagovest Buyukliev <hitman@bootbox.net>        *
 *   REQUIREMENTS :  GD2 Extension                                   *
 *        LICENSE :  Absolutely Free; You can send me donations :)   *
 *                                                                   *
 ********************************************************************/

require 'class.resizer.php';

// Instantiate our class
$img = new resizer;

// Oh God, I hate typing $_REQUEST all the time!
$R = &$_REQUEST;

// If a file was given,
if (isset($R['file']))
{
	// The first thing we need to do is to set the target file
	$result = $img->setfile($R['file']);

	// Catch errors, if any
	switch ($result) {
		case IR_E_URL_NOT_READABLE:
			die("Couldn't open URL because allow_url_fopen is off");

		case IR_E_FILE_NOT_EXISTS:
			die("Specified file doesn't exist.");

		case IR_E_FORMAT_UNSUPPORTED:
			die("Unsupported image format. Supported formats are GIF, JPEG and PNG.");

		case IR_E_CREATEFUNC_NOT_EXISTS:
			die("Your PHP environment doesn't have the appropriate function to read this format. Here is the error: \"" . $img->last_error() . "\"");

		case IR_E_INVALID_IMAGE:
			die("The specified file is not a valid image.");
	}
}
else die("No file specified.");

// Set caching
// Caching effectively improves performance if the same images are viewed many times!
if (isset($R['cache']) && !$R['cache'])
	$img->set_caching(false);
else {
	// In order to cache already resized images, you need a connection to a MySQL database.
	// Put your db details here:
	@mysql_connect('', '', '')
		or die("Warning: couldn't start caching because of a problem with the database connection.");

	@mysql_select_db('')
		or die("Warning: couldn't start caching because the specified database cannot be selected.");

	// It is required that you create the table in cachetable.sql!

	$img->set_caching(true);

	// Randomly clear the cache
	if (mt_rand(1, 32) == 1) {
		// With this call to clear_cache() we clear all cached
		// images that haven't been used for more than 3 days:
		$img->clear_cache(time() - 3 * 24 * 3600);
		// We could also call it like that: $img->clear_cache()
		// In this way it would clear the entire cache.
	}
}

// Do the resizing work
if (isset($R['ratio'])) {
	// Resize by a given resize ratio, keeping the aspect.
	// For example, a ratio of 0.5 makes the image
	// two times smaller and a ratio of 2.0 makes
	// the image two times bigger.
	$img->resize_ratio($R['ratio']);
} elseif (isset($R['ratio_x']) && isset($R['ratio_y'])) {
	// Resize by a X and an Y ratio, without keeping the aspect.
	// For example, $img->resize_ratio_xy(2.0, 0.5) makes the
	// image two times wider and halves the height.
	$img->resize_ratio_xy($R['ratio_x'], $R['ratio_y']);
} elseif (isset($R['ratio_x'])) {
	// Resize by a X ratio, without keeping the aspect.
	// For example, $img->resize_ratio_x(2.0) makes the
	// image two times wider.
	$img->resize_ratio_x($R['ratio_x']);
} elseif (isset($R['ratio_y'])) {
	// Resize by an Y ratio, without keeping the aspect.
	// For example, $img->resize_ratio_y(2.0) makes the
	// image two times higher.
	$img->resize_ratio_y($R['ratio_y']);
} elseif (isset($R['width']) && isset($R['height'])) {
	// Resize directly with a given new width and height
	$img->resize($R['width'], $R['height']);
} elseif (isset($R['width'])) {
	// Resize by a given new width. The height will
	// be adjusted corresponding to the aspect.
	$img->resize_width($R['width']);
} elseif (isset($R['height'])) {
	// Resize by a given new height. The width will
	// be adjusted corresponding to the aspect.
	$img->resize_height($R['height']);
} elseif (isset($R['reg_w']) && isset($R['reg_h'])) {
	// Resize to best fit a given region, keeping the aspect.
  	$img->resize_fit_region($R['reg_w'], $R['reg_h'], isset($R['enlarge']) ? $R['enlarge'] : false);
}

// Do rotation, if necessary
if (isset($R['rot'])) {
	$counter_cw = isset($R['ccw']) ? (bool)$R['ccw'] : false;

	switch ($R['rot']) {
		case '90':
			// Rotate by 90 degrees. The optional argument
			// specifies the direction
			$img->rotate_90($counter_cw);
			break;

		case '180':
			// Rotate by 180 degrees
			$img->rotate_180();
			break;

		case '270':
			// Rotate by 270 degrees. The optional argument
			// specifies the direction
			$img->rotate_270($counter_cw);
			break;
	}
}

// Do flipping, if necessary
if (isset($R['flip'])) {
	if ($R['flip'] == 'h')
		$img->flip_horizontal();
	elseif ($R['flip'] == 'v')
		$img->flip_vertical();
}

// -------------------------------------------------------------
// There is also a function for pasting other images over the
// target image. For example, you can use this if you want to
// have your site's logo over the image. The prototype is:
//
//   $obj->pasteimage(filename, position_x, position_y[, opacity_level])
//   opacity_level may vary from 0 to 100, default is 0
//
// Another function allows cropping. The prototype is:
//
//   $obj->crop(position_x, position_y, width, height)
// -------------------------------------------------------------

// Render the resulting image
// fill_bufer() takes 3 arguments:
//   - type of image to produce (can be 'gif', 'png', 'jpeg' or 'wbmp')
//   - whether to resample the image (true/false); resampling improves quality
//   - JPEG quality: this parameter is taken into consideration only when image type is jpeg
$result = $img->fill_buffer(
	isset($R['imgtype']) ? $R['imgtype'] : 'jpeg',
	isset($R['resample']) ? $R['resample'] : true,
	isset($R['jpegquality']) ? $R['jpegquality'] : 75
);

// Catch errors, if any
switch ($result) {
	case IR_E_NO_GD_SUPPORT:
		die("Some of the needed image functions are not available in your PHP environment.");

	case IR_E_NO_ASSIGNED_FILE:
		die("There is not an assigned file with setfile()!");

	case IR_E_OUTFUNC_NOT_EXISTS:
		die("The PHP function for outputting this type of image is not available.");

	case IR_E_OUTPUT_FORMAT_UNSUPPORTED:
		die("The specified output format is not supported. Supported formats are GIF, JPEG and PNG.");
}

// Output/Write the resulting image
// flush_buffer() takes 2 arguments:
//   - whether to output to the browser (true/false);
//   - the second argument is optional; here you can specify an
//     external file where to save the resized image
$result = $img->flush_buffer(
	isset($R['output']) ? $R['output'] : true,
	isset($R['outfile']) ? $R['outfile'] : ''
);

// Catch errors, if any
switch ($result) {
	case IR_E_BUFFER_NOT_READY:
		die("Buffer is not ready.");

	case IR_E_FILE_NOT_WRITEABLE:
		die("The specified output file is not writeable.");
}

// I hope that was a pretty straightforward guide! Happy Coding!

?>
