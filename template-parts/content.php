<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kamome-note
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid_wrapper' ); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<p><?php kamome_note_posted_on(); ?></p>
			<p><?php kamome_note_post_thumbnail(); ?></p>
			<p><?php kamome_note_tag_and_category(); ?></p>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
