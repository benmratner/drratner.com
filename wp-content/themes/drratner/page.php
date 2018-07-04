<?php get_header(); ?>

<?php
// Start the loop.
while ( have_posts() ) : the_post();
?>

<div class="page-title-banner">
  <div class="container clearfix">
    <div class="pull-left page-category-title">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</div>

<section class="copy main-video-container-content">
  <div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php the_content(); ?>
			</div>
		</div>
  </div>
</section>

<?php
// End the loop.
endwhile;
?>

<?php get_footer(); ?>
