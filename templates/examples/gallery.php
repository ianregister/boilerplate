<?php $images = get_field('gallery'); ?>

<?php if( $images ): ?>

<div class="slideshow">
	<div id="carousel" class="flexslider">
		<ul class="slides">


<?php

foreach ($images as $image) {

	//$image_loading = get_template_directory_uri().'/images/img/grey.gif';
	$image_loading = $image['sizes']['large'];
	$image_normal = $image['sizes']['slide'];
	$image_retina = $image['sizes']['slide@2x'];
?>
			<li>
				<img src="<?php echo $image_loading; ?>"
					 data-src="<?php echo $image_normal; ?>"
					 data-src-retina="<?php echo $image_retina; ?>"
					 class="unveil"
					 alt="<?php the_title(); ?>" 
					 title="<?php the_title(); ?>"
					 width="1020" 
					 height="680"/>
			</li>
<?php } ?>
		</ul>
	</div>
<div class="slideshow">


<?php endif; ?>
