<?php get_header(); ?>
<article class="mb_default-page">
	<div class="mb_wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<header>
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="rte">
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>
	</div>
</article>
<?php get_footer(); ?>