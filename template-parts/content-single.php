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
	<div class="post-grid_wrapper">
		<header class="entry-header">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<div class="entry-meta">
				<?php
					kamome_note_tag_and_category( array(
						'post' => $post,
						'class' => 'meta-element',
						'echo_tags' => false,
						'echo_categories' => true
					) );
					kamome_note_posted_on( array(
						'post' => $post,
						'class' => 'meta-element',
						'echo_time' => true,
						'echo_author' => false
					) );
				?>
			</div><!-- .entry-meta -->
			<?php kamome_note_post_thumbnail( $post ); ?>
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
			<?php
				kamome_note_tag_and_category( array(
					'post' => $post,
					'class' => 'meta-element',
					'echo_tags' => true,
					'echo_categories' => false
				) );
			?>
			<h4>同義とされたカテゴリー</h4>
			<?php
				echo get_the_term_list_synonymously( $post->ID, 'category', '', ', ', '' );
			?>

			<h4>同義とされたタグ</h4>
			<?php
				echo get_the_term_list_synonymously( $post->ID, 'post_tag', '', ', ', '' );
			?>
		</footer><!-- .entry-footer -->

	</div>
</article><!-- #post-## -->
