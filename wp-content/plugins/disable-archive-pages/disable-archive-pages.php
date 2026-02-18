<?php
/**
 * Plugin Name: Disable Archive Pages
 * Description: Disable public archive pages in WordPress like category, tag, author, date, and custom post type archives.
 * Version: 1.0.0
 * Author: Kasper K.
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: disable-archive-pages
 */

if (!defined('ABSPATH')) exit;

// Prefix: amgr_

function amgr_register_settings() {
    register_setting('amgr_settings_group', 'amgr_disabled_archives', [
        'type' => 'array',
        'sanitize_callback' => 'amgr_sanitize_archives',
        'default' => []
    ]);
}
add_action('admin_init', 'amgr_register_settings');

function amgr_sanitize_archives($input) {
    return array_map('sanitize_text_field', (array) $input);
}

function amgr_add_admin_menu() {
    add_options_page(
        'Disable Archive Pages',
        __('Disable Archives', 'disable-archive-pages'),
        'manage_options',
        'disable-archive-pages',
        'amgr_settings_page'
    );
}
add_action('admin_menu', 'amgr_add_admin_menu');

function amgr_get_archive_types() {
    $types = [
        'category' => __('Categories', 'disable-archive-pages'),
        'post_tag' => __('Tags', 'disable-archive-pages'),
        'author' => __('Author Archives', 'disable-archive-pages'),
        'date' => __('Date Archives', 'disable-archive-pages')
    ];

    $taxonomies = get_taxonomies(['public' => true, '_builtin' => false], 'objects');
    foreach ($taxonomies as $taxonomy) {
        $attached = !empty($taxonomy->object_type) ? implode(', ', $taxonomy->object_type) : __('Unknown', 'disable-archive-pages');
        /* translators: %s is a comma-separated list of post types attached to the taxonomy */
        $label = $taxonomy->labels->name . ' (' . sprintf(__('Taxonomy for: %s', 'disable-archive-pages'), $attached) . ')';
        $types[$taxonomy->name] = $label;
    }

    $post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
    foreach ($post_types as $post_type) {
        if ($post_type->has_archive) {
            /* translators: %s is the post type slug */
            $label = $post_type->labels->name . ' (' . sprintf(__('Post Type Archive: %s', 'disable-archive-pages'), $post_type->name) . ')';
            $types['post_type__' . $post_type->name] = $label;
        }
    }

    return $types;
}

function amgr_settings_page() {
    if (!current_user_can('manage_options')) return;

    $options = get_option('amgr_disabled_archives', []);
    $types = amgr_get_archive_types();
    ?>
    <div class="wrap">
        <h1><?php echo esc_html('Disable Archive Pages'); ?></h1>
        <p><?php esc_html_e('Below is a list of archive types found on your site. If you check a box, that archive will return a 404 error and be excluded from sitemaps.', 'disable-archive-pages'); ?></p>
        <form method="post" action="options.php">
            <?php settings_fields('amgr_settings_group'); ?>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Key', 'disable-archive-pages'); ?></th>
                        <th><?php esc_html_e('Description', 'disable-archive-pages'); ?></th>
                        <th><?php esc_html_e('Disable', 'disable-archive-pages'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($types as $key => $label) : ?>
                        <tr>
                            <td><code><?php echo esc_html($key); ?></code></td>
                            <td><?php echo esc_html($label); ?></td>
                            <td><input type="checkbox" name="amgr_disabled_archives[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $options, true)); ?>></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php submit_button(__('Save Changes', 'disable-archive-pages')); ?>
        </form>
    </div>
    <?php
}

function amgr_disable_archives() {
    if (is_admin()) return;

    $options = get_option('amgr_disabled_archives', []);

    if (is_category() && in_array('category', $options, true)) {
        amgr_trigger_404();
    } elseif (is_tag() && in_array('post_tag', $options, true)) {
        amgr_trigger_404();
    } elseif (is_author() && in_array('author', $options, true)) {
        amgr_trigger_404();
    } elseif ((is_date() || is_day() || is_month() || is_year()) && in_array('date', $options, true)) {
        amgr_trigger_404();
    } else {
        foreach (get_taxonomies(['public' => true, '_builtin' => false]) as $taxonomy) {
            if (is_tax($taxonomy) && in_array($taxonomy, $options, true)) {
                amgr_trigger_404();
            }
        }
        foreach (get_post_types(['public' => true, '_builtin' => false], 'names') as $post_type) {
            if (is_post_type_archive($post_type) && in_array('post_type__' . $post_type, $options, true)) {
                amgr_trigger_404();
            }
        }
    }
}
add_action('template_redirect', 'amgr_disable_archives');

function amgr_trigger_404() {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();

    add_filter('template_include', function() {
        return get_404_template();
    });
}

function amgr_remove_archives_from_sitemap($value, $name) {
    $options = get_option('amgr_disabled_archives', []);

    if (in_array($name, ['author', 'date'], true) && in_array($name, $options, true)) {
        return false;
    }

    if (taxonomy_exists($name) && in_array($name, $options, true)) {
        return false;
    }

    if (post_type_exists($name) && in_array('post_type__' . $name, $options, true)) {
        return false;
    }

    return $value;
}
add_filter('wp_sitemaps_add_provider', 'amgr_remove_archives_from_sitemap', 10, 2);
