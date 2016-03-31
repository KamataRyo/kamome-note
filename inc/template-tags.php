<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package kamome-note
 */

if ( ! function_exists( 'kamome_note_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * $query = array(
 * 		post => post object
 *		echo_time => true
 *		echo_author => true
 * )
 */
function kamome_note_posted_on( $query ) {
	# parse query
	extract( array_merge( array(
		'class' => 'meta-element',
		'echo_time' => true,
		'echo_author' => true
	), $query ) );

	$class = esc_attr( $class );

	if ( $echo_time ) :
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( $post->post_date !== $post->post_modified ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c', $post->ID ) ),
			esc_html( get_the_date( get_option('date_format'), $post->ID ) ),
			esc_attr( get_the_modified_date( 'c', $post->ID ) ),
			esc_html( get_the_modified_date( get_option('date_format'), $post->ID ) )
		);

		$posted_on = '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" rel="bookmark">' . $time_string . '</a>';
		echo '<span class="posted-on ' . $class . '"><i class="post-meta glyphicon glyphicon-time"></i>' . $posted_on . '</span>'; // WPCS: XSS OK.
	endif;


	if ( $echo_author ) :
		$user_nicename = get_the_author_meta( 'user_nicename', $post->post_author );
		if ( $user_nicename !== '' ) {
			$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ) . '">' . esc_html( $user_nicename ) . '</a></span>';
			echo '<span class="byline ' . $class . '"><i class="post-meta glyphicon glyphicon-user"></i>' . $byline . '</span>'; // WPCS: XSS OK.
		}
	endif;

}
endif;


if ( ! function_exists( 'kamome_note_thumbnail' ) ) :
/**
 * Prints post thumbnail or noimage if not exist.
 */
function kamome_note_post_thumbnail( $post ) {
	if ( has_post_thumbnail( $post->ID ) ) {
		echo '<p class="post_thumbnail_wrapper">';
		echo get_the_post_thumbnail( $post->ID, '', array(
			'class' => 'post_thumbnail'
			#'class' => kamome_note_get_image_clip_class( get_attached_file( get_post_thumbnail_id( $post->ID ) ) )
		) );
		echo '</p>';
	} //else {
	// 	$class = kamome_note_get_image_clip_class( get_template_directory() . '/img/noimage.png');
	// 	echo '<img src="' . get_template_directory_uri() . '/img/noimage.png' . '" class="' . esc_attr( $class ) . '" alt="noimage" />';
	// }
}
endif;


if ( ! function_exists( 'kamome_note_tag_and_category' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function kamome_note_tag_and_category( $query ) {
	# parse query
	extract( array_merge( array(
		'class' => 'meta-element',
		'echo_tags' => true,
		'echo_categories' => true
	), $query ) );

	$class = esc_attr( $class );


	// Hide category and tag text for pages.
	$taxonomies = array();
	if ( $echo_tags ) {
		$taxonomies['post_tag'] = 'glyphicon glyphicon-tag';
	}
	if ( $echo_categories ) {
		$taxonomies['category'] = 'glyphicon glyphicon-folder-open';
	}

	if ( 'post' === $post->post_type ) {
		#$taxonomies = array( 'category', 'post_tag' );

		foreach ( $taxonomies as $taxonomy => $icon_class ) {
			$terms = wp_get_post_terms( $post->ID, $taxonomy);
			if ( empty( $terms ) ) {
				continue;
			}
			echo '<h3 class="taxonomy-title">' . get_taxonomy( $taxonomy)->label . '</h3>'; # xss ok
			printf('<i class="post-meta %s"></i>', $icon_class );
			echo "<ul class=\"taxonomy-list ${taxonomy} ${class}\">"; # xss ok
			foreach ( $terms as $term ) {
				echo '<li class="taxonomy-list-item"><a href="' . get_term_link( $term, $taxonomy) . '">';
				echo esc_html( $term->name );
				echo '</a></li>';
			}
			echo '</ul>';
		}
	}

	if ( ! is_single( $post ) && ! post_password_required( $post ) && ( comments_open( $post->ID ) || get_comments_number( $post->ID ) ) ) {
		$comments_num = ( int )get_comments_number( $post->ID );
		echo '<p class="comments-link ' . $class . '"><i class="post-meta glyphicon glyphicon-pencil"></i><a href="' . get_permalink( $post->ID ) . '#comments">'; # xss ok
		if ( $comments_num === 0 ) {
			echo esc_html__( 'Leave a comment', 'kamome-note' );
		} elseif ( $comments_num === 1 ) {
			echo esc_html__( '1 Comment', 'kamome-note' );
		} else {
			echo sprintf( esc_html__( '%d Comments', 'kamome-note' ), $comments_num );
		}
		echo '</a></p>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'kamome-note' ),
			'<span class="screen-reader-text">"' . $post->title . '"</span>'
		),
		'<span class="edit-link ' . $class . '"><i class="post-meta glyphicon glyphicon-wrench"></i>', # xss ok
		'</span>',
		$post->ID
	);
}
endif;




# generate load more button
function kamome_note_load_more_navigation( $stickies ) {

	$args = kamome_note_ajax_acceptable_queries();//defined in functions.php
	$query = array();
	//filter the query
	foreach ( $args as $arg ) {
		$var = get_query_var( $arg );
		if ( $var ) {
			$query[$arg] = get_query_var( $arg );
		}
	}
	if (! isset( $query['paged'] ) ) {
		$query['paged'] = 1;
	}

	global $wp_query;

	printf( '<p id="end-of-articles" data-query="%s">',esc_attr( json_encode ( $query ) ) );
	printf( '<input type="hidden" id="ids_of_stickies" value="%s">', json_encode( $stickies ) );
	printf( '<input type="hidden" id="published_posts" value="%s">', $wp_query -> found_posts );
	wp_nonce_field( KAMOME_NOTE_AJAX_LOAD_MORE_ACTION, 'ajax-nonce' , false, true );
	echo '</p>';
	echo '<div class="loadmore_wrapper">';
	printf('<a id="loadmore-button">%s</a>', esc_html__( 'LOAD MORE', 'kamome-note' ) );
	echo '</div>';
}

# indexページ用のpostサムネイルを出力
function kamome_note_abbr_post( $post ) {
	$thumbnail_class = has_post_thumbnail( $post->ID ) ? 'has-thumb' : 'no-thumb';
	// ?>
	<article id="post-<?php echo $post->ID; ?>" <?php post_class( 'post-grid_wrapper ' . $thumbnail_class, $post->ID ); ?>>
		<header class="entry-header" data-scroll-scope>
			<?php echo sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink( $post->ID ) ) ) . esc_html( $post->post_title ) . '</a></h2>'; ?>
			<?php if ( 'post' === $post -> post_type ) : ?>
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
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="img_wrapper">
			<?php kamome_note_post_thumbnail( $post ); ?>
		</div>
	</article><!-- #post-## -->
	<?php
}
