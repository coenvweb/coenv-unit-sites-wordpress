<?php
    if (!current_user_can('export')) {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    $args = array(
        'post_type' => 'newsletter',
        'meta_key' => 'newsletter_type',
        'meta_value' => 'scicomm',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => 10
    );
    $squery = new WP_Query($args);
?>
    <h1>SciComm Newsletter HTML Generator</h1><small>Auto generate formatted html for use in the SciComm Newsletter</small>

    <form class="headlines_form" action="newsletter_service.php" method="post">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="start_date">Start Date</label>
                </th>
                <td>
                    <select name="newsletter">
                        <?php if($squery->have_posts()) { ?>
                            <?php while($squery->have_posts()) : $squery->the_post() ?>
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
