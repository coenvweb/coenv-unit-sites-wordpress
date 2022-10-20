<div class="wrapper" style="max-width: 640px; font-size: 16px;">
    <img style="width:400px;" src="<?php echo $logoUrl; ?>" alt="UW - College of the Environment"/>

    <?php if ( $user->user_login != '' ) : ?>
        <h1 style="color:#4b2e83;font-size:32px;">Welcome, <?php echo $user->user_login; ?></h1>
    <?php else : ?>
        <h1 style="color:#4b2e83;font-size:32px;">Welcome</h1>
    <?php endif; ?>

    <p>
        An editor account was created for you at <a href="<?php echo $siteUrl; ?>"><?php echo $siteUrl; ?></a>. <br>
    </p>


    <p>
        Here are a few resources to help you get started:<br><br>
            For general how-tos and instructions: <a href="https://environment.uw.edu/intranet/marketing-communications/editing-our-website/">Editing Our Website</a><br>
            For writing, editing, and formatting: <a href="https://environment.uw.edu/intranet/marketing-communications/college-of-the-environment-style-guide/">College Style Guide</a><br>
            Please contact the <a href="mailto:coenvweb@uw.edu">Web Team</a> if you have any questions or to set up a formal training session.
    </p>
    <p>
        College website accounts are managed through UW NetID. To gain access to the site admin panel, click the staff login link below and sign in with your UW NetID.<br>
        The login link can also be found in the footer of all College websites.
    </p>

    <p>
        <a href="<?php echo $siteUrl; ?>">College Website</a><br>
        <a href="<?php echo $loginUrl; ?>">Staff Login</a>
    </p>

    <p>
        Thank you,<br>
        College of the Environment Web Team
    </p>
</div>
