<?php

/**
 * General category slider item template.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public/partials
 */
?>

<a class="generous-sliders-item" href="<?php wp_generous_the_permalink(); ?>">
	<div class="cover-photo">
		<img src="[cover_photo]" />
	</div>
	<div class="title">
		[title]
	</div>
	<div class="suggested-price">
		[suggested_price]
	</div>
</a>