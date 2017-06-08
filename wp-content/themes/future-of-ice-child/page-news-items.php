<?php
/**
 * page.php
 *
 * The main page template
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" role="main" class="template-page">

		<div class="container">

			
			  <nav id="secondary-nav" class="side-col">
			     <ul id="menu-secondary" class="menu">
	                <li class="pagenav"><a href="/news-items">News</a></li>
	             </ul>
	      	  </nav>

				

			<div class="main-col">










				

		

				<?php $latest = new WP_Query('showposts=7'); ?>
				<?php while( $latest->have_posts() ) : $latest->the_post(); ?>
				<article class="article">
				<header class="article__header">
					<h1 class="article__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				</header>
				<section class="article__content">
					<?php the_content(); ?>
				</section>
				</article>
				<?php endwhile; ?>
				<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

			</div><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>