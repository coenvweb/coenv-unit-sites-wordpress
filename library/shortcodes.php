<?php
function gCalendar_func($atts) {
    $gCalendar = shortcode_atts( array(
        'src' => 'https://calendar.google.com/calendar/embed?title=SAFS%20AV%20Calendar&height=600&wkst=1&bgcolor=%23FFFFFF&src=uw.edu_16mvpklmbvnk6g8mt8ntlnjbo4%40group.calendar.google.com&color=%235229A3&src=uw.edu_772spcobhdbi8cja0pm81fcn78%40group.calendar.google.com&color=%23AB8B00&src=uw.edu_muh3ce9kij0p43b5gactkeonl0%40group.calendar.google.com&color=%23691426&src=uw.edu_3k7s4o448jnoi9ld7e6kqbd5h8%40group.calendar.google.com&color=%238C500B&src=uw.edu_f6i0m4hif9raq3faeb4mvsk7g4%40group.calendar.google.com&color=%23333333&src=uw.edu_0f81cr9hhe6rlaj7klk8uvd4r8%40group.calendar.google.com&color=%23AB8B00&src=uw.edu_2m64hkk45f8qf2b63rjt382urg%40group.calendar.google.com&color=%236B3304&src=uw.edu_4pocsitd83kje6lonttn1mv050%40group.calendar.google.com&color=%23AB8B00&src=uw.edu_v3mukld499vpdhgl360r5cr0j4%40group.calendar.google.com&color=%23B1365F&src=uw.edu_3ct7chvkkq7quai8feb4eev194%40group.calendar.google.com&color=%238C500B&src=uw.edu_tuakco7ds1grt04oopi3qr51ag%40group.calendar.google.com&color=%236B3304&src=uw.edu_t6gkfl5j3ro7s748tv13sgkh7k%40group.calendar.google.com&color=%23182C57&src=uw.edu_m1i9r7ebo9e57vij42c17maet0%40group.calendar.google.com&color=%23333333&src=uw.edu_615m0ckut69g10etplrqki231s%40group.calendar.google.com&color=%23B1440E&src=uw.edu_qr1mv53q803ftpkm95npmqie14%40group.calendar.google.com&color=%2323164E&src=uw.edu_jn8bnol34k76kqbhac9hnlnv10%40group.calendar.google.com&color=%232F6309&ctz=America%2FLos_Angeles',
    ), $atts );
    return '<iframe src="'.$gCalendar['src'].'" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>';
}
add_shortcode('gCalendar', 'gCalendar_func');

function marketo_signup_form($atts) {
    remove_filter( 'the_content', 'eae_encode_emails', EAE_FILTER_PRIORITY );
    remove_filter( 'the_content', 'remove_plaintext_email', 20);
    $mkto = shortcode_atts( array(
        'subid' => 306, 
        'fromname' => 'UW Email Sign Up',
        'fromemail' => 'advsti@uw.edu',
        'showplaceholders' => 0,
        'hidelabels' => 0,
        'returnurl' => '', 
    ), $atts);
    $output = '<div style="margin:0px;padding:0px;overflow:hidden;height:100%;" ><script type="text/javascript" src="https://subscribe.gifts.washington.edu/Scripts/SubManBuilder/submanbuilder.js" id="uwSubscriptionManager"></script>
    <script type="text/javascript">
        SUBMANBUILDER.makeIframe({
            subscriptionID: '.$mkto['subid'].',
            fromName: "'.$mkto['fromname'].'",
            fromEmail: "'.$mkto['fromemail'].'",
            showPlaceHolders: '.$mkto['showplaceholders'].',
            hideLabels: '.$mkto['hidelabels'].',
            returnURL: "'.$mkto['returnurl'].'"
        });
    </script></div>';
    return $output;
}
add_shortcode('mkto_signup','marketo_signup_form');

// iframe shortcode. ex. [iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""]
add_shortcode( 'iframe' , 'coenv_shortcode_iframe' );
function coenv_shortcode_iframe($args, $content) {
    $keys = array("src", "width", "height", "scrolling", "marginwidth", "marginheight", "frameborder");
    $arguments = coenv_extract_shortcode_arguments($args, $keys);
    return '<iframe ' . $arguments . '></iframe>';
}

function coenv_extract_shortcode_arguments($args, $keys) {
    $result = "";
    foreach ($keys as $key) {
        if (isset($args[$key])) {
            $result .= $key . '="' . $args[$key] . '" ';
        }
    }
    return $result;
}


?>
