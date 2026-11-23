<?php
/**
 * News card used on the home page and news listings.
 *
 * @package Bradley_Industrial
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card' ); ?>>
	<a class="news-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'bi-card', array( 'loading' => 'lazy', 'alt' => '' ) );
		}
		?>
	</a>
	<h3 class="news-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="news-card__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
	<div class="news-card__excerpt"><?php the_excerpt(); ?></div>
</article>
