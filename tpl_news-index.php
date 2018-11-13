<?php /* Template Name: News Index */ ?>
<?php get_header(); ?>
<section class="mb_home-work">
	<div class="mb_wrap">
		<header class="mbro2_news-page-header">
			<h1 class="mb_home-section-title">Case Studies &amp; News</h1>
			<nav class="mbro2_news-back"><a href="<?php bloginfo('url'); ?>" title="Back to home">Back to home</a></nav>
		</header>
		<div class="mb_home-work-showcase">
			<button>Filters</button>
			<div class="mb_home-work-filters">
				<h2>Case Studies &amp; News</h2>
				<ul>
					<?php
						$terms = get_terms( 'industry' );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
							foreach ( $terms as $term ) {
								?>
								<!-- <li><a href="#" class="mb_rearrange-loop" data-slug="<?php echo $term->taxonomy; ?>-<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li> -->
								<?php
							}
						}
                    ?>
                    <li><a href="<?php bloginfo('url'); ?>/case-studies-news/">All</a></li>
                    <li><a href="#" class="mb_rearrange-loop-news-index" data-slug="category-case-study">Case Studies</a></li>
                    <li><a href="#" class="mb_rearrange-loop-news-index" data-slug="category-news">News</a></li>
				</ul>
			</div>
			<div class="mb_home-work-videos">
                <?php
                        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
						$videoargs = array(
							'post_type' => array( 'post' ),
							'posts_per_page'=> 20,
                            'paged' => $paged,
						);

						$videoloop = new WP_Query( $videoargs );
						if ( $videoloop->have_posts() ) :
				?>
					<ul>
						<?php while ( $videoloop->have_posts() ) : $videoloop->the_post(); ?>

								<li <?php post_class(); ?>>
									<a href="<?php the_permalink(); ?>">
										<?php if(has_post_thumbnail()): ?>
											<?php if(in_category( 'case-study')): ?>
												<!-- Load custom wide image -->
												<?php if(get_field('front_page_wide_image')): ?>
													<?php
														$attachment_id = get_field('front_page_wide_image');
														$size = "wide-front";
														$image = wp_get_attachment_image_src( $attachment_id, $size );
													?>
													<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>">
												<?php else: ?>
													<?php the_post_thumbnail('wide-front'); ?>
												<?php endif; ?>
											<?php elseif(in_category( 'news')): ?>
												<!-- Load custom wide image -->
												<?php if(get_field('front_page_wide_image')): ?>
													<?php
														$attachment_id = get_field('front_page_wide_image');
														$size = "wide-front";
														$image = wp_get_attachment_image_src( $attachment_id, $size );
													?>
													<img src="<?php echo $image[0] ?>" alt="<?php the_title(); ?>">
												<?php else: ?>
													<?php the_post_thumbnail('wide-front'); ?>
												<?php endif; ?>
											<?php else: ?>
												<?php the_post_thumbnail('home-thumbs'); ?>
											<?php endif; ?>
										<?php else: ?>
											<img src="<?php bloginfo('stylesheet_directory'); ?>/img/no-image.png" alt="No image available currently">
										<?php endif; ?>
										<div class="mb_work-overlay">
										<h2>
											<strong class="mb_work-thumb-news-cat">
												<?php
													foreach((get_the_category()) as $category) {
														echo $category->cat_name . ' ';
													}
												?>
											</strong>
											<?php if(in_category( 'case-study')): ?>
												<?php if(get_field('thumbnail_custom_title')): ?>
													<?php the_field('thumbnail_custom_title'); ?>
												<?php else: ?>
													<?php the_title(); ?>
												<?php endif; ?>
											<?php else: ?>

												<?php if(get_field('thumbnail_overlay_title')): ?>
													<strong><?php the_field('thumbnail_overlay_title'); ?></strong>
													<?php the_field('thumbnail_overlay_content'); ?>
												<?php else: the_title(); ?>
												<?php endif; ?>

											<?php endif; ?>
										</h2>
									</div>
									</a>

								</li>
						<?php endwhile; ?>
                    </ul>
                    <div class="mbro2_pagination">
                    <nav>
                    <?php
                    $big = 999999999; // need an unlikely integer
 echo paginate_links( array(
    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $videoloop->max_num_pages
) ); ?>


                    </nav>
				    </div>
				<?php endif; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
