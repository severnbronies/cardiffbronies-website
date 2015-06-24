<?php
	/*
		Template Name: Page - Home
	*/
	get_template_part('partials/global/html-header');
	get_template_part('partials/global/header');
	if(have_posts()):
		while(have_posts()): the_post(); 
			$home_blurb = get_the_content();
		endwhile;
	endif; 
	$meet_query_args = array(
		"post_type" => "meet",
		"orderby" => "meta_value_num",
		"order" => "ASC",
		"posts_per_page" => "3",
		"meta_key" => "meet_start_time",
		"meta_compare" => ">",
		"meta_value" => time()
	);
	$meet_query = new WP_Query($meet_query_args);
?>

	<main class="body" id="content" role="main">
		<?php 
			if($meet_query->have_posts()): 
				// print_r($meet_query);
		?>
		<div class="meet-grid meet-grid--items-<?php echo $meet_query->post_count; ?>">
			<div class="layout">
				<?php
					$index = 0;
					while($meet_query->have_posts()): $meet_query->the_post();
						if(has_post_thumbnail()):
							$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), "full");
							$image_url = $image_url[0];
						// elseif(strlen($custom_image_url = get_theme_mod("bb_homepage_banner_image")) > 0):
						// 	$image_url = $custom_image_url;
						else: 
							$image_url = "//placeponi.es/1280/720";
						endif; 
				?>
				<article class="meet-grid__item">
					<a class="meet-grid__link" href="<?php the_permalink(); ?>">
						<div class="meet-grid__image">
							<picture>
								<img srcset="<?php echo $image_url; ?>" alt="">
							</picture>
						</div>
						<div class="meet-grid__body">
							<h1 class="meet-grid__title"><?php the_title(); ?></h1>
							<span class="meet-grid__date"><?php echo bb_meet_dates(bb_custom_field('meet_start_time')); ?></span>
						</div>
					</a>
				</article>
				<?php
					endwhile;
				?>
			</div>
		</div>
		<?php 
			endif; 
		?>
	</main>

<?php
	get_template_part('partials/global/footer');
	get_template_part('partials/global/html-footer');
?>