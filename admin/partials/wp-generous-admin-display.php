<?php

/**
 * General settings display.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/admin/partials
 */
?>

<div class="wrap">

	<h2>Generous</h2>

	<p class="description">
	Display Generous sliders on your website.
	</p>

	<form method="post" action="options.php">

		<?php settings_fields($page['option_group']); ?>
		<?php do_settings_sections($page['option_group']); ?>
		<?php submit_button(); ?>

	</form>

</div>