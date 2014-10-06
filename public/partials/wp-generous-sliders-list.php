<?php

/**
 * General slider template.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public/partials
 */
?>

<div class="generous-sliders">

	<?php while( wp_generous_have_sliders() ): ?>

		<?php wp_generous_the_content(); ?>

	<?php endwhile; ?>
	
</div>