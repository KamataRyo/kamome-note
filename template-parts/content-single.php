<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kamome-note
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title text-center">', '</h1>' ); ?>
		<p class="text-center"><?php kamome_note_post_thumbnail( $post ); ?></p>
		<div class="entry-meta">
			<?php kamome_note_posted_on( $post ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kamome-note' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<p><?php kamome_note_tag_and_category( $post ); ?></p>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
