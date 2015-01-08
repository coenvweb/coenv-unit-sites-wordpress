</section>
	<footer id="footer" role="contentinfo" class="site-footer">
		<?php do_action('foundationPress_before_footer'); ?>
		<div class="footer-row">
        <div class="row">
			<div class="medium-6 columns">				
				<header class="site-footer__header">
					<h2><?php bloginfo('name') ?></h2>
				</header>
				<div class="unit-contact">
					<?php if (get_option('mail_address')) { ?><p><a href="http://maps.google.com/?q=<?php echo get_option('mail_address'); ?>" title="Google Maps link"><?php echo get_option('mail_address'); ?></a></p><?php } ?>
					<?php if (get_option('public_email_address')) { ?><p><a href="mailto:<?php echo get_option('public_email_address'); ?>" title="Send us an Email"><?php echo get_option('public_email_address'); } ?></a>
					<?php if (get_option('phone')) { ?> | <?php echo get_option('phone'); ?></p><?php } ?>
				</div>
				<div class="footer__info">
					<?php get_search_form() ?>
					<div class="social-buttons">
					<?php if (get_option('facebook')) { ?>
						<a class="facebook button" href="<?php echo get_option('facebook'); ?>" title="Join us on Facebook">
							<i class="fi-social-facebook"></i>
						</a><?php } ?>
					<?php if (get_option('twitter')) { ?>
						<a class="twitter button" href="<?php echo get_option('twitter'); ?>" data-site-twitter="<?php echo get_option('twitter'); ?>" title="Join us on Twitter">
								<i class="fi-social-twitter"></i>
						</a><?php } ?>
					<?php if (get_option('youtube')) { ?>
						<a class="youtube button" href="<?php echo get_option('youtube'); ?>" title="Join us on YouTube">
								<i class="fi-social-youtube"></i>
						</a><?php } ?>
					</div>
				</div>
			</div>
			<div class="medium-6 columns right">
				<nav class="footer-nav">
					<header class="site-footer__header">
						<h2 id="logo"><a href="http://coenv.washington.edu/" rel="home" title="UW College of the Environment"><img alt="College of the Environment Logo" src="<?php bloginfo('template_directory'); ?>/assets/img/uw-footer.svg" width="350" ></a></h2>
					</header>
						<ul class="menu-footer-units">
							<li><a target="_blank" href="http://fish.washington.edu/">Aquatic and Fishery Sciences</a></li>
							<li><a target="_blank" href="http://www.atmos.washington.edu/">Atmospheric Sciences</a></li>
							<li><a target="_blank" href="http://www.ess.washington.edu/">Earth and Space Sciences</a></li>
							<li><a target="_blank" href="http://www.sefs.washington.edu/">Environmental and Forest Sciences</a></li>
							<li><a target="_blank" href="http://depts.washington.edu/smea/front">Marine and Environmental Affairs</a></li>
							<li><a target="_blank" href="http://www.ocean.washington.edu/">Oceanography</a></li>
							<li><a target="_blank" href="http://depts.washington.edu/poeweb/">Program on the Environment</a></li>
							<li><a target="_blank" href="http://cses.washington.edu/cig/">Climate Impacts Group</a></li>
							<li><a target="_blank" href="http://depts.washington.edu/fhl/">Friday Harbor Labs</a></li>
							<li><a target="_blank" href="http://jisao.washington.edu/">Joint Institute for the Study of the Atmosphere and Ocean</a></li>
							<li><a target="_blank" href="http://depts.washington.edu/uwbg/">UW Botanic Gardens</a></li>
							<li><a target="_blank" href="http://www.waspacegrant.org/">Washington NASA Space Grant</a></li>
							<li><a target="_blank" href="http://wsg.washington.edu/">Washington Sea Grant</a></li>
						</ul>
					</nav>
				</div>
            </div>
        </div>
			
        <div class="footer-footer">
            <div class="row uw-footer">
                <div class="medium-6 columns">
                    <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a> | 
                        <?php if (is_user_logged_in()) { ?>
                            <a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Log out</a>	
                        <?php } else { ?>
                            <a href="<?php echo wp_login_url(); ?>" title="Staff Login">Staff login</a>
                        <?php } ?>
                    </p>
                </div>
                <div class="medium-6 columns">
                    <ul id="menu-footer-links" class="menu-footer-links">
                        <li><a target="_blank" href="http://www.washington.edu/admin/hr/jobs/">Jobs</a></li>
                        <li><a target="_blank" href="http://myuw.washington.edu/">My UW</a></li>
                        <li><a target="_blank" href="http://www.washington.edu/admin/rules/wac/rulesindex.html">Rules Docket</a></li>
                        <li><a target="_blank" href="http://www.washington.edu/online/privacy/">Privacy</a></li>
                        <li><a target="_blank" href="http://www.washington.edu/online/terms/">Terms</a></li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
	</footer><!-- #footer -->
</div>

	<?php dynamic_sidebar("footer-widgets"); ?>
	<?php do_action('foundationPress_after_footer'); ?>
</footer>
<a class="exit-off-canvas"></a>
	
  <?php do_action('foundationPress_layout_end'); ?>
  </div>
</div>
<?php wp_footer(); ?>
<?php do_action('foundationPress_before_closing_body'); ?>
</body>
</html>