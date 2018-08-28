<?php

    if (!current_user_can('export')) {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $args = array(
        'post_type' => 'newsletter',
        'meta_key' => 'newsletter_type',
        'meta_value' => 'headlines',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => 10
    );
    $hquery = new WP_Query($args);
?>
    <h1>Headlines Newsletter HTML Generator</h1><small>Auto generate formatted html for use in the Headlines Newsletter</small>

    <form class="headlines_form" action="newsletter_service.php" method="post">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="start_date">Start Date</label>
                </th>
                <td>
                    <select name="newsletter">
                        <?php if($hquery->have_posts()) { ?>
                            <?php while($hquery->have_posts()) : $hquery->the_post() ?>
                                <option value="<?=get_the_ID()?>"><?=get_the_title()?></option>
                            <?php endwhile ?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" class="button-primary" id="gen_html">Build Email</button>
    </form>

    <div id="newsletter" style="width:90%; min-height:200px; margin-top: 30px; border:1.5px solid #ccc; border-radius:8px; background-color:white;" contentEditable="true">

    </div>
