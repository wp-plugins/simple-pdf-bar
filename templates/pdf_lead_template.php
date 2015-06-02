<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
	<head>
		<?php wp_head(); ?>
		<?php
			$css_style = plugins_url( '/css/style.css',  dirname(__FILE__));
			$js_script = plugins_url( '/js/pdf-display.js',  dirname(__FILE__));
		?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $css_style; ?>">
		<script type='text/javascript' src='<?php echo $js_script; ?>'></script>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<script type="text/javascript"> 
			//Use native pdf-reader for mobile devices
			var windowWidth = window.innerWidth;
				// <![CDATA[
			  if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || windowWidth < 600 || (navigator.userAgent.indexOf('iPad') != -1)) {
			  document.location = <?php $filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true ); if(!empty($filearray)){ $pdf_file = $filearray['url']; if($pdf_file != ""){ echo "'" . $pdf_file . "'"; }}?>;
			  } // ]]>
		</script>
	</head>
	<body class='bar-<?php $location_of_bar = get_post_meta( get_the_ID(), 'meta-radio', true ); echo $location_of_bar ?>'>
		<?php the_content(); ?>
	</body>
</html>