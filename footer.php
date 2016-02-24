<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kamome-note
 */

?>
			</div><!--.row-->
		</div><!-- #content -->
	</div><!--container-->

	<footer id="colophon" class="site-footer text-center" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'kamome-note' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'kamome-note' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php
				printf( esc_html__( 'Theme: %1$s by %2$s DIYed from %3$s.', 'kamome-note' ),
					'kamome-note',
					'<a href="https://github.com/KamataRyo/" rel="designer">kamataryo</a>',
					'<a href="http://underscores.me/" rel="designer">_s</a>'
				);
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
