<?php  
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */
?>
<aside id="sidebar" class="small-12 medium-4 large-3 columns">
<?php
if (!is_front_page()) {
	echo '<div class="coenv_base_subnav">';
		echo coenv_base_hierarchical_submenu($GLOBALS['post']->ID);
	echo '</div>';
}
?>
<?php dynamic_sidebar('sidebar-widgets'); ?>
<?php
$ancestor_id = coenv_base_get_ancestor('ID');
if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )):

	dynamic_sidebar( $ancestor_id );
endif;

if (is_single( '12808' )) { ?>
<div class="small-12 columns">
<article id="custom_post_widget-777" class="row widget widget_custom_post_widget">
<div class="widget_content">
	<h2>Remembrance Funds</h2>
	<p>At the request of the Miles-Karpov family, if you, or others you know, wish to make a gift in tribute to Ed Miles, please consider donating to:</p>
	<ul class="widget_links">
	<li><a class="button" title="Ed Miles Memorial Scholarship Fund" href="https://www.washington.edu/giving/make-a-gift?source_typ=3&source=MARENV" target="_blank">Ed Miles Memorial Scholarship Fund</a></li>
	<li><a class="button" title="Climate Impacts Group Innovation Fund" href="https://www.washington.edu/giving/make-a-gift/?source_typ=3&source=ENVCIG" target="_">Climate Impacts Group Innovation Fund</a></li>
	</ul>
</div>
</article>
</div>
<div class="small-12 columns">
<article id="custom_post_widget-778" class="row widget widget_custom_post_widget">
<div class="widget_content">
	<h2>Tributes</h2>
	<p>Shared memories and stories about Ed.</p>
	<ul class="widget_links">
	<li><a class="button" title="Public website for memories and stories about Ed" href="http://www.inlovingmemoryofedmiles.com/" target="_blank">Public website for memories and stories about Ed</a></li>
	<li><a class="button" title="PDF Version of this Tribute" href="https://cig.uw.edu/wp-content/uploads/sites/2/2014/11/Tribute-to-Ed-Miles_CIG_PDF-1.pdf" target="_blank">PDF Version of this Tribute</a></li>
	</ul>
</div>
</article>
</div>
<div class="small-12 columns">
<article id="custom_post_widget-779" class="row widget widget_custom_post_widget">
<div class="widget_content">
	<h2>More on Ed</h2>
	<p>For more information about Ed:</p>
	<ul class="widget_links">
	<li><a class="button" title="Seattle Times: Ed Miles, climate-change luminary, dies at 76" href="http://www.seattletimes.com/seattle-news/obituaries/climate-change-luminary-ed-miles-dies-at-76/" target="_blank">Seattle Times: Ed Miles, climate-change luminary, dies at 76</a></li>
	<li><a class="button" title="Keynote Address, UW Science and Policy Summit, 2011 (video)" href="https://www.youtube.com/watch?v=Y1Aau0TGBwQ" target="_blank">Keynote Address, UW Science and Policy Summit, 2011 (video)</a></li>
	<!--<li><a class="button" title="Profile, Proceedings of the National Academy of Sciences, 2006" href="http://www.ncbi.nlm.nih.gov/pmc/articles/PMC1750915/" target="_blank">Profile, Proceedings of the National Academy of Sciences, 2006</a></li>-->
	</ul>
</div>
</article>
</div>
<?php } ?>
</aside>