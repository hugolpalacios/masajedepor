<?php
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$cat_class = mpd_get_category_class( get_the_ID() );
	$cat_label = mpd_get_category_label( get_the_ID() );
	?>
	<article <?php post_class(); ?>>
		<div class="article-head">
			<?php if ( $cat_label ) : ?>
				<span class="cat <?php echo esc_attr( $cat_class ); ?>"><span class="dot"></span><?php echo esc_html( $cat_label ); ?></span>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="deck"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/author-block' ); ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<div class="article-body">
			<?php the_content(); ?>
		</div>

		<?php get_template_part( 'template-parts/sources-block' ); ?>
	</article>

	<?php get_template_part( 'template-parts/related-notes' ); ?>
	<?php
endwhile;

get_footer();
