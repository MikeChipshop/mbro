<?php get_header(); ?>
<article class="mb_work-single">
	<div class="mb_wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<header>
				<h1><?php the_title(); ?></h1>
				<nav><a href="<?php bloginfo('url'); ?>" title="Back to home">Back to home</a></nav>
				<?php if(get_field('video_embed_code')): ?>
					<div class="mb_work-single-hero-video">
						<iframe src="https://player.vimeo.com/video/<?php the_field('video_embed_code'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					</div>
				<?php else: ?>
					<div class="mb_work-single-hero">
						<?php the_post_thumbnail('full'); ?>
					</div>
				<?php endif; ?>
			</header>
			<div class="mb_work-single-wrap">
				<div class="mb_work-single-content">
					<div class="mb_work-single-intro">
						<div class="rte">
							<?php the_content(); ?>
						</div>
					</div>
					<?php if(get_field('work_single_video_read_more_content')): ?>
						<div class="mb_read-more-button">
							<button>Read More</button>
						</div>
						<div class="mb_read-more-content rte">
							<?php the_field('work_single_video_read_more_content'); ?>
						</div>
					<?php endif; ?>					
				</div>
				<aside>
					<?php if( have_rows('work_single_video_credits') ): ?>
					<div class="mb_single-video-credit-repeater">
						<ul>
							<?php while ( have_rows('work_single_video_credits') ) : the_row(); ?>
								<li>
									<h3><?php the_sub_field('item_type'); ?></h3>
									<h4><?php the_sub_field('item_credit'); ?></h4>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>	
					<?php endif; ?>
					<?php if(get_field('work_single_video_brand_logo')): ?>
						<div class="mb_single-video-credit-logo">
							<?php 
								$attachment_id = get_field('work_single_video_brand_logo');
								$size = "medium";
								$image = wp_get_attachment_image_src( $attachment_id, $size );
							?>
							<img src="<?php echo $image[0] ?>" alt="Brand Image">
						</div>
					<?php endif; ?>	
				</aside>
			</div>
		<?php endwhile; endif; ?>
	</div>
</article>
<?php get_footer(); ?>