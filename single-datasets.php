<?php get_header(); ?>
<div class="row">
	<div class="small-12 medium-8 large-9 columns" role="main">
			<div class="entry-content">
				<h1 class="article__title"><a href="/resources/data/cig-datasets/" title="CIG Datasets">CIG Datasets</a></h1>
				<?php 

				// Publication themes list
		$dataset_region = wp_get_post_terms($post->ID, 'dataset_region');
		if (!empty($dataset_region)) {
			$dataset_region_arr = array();

			foreach ($dataset_region as &$term) {
				$dataset_region_arr[] = '<a href="?tax=dataset_region&term=' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_region_str = implode(', ', $dataset_region_arr) . ', ';
			$dataset_region = "";
		} else {
			$dataset_region_str = '';
		}

		// Publication year list
		$dataset_type = wp_get_post_terms($post->ID, 'dataset_type');
		if (!empty($dataset_type)) {
			$dataset_type_arr = array();

			foreach ($dataset_type as &$term) {
				$dataset_type_arr[] = '<a href="?tax=dataset_type&term=' . $term->slug . '">' . $term->name . '</a>';
			}
			$dataset_type_str = implode(', ', $dataset_type_arr);
			$dataset_type = "";
		} else {
			$dataset_type_str = '';
		}

		$dataset_link = get_the_permalink();
		$rows = get_field('dataset_link');
		?>
		<div class="post-meta">
			<div class="terms">
        <?php
		echo $dataset_region_str . $dataset_type_str;

		echo '</div>'; ?>
	</div>






			<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'datasets' ) ?>

					<?php endwhile ?>

			<?php endif ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
				<p><?php the_tags(); ?></p>
			</footer>
			<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
				<div id="after-content" class="after-content widget-area" role="complementary">
					<?php dynamic_sidebar( 'after-content' ); ?>
				</div><!-- #after-content -->
			<?php endif; ?>
		</article>	
	<?php do_action('foundationPress_after_content'); ?>

	</div>
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>