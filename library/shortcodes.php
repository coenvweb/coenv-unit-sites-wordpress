<?php
function gCalendar_func($atts) {
    $gCalendar = shortcode_atts( array(
        'src' => 'https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23FFFFFF&src=uw.edu_ntdmhh3bgskqsrkmg36c2ar72c%40group.calendar.google.com&color=%23865A5A&src=qrc%40uw.edu&color=%235229A3&ctz=America%2FLos_Angele://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=uw.edu_4pocsitd83kje6lonttn1mv050%40group.calendar.google.com&amp;color=%23AB8B00&amp;src=uw.edu_v3mukld499vpdhgl360r5cr0j4%40group.calendar.google.com&amp;color=%23B1365F&amp;ctz=America%2FLos_Angeles',
    ), $atts );
    return '<div class="responsive-iframe-container">
        <iframe src="'.$gCalendar['src'].'" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
    </div>';
}
add_shortcode('gCalendar', 'gCalendar_func');

?>
