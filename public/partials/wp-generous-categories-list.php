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

<ul class="generous-categories">

	<?php while( wp_generous_have_categories() ): ?>
		
		<?php wp_generous_the_content(); ?>

	<?php endwhile; ?>

</ul>