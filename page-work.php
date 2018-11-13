<?php get_header(); ?>
<section class="mb_home-work">
	<div class="mb_wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 class="mb_home-section-title"><?php the_title(); ?></h1>
			<div class="mb_home-work-intro">
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>
		<div class="mb_home-work-showcase">
			<div class="mb_home-work-filters">
				<h2>Industry</h2>
				<ul>
					<li><a href="#">Music</a></li>
					<li><a href="#">Technology</a></li>
					<li><a href="#">Automotive</a></li>
					<li><a href="#">Charity</a></li>
					<li><a href="#">Education</a></li>
				</ul>
				
				<h2>Type</h2>
				<ul>
					<li><a href="#">Short Films</a></li>
					<li><a href="#">Brand Films</a></li>
					<li><a href="#">Documentary</a></li>
					<li><a href="#">Promo</a></li>
					<li><a href="#">Social Teasers</a></li>
				</ul>
			</div>
			<div class="mb_home-work-videos">
				<?php 
					$videoargs = array(
						'post_type' => 'videos',
						'posts_per_page'=> -1,
						'order'	=> 'RAND'
						); 

						$videoloop = new WP_Query( $videoargs );
						if ( $videoloop->have_posts() ) :
				?>
					<ul>
						<?php while ( $videoloop->have_posts() ) : $videoloop->the_post(); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-thumbs'); ?></a></li>
						<?php endwhile; ?>
					</ul>
				<?php endif; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>