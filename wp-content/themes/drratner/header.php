<?php
$body_classes = get_body_class();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">

	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri();?>/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri();?>/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri();?>/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_template_directory_uri();?>/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?php echo get_template_directory_uri();?>/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#b91d47">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>

	<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>


	<script>
		window.WP_AJAX_URL = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
</head>
<body class="body">

<header>
	<div class="header-content d-flex align-items-center justify-content-between">
		<a class="logo-link" href="/">
			<img
				src="<?php the_field('header_logo', 'options'); ?>"
				alt="Exceptional Dentistry Logo" 
			/>
		</a>
		<div class="nav">
			<ul>
				<?php if( have_rows('header_nav', 'options') ): ?>
					<?php while ( have_rows('header_nav', 'options') ) : the_row(); ?>
						<li class="nav-item">
							<div class="nav-heading"><?php the_sub_field('nav_heading') ?></div>

							<?php if( have_rows('children') ): ?>
								<ul class="nav-children">
									<?php while ( have_rows('children') ) : the_row(); ?>
										<?php
											$post_object = get_sub_field('post');

											if( $post_object ): 

												// override $post
												$post = $post_object;
												setup_postdata( $post ); 
										?>
												<li class="nav-child"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
										<?php 
												wp_reset_postdata();
											endif;
										?>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
		
		<div class="header-right">
			<div class="address">
				<div><?php the_field('address_line_1', 'options'); ?></div>
				<div><?php the_field('address_line_2', 'options'); ?></div>
			</div>
		</div>

	</div>


</header>
