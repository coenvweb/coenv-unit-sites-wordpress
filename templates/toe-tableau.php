<?php
/*
Template Name: TOE Tableau
*/
get_header(); ?>
<div class="row">
	<div class="small-12 large-12 columns" role="main">
	<?php do_action('foundationPress_before_content'); ?>
	<?php dynamic_sidebar("before-content"); ?>
	
	<?php /* Start loop */ ?>
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<section class="article__content">
				<h2><em>How is climate projected to change in the Northwest?</em></h2>
				<p><b>The visualization below shows projected changes in temperature and precipitation for 2 future time periods in 3 regions in the Pacific NW.</b></p>
				<script type='text/javascript' src='https://public.tableau.com/javascripts/api/viz_v1.js'></script>
				<div class='tableauPlaceholder'>
					<noscript>
						<a href='#'><img alt=' ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;cl&#47;climatevisualization&#47;Temperature&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz' width='982' height='745' style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='site_root' value='' /><param name='name' value='climatevisualization&#47;Temperature' /><param name='tabs' value='yes' /><param name='toolbar' value='no' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;cl&#47;climatevisualization&#47;Temperature&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='showVizHome' value='no' /><param name='showTabs' value='y' /><param name='bootstrapWhenNotified' value='true' /></object></div>
				<?php the_content() ?>
			</section>
		    <?php remove_filter( 'the_title', 'wptexturize' );
		    remove_filter( 'the_excerpt', 'wptexturize' ); ?>
		</article>
	<?php endwhile; // End the loop ?>
	<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
		<div id="after-content" class="after-content widget-area" role="complementary">
			<?php dynamic_sidebar( 'after-content' ); ?>
		</div><!-- #after-content -->
	<?php endif; ?>

	</div>
</div>
		
<?php get_footer(); ?>