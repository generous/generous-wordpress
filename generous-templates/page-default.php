<?php

/**
 * Template Name: Generous Page - Default
 *
 * The default page.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/generous-templates
 */
?>
<?php get_header(); ?>

    <main role="generous-store">

        <section>

            <h1><?php the_title(); ?></h1>

            <?php echo do_shortcode('[generous store]'); ?>

        </section>

    </main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
