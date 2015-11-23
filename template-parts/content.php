<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kamome-note
 */

?>


<?php
	global $kamome_note_loop_count;
	if ( $kamome_note_loop_count < 4 && has_post_thumbnail() ) {
		if ( $kamome_note_loop_count % 2 === 0) {
			$class_post_thumbnail = 'col-xs-6 pull-right';
			$class_entry = 'col-xs-6';
		} else {
			$class_post_thumbnail = 'col-xs-6 pull-left';
			$class_entry = 'col-xs-6';
		}
	} else {
		$class_post_thumbnail = 'col-xs-12';
		$class_entry = 'col-xs-12';
	}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="<?php echo $class_post_thumbnail; ?>">
			<?php
				if (has_post_thumbnail()) {
					the_post_thumbnail();
				}
			?>
		</div><!--.col-->

		<div class="<?php echo $class_entry; ?>">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php kamome_note_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
						<?php
							the_content( sprintf(
								/* translators: %s: Name of current post. */
								wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kamome-note' ), array( 'span' => array( 'class' => array() ) ) ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							) );
						?>

						<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kamome-note' ),
								'after'  => '</div>',
							) );
						?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php kamome_note_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div><!--.col-->
	</div><!--.row-->
</article><!-- #post-## -->
