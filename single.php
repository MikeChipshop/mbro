<?php get_header(); ?>

<?php
	// If this is a case study
	if ( ! empty ( $GLOBALS['post'] )
		&& is_single()
		&& in_category( 'case-study', $GLOBALS['post'] )
	):
?>
	<article class="mb_work-single">
		<div class="mb_wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<header>
					<nav><a href="<?php bloginfo('url'); ?>" title="Back to home">Back to home</a></nav>
					<?php if(get_field('video_embed_code')): ?>
						<div class="mb_work-single-hero-video">
							<iframe src="https://player.vimeo.com/video/<?php the_field('video_embed_code'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
					<?php else: ?>
						<div class="mb_work-single-hero">
							<?php the_post_thumbnail('full'); ?>
							<h1><?php the_title(); ?></h1>
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
					<?php if(get_field('what_the_client_said')): ?>
						<div class="mb_read-more-button">
							<button>What the client said</button>
						</div>
						<div class="mb_read-more-content rte">
							<?php the_field('what_the_client_said'); ?>
						</div>
					<?php endif; ?>
					<?php if( have_rows('case_image_grid_items') ): ?>
						<div class="mb_image-grid">
							<ul>
								<?php while ( have_rows('case_image_grid_items') ) : the_row(); ?>
									<li>
										<?php
											$attachment_id = get_sub_field('case_image_grid_item');
											$size = "large";
											$image = wp_get_attachment_image_src( $attachment_id, $size );
										?>
										<img src="<?php echo $image[0] ?>" alt="">
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<aside>
					<?php if( have_rows('sidebar_section') ): ?>
					<div class="mb_single-video-credit-repeater">
						<ul>
							<?php while ( have_rows('sidebar_section') ) : the_row(); ?>
								<li>
									<h3><?php the_sub_field('item_title'); ?></h3>
									<h4><?php the_sub_field('item_content'); ?></h4>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php endif; ?>
					<?php if(get_field('sidebar_brand_logo')): ?>
						<div class="mb_single-video-credit-logo">
							<?php
								$attachment_id = get_field('sidebar_brand_logo');
								$size = "medium";
								$image = wp_get_attachment_image_src( $attachment_id, $size );
							?>
							<img src="<?php echo $image[0] ?>" alt="Brand Image">
						</div>
					<?php endif; ?>
				</aside>
			</div>
		<?php endwhile; endif; ?>
		<div class="mb_wrap">
			<section class="mb_case-study-thumbs">
				<?php if( have_rows('case_study_thumbs_section') ): ?>
					<ul>
						<?php while ( have_rows('case_study_thumbs_section') ) : the_row(); ?>
							<li data-videocode="<?php the_sub_field('cs_thumbs_video_id'); ?>" class="mb_case-study-thumb-item">
									<?php
										$attachment_id = get_sub_field('case_study_image');
										$size = "home-thumbs";
										$image = wp_get_attachment_image_src( $attachment_id, $size );
									?>
									<img src="<?php echo $image[0] ?>" alt="Case Study Image">

								<div class="mb_work-overlay">
									<h2><strong class="mb_work-thumb-news-cat"><?php the_sub_field('thumb_title'); ?></strong></h2>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
				<?php endif; ?>
			</section>
		</div>
	</article>
	<div class="mb_popup-video-wrap">
		<div class="mb_popup-video-cont">
			<button class="mb_close-popup">X</button>
			<div class="mb_popup-video-cont">
			<div class="mb_popup-video"></div>
			</div>
		</div>
	</div>
<?php
	// If this is a news page
	elseif ( ! empty ( $GLOBALS['post'] )
		&& is_single()
		&& in_category( 'news', $GLOBALS['post'] )
	):
?>
	<article class="mb_work-single mb_category-news">
		<div class="mb_wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<header>
					<nav><a href="<?php bloginfo('url'); ?>" title="Back to home">Back to home</a></nav>
					<?php if(get_field('video_embed_code')): ?>
						<div class="mb_work-single-hero-video">
							<iframe src="https://player.vimeo.com/video/<?php the_field('video_embed_code'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						</div>
					<?php else: ?>
						<div class="mb_work-single-hero">
							<?php the_post_thumbnail('full'); ?>
							<h1><?php the_title(); ?></h1>
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

				</div>
				<aside>
					<?php if( have_rows('sidebar_section') ): ?>
					<div class="mb_single-video-credit-repeater">
						<ul>
							<?php while ( have_rows('sidebar_section') ) : the_row(); ?>
								<li>
									<h3><?php the_sub_field('item_title'); ?></h3>
									<h4><?php the_sub_field('item_content'); ?></h4>
								</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php endif; ?>
				</aside>
			</div>
		<?php endwhile; endif; ?>

			<?php if( have_rows('custom_news_blocks') ): ?>
				<div class="mb_news-customs">
					<?php while ( have_rows('custom_news_blocks') ) : the_row(); ?>
						<?php if( get_row_layout() == 'text_block' ): ?>
							<div class="mb_custom-text-block rte">
								<?php the_sub_field('custom_text_block'); ?>
							</div>
						<?php elseif( get_row_layout() == 'video_block' ): ?>
							<div class="mb_video_block">
								<?php if(get_sub_field('video_source') == 'vimeo'): ?>
									<iframe src="https://player.vimeo.com/video/<?php the_sub_field('custom_video_block'); ?>?loop=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								<?php else: ?>
									<iframe src="https://www.youtube.com/embed/<?php the_sub_field('custom_video_block_yt'); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								<?php endif; ?>
							</div>
						<?php elseif( get_row_layout() == 'large_image' ): ?>
							<div class="mb_custom-large-image">
								<?php
									$attachment_id = get_sub_field('custom_large_image');
									$size = "banners";
									$image = wp_get_attachment_image_src( $attachment_id, $size );
								?>
								<img src="<?php echo $image[0] ?>" alt="">
							</div>


						<?php elseif( get_row_layout() == 'thumbs_section' ): ?>
							<?php if( have_rows('thumbs_section_items') ): ?>
								<div class="mb_case-study-thumbs">
									<ul>
										<?php while ( have_rows('thumbs_section_items') ) : the_row(); ?>
											<li data-videocode="<?php the_sub_field('thumbs_section_video_id'); ?>" class="mb_case-study-thumb-item">
													<?php
														$attachment_id = get_sub_field('thumbs_section_image');
														$size = "home-thumbs";
														$image = wp_get_attachment_image_src( $attachment_id, $size );
													?>
													<img src="<?php echo $image[0] ?>" alt="<?php the_sub_field('thumbs_section_title'); ?>">

												<div class="mb_work-overlay">
													<h2><strong class="mb_work-thumb-news-cat"><?php the_sub_field('thumbs_section_title'); ?></strong></h2>
												</div>
											</li>
										<?php endwhile; ?>
									</ul>
								</div>
							<?php endif; ?>



						<?php elseif( get_row_layout() == 'two_column_text' ): ?>
							<div class="mb_two-column-text">
								<div class="mb_fc-column-one rte">
									<?php the_sub_field('custom_two_column_block_one'); ?>
								</div>
								<div class="mb_fc-column-two rte">
									<?php the_sub_field('custom_two_column_block_two'); ?>
								</div>
							</div>
						<?php elseif( get_row_layout() == 'image_grid' ): ?>
							<div class="mb_image-grid">
								<?php if( have_rows('image_grid_items') ): ?>
									<ul>
										<?php while ( have_rows('image_grid_items') ) : the_row(); ?>
											<li>
												<?php
													$attachment_id = get_sub_field('image_grid_item');
													$size = "large";
													$image = wp_get_attachment_image_src( $attachment_id, $size );
												?>
												<img src="<?php echo $image[0] ?>" alt="">
											</li>
										<?php endwhile; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
	</article>
	<div class="mb_popup-video-wrap">
		<div class="mb_popup-video-cont">
			<button class="mb_close-popup">X</button>
			<div class="mb_popup-video-cont">
			<div class="mb_popup-video"></div>
			</div>
		</div>
	</div>

<?php
	// If this is a standard default page
	else:
?>
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

<?php endif; ?>
<?php get_footer(); ?>
