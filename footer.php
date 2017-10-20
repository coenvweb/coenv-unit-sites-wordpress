</section>
	<footer id="footer" role="contentinfo" class="site-footer">
		<?php do_action('foundationPress_before_footer'); ?>
		<div class="footer-row">
        <div class="row">
			<div class="medium-6 columns">
				<div class="row">
                	<div class="logo left columns large-3 show-for-large-up">
                    	<a href="/"><img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-color.png" alt="Climate Impacts Group" /></a>
                	</div>
                	<div class="unit-info left columns large-9">
					<div class="site-footer__header">
						<h2 class="show-for-small-only" id="logo"><a href="http://coenv.washington.edu/" rel="home" title="UW College of the Environment"><img alt="College of the Environment Logo" src="<?php bloginfo('template_directory'); ?>/assets/img/uw-footer.svg" width="350" ></a></h2>
					</div>
					<h2><?php bloginfo('name') ?></h2>
					<div class="unit-contact">
						<?php if (get_field('mail_address', 'option')) { ?><p><a href="http://maps.google.com/?q=<?php echo get_field('mail_address', 'option'); ?>" title="Google Maps link"><?php echo get_field('mail_address', 'option'); ?></a></p><?php } ?>
						<?php if (get_field('public_email_address', 'option')) { ?><p><a href="mailto:<?php echo antispambot(get_field('public_email_address', 'option')); ?>" title="Send us an Email"><?php echo antispambot(get_field('public_email_address', 'option')); } ?></a>
						<?php if (get_field('phone', 'option')) { ?> | <?php echo get_field('phone', 'option'); ?></p><?php } ?>
					</div>
					<div class="footer__info">
						<?php get_search_form() ?>
						<div class="social-buttons">
							<?php if (get_field('facebook', 'option')) { ?>
							<a class="facebook button" href="<?php echo get_field('facebook', 'option'); ?>" title="Join us on Facebook">
								<i class="fi-social-facebook"></i>
							</a><?php } ?>
							<?php if (get_field('twitter', 'option')) { ?>
							<a class="twitter button" href="<?php echo 'http://twitter.com/' . get_field('twitter', 'option'); ?>" data-site-twitter="<?php echo get_field('twitter', 'option'); ?>" title="Join us on Twitter">
								<i class="fi-social-twitter"></i>
							</a><?php } ?>
							<?php if (get_field('youtube', 'option')) { ?>
							<a class="youtube button" href="<?php echo get_field('youtube', 'option'); ?>" title="Join us on YouTube">
								<i class="fi-social-youtube"></i>
							</a><?php } ?>
						</div>
					</div>

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
							<li><a target="_blank" href="https://smea.uw.edu">Marine and Environmental Affairs</a></li>
							<li><a target="_blank" href="http://www.ocean.washington.edu/">Oceanography</a></li>
							<li><a target="_blank" href="http://envstudies.uw.edu">Program on the Environment</a></li>
							<li><a target="_blank" href="https://earthlab.uw.edu">EarthLab</a></li>
							<li><a target="_blank" href="https://cig.uw.edu">Climate Impacts Group</a></li>
							<li><a target="_blank" href="http://fhl.uw.edu">Friday Harbor Laboratories</a></li>
							<li><a target="_blank" href="http://jisao.washington.edu/">Joint Institute for the Study of the Atmosphere and Ocean</a></li>
                            <li><a target="_blank" href="http://pcc.uw.edu">Program on Climate Change</a></li>
                            <li><a target="_blank" href="http://qrc.uw.edu">Quaternary Research Center</a></li>
							<li><a target="_blank" href="https://botanicgardens.uw.edu/">UW Botanic Gardens</a></li>
							<li><a target="_blank" href="http://www.waspacegrant.org/">Washington NASA Space Grant</a></li>
							<li><a target="_blank" href="http://wsg.washington.edu/">Washington Sea Grant</a></li>
							<li></li>
						</ul>
					</nav>
				</div>
            </div>
        </div>
			
        <div class="footer-footer">
<div class="uw-footer">
    <div class="layout-container row">

        <div class="be-boundless">
            <a href="http://washington.edu/" rel="home" title="University of Washington" target="_blank"><?php include('assets/img/university-of-washington.svg'); ?></a><br />
            <a href="http://www.washington.edu/boundless/" rel="home" title="University of Washington - Be Boundless" target="_blank"><img class="boundless-logo" src="<?= get_template_directory_uri() ?>/assets/img/boundless_logo.png" alt="Be Boundless - For Washington For The World" /><span class="visuallyhidden">Be Boundless</span></a>
        </div>

        <div class="medium-6 columns">
                <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a> | 
                    <?php if (is_user_logged_in()) { ?>
                        <a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Log out</a>	
                    <?php } else { ?>
                        <a href="<?php echo wp_login_url(); ?>" title="Staff Login">Staff login</a>
                    <?php } ?>
                </p>
            </div>
            <div class="medium-6 columns uw-footer-links">
                <ul id="menu-footer-links" class="menu-footer-links">
                    <li><a target="_blank" href="http://www.washington.edu/admin/hr/jobs/">Jobs</a></li>
                    <li><a target="_blank" href="http://myuw.washington.edu/">My UW</a></li>
                    <li><a target="_blank" href="http://www.washington.edu/online/privacy/">Privacy</a></li>
                    <li><a target="_blank" href="http://www.washington.edu/online/terms/">Terms</a></li>
                </ul>
            </div>
        </div>
    </div>
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
