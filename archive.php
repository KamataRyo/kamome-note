<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kamome-note
 */

get_header();
?>



<div class="contents-grid_wrapper <?php echo KAMOME_NOTE_BOOTSTRAP_GRID_OF_MAIN_COL; ?>">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="text-center">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php $stickies = array(); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 kamome_note_abbr_post( $post );
						 if ( is_sticky( $post->ID ) ) {
							 array_push( $stickies, $post->ID );
						 };
					?>
				<?php endwhile; ?>
				<?php kamome_note_load_more_navigation( $stickies ); ?>
				<?php /* finish the Loop */ ?>


			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>

			</div><!--.text-center-->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!--.col-->


<?php
get_sidebar();
get_footer();
