<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://nabillemsieh.com
 * @since      0.1.0
 *
 * @package    Easy_Media_Replace
 * @subpackage Easy_Media_Replace/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Media_Replace
 * @subpackage Easy_Media_Replace/admin
 * @author     Nabil Lemsieh <contact@nabillemsieh.com>
 */

use Easy_Media_Replace_Helper as Helper;

class Easy_Media_Replace_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    public function add_replace_link_to_media_row($actions, $post)
    {
        $replace['emr-replace']
            = '<a href="#" class="js-emr-open-dialog" data-attachment-id="'
            . $post->ID . '" data-attachment-mime="' . $post->post_mime_type
            . '" aria-label="View ' . Helper::trans(
                sprintf('Replace %s', $post->post_title)
            ) . '">' . Helper::trans('Replace') . '</a>';

        return $replace + $actions;
    }

    public function add_replace_link_to_attachment_misc_actions($post)
    {
        $file_type = Helper::file_type($post->post_mime_type);
        ?>
        <div class="misc-pub-section misc-pub-emr">
            <button type="button" class="button-secondary js-emr-open-dialog emr-dialog__open" data-attachment-id="<?php echo $post->ID ?>" data-attachment-mime="<?php echo $post->post_mime_type ?>">
                <?php echo Helper::trans(sprintf(
                            'Replace %s',
                            $file_type
                        )) ?></button>
        </div>'
<?php
    }

    public function add_replace_link_to_media_dialog($form_fields, $post)
    {
        $screen = get_current_screen();
        if ($screen && $screen->id === "attachment") {
            return $form_fields;
        }
        $form_fields['emr-replace'] = [
            'label' => '',
            'input' => 'html',
            'html'  => '<button type="button" class="button-secondary js-emr-open-dialog emr-dialog__open">Replace</button>',
        ];

        return $form_fields;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'jquery-ui',
            EMR_DIR_URL . 'admin/css/jquery-ui.min.css',
            [],
            '1.12.1',
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name,
            EMR_DIR_URL . 'admin/css/easy-media-replace-admin.css',
            array('jquery-ui'),
            filemtime(EMR_DIR . 'admin/css/easy-media-replace-admin.css'),
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    0.1.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script(
            "dropzone",
            plugin_dir_url(__FILE__) . 'js/dropzone.js',
            array(),
            "5.2",
            true
        );
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . 'js/easy-media-replace-admin.js',
            array('jquery-ui-dialog', 'dropzone'),
            filemtime(
                plugin_dir_path(__FILE__) . 'js/easy-media-replace-admin.js'
            ),
            true
        );
        $ajax_nonce = wp_create_nonce(Helper::nonce_string());
        wp_localize_script(
            $this->plugin_name,
            'emr_ajax_object',
            [
                'ajax_url'   => admin_url('admin-ajax.php'),
                'ajax_nonce' => $ajax_nonce,
            ]
        );
    }

    /**
     * Send dialog html.
     *
     * @return void
     */
    public function dialog()
    {
        check_ajax_referer(Helper::nonce_string(), 'nonce', true);

        $max_upload_size = round(wp_max_upload_size() / MB_IN_BYTES);

        $mime = filter_input(INPUT_GET, 'mime', FILTER_SANITIZE_STRING);

        $file_type = Helper::file_type($mime);

        ob_start();
        include(EMR_DIR . 'admin/partials/dialog.php');
        die(ob_get_clean());
    }

    /**
     * Process file upload.
     * Then send back file path.
     *
     * @return void
     */
    public function upload()
    {
        check_ajax_referer(Helper::nonce_string(), 'nonce', true);

        if (!current_user_can('upload_files')) {
            wp_send_json_error(
                [
                    'message' => Helper::trans(
                        'Sorry, you aren\'t allowed to upload files.'
                    ),
                ],
                401
            );
        }

        // Process upload.
        $file = wp_handle_upload($_FILES['file'], ['test_form' => false]);

        // Send file path back on success.
        if ($file && !isset($file['error'])) {
            wp_send_json_success(
                ['message' => Helper::trans('File uploaded successfully.')]
                    + $file
            );
        } else {
            wp_send_json_error(
                ['message' => Helper::trans($file['error'])],
                500
            );
        }
    }

    /**
     * Maybe remove file from the server.
     *
     * @return void
     */
    public function remove()
    {
        check_ajax_referer(Helper::nonce_string(), 'nonce', true);

        $file_path = filter_input(
            INPUT_POST,
            'filePath',
            FILTER_SANITIZE_STRING
        );
        if (file_exists($file_path)) {
            @unlink($file_path);
            if (!is_writable(dirname($file_path))) {
                wp_send_json_success(
                    ['message' => Helper::trans('File cannot be deleted.')]
                );
            }
            wp_send_json_success(
                ['message' => Helper::trans('File deleted successfully.')]
            );
        }
        wp_send_json_error(
            ['message' => Helper::trans('File not found.')],
            500
        );
    }

    /**
     * Process file replacing.
     *
     * @return void
     */
    public function replace()
    {
        check_ajax_referer(Helper::nonce_string(), 'nonce', true);

        // Processing attachment ID.
        $attachment_id = filter_input(
            INPUT_POST,
            'attachmentId',
            FILTER_SANITIZE_NUMBER_INT
        );

        // Abort if the atachment ID is not set or invalid.
        if ($attachment_id === false) {
            wp_send_json_error(
                ['message' => Helper::trans('Invalid attachment ID.')],
                400
            );
        }

        // Maybe the attachment is deleted before processing.
        if (!get_post($attachment_id)) {
            wp_send_json_error(
                ['message' => Helper::trans('Attachment not found.')],
                400
            );
        }

        // New file full path.
        $new_file_path = filter_input(
            INPUT_POST,
            'newFilePath',
            FILTER_SANITIZE_STRING
        );
        if ($new_file_path === false) {
            wp_send_json_error(
                ['message' => Helper::trans('Invalid file path.')],
                400
            );
        }

        // Ensure that both files exist.
        if (!file_exists($new_file_path)) {
            wp_send_json_error(
                ['message' => Helper::trans('New file not found.')],
                404
            );
        }
        $old_file_path = get_attached_file($attachment_id);
        if (!file_exists($old_file_path)) {
            wp_send_json_error(
                ['message' => Helper::trans('Old attachment file not found.')],
                404
            );
        }

        // Ensure that both files have the same mime type.
        $file_type = wp_attachment_is_image($attachment_id) ? 'image' : 'file';

        $attachment_metadata = wp_get_attachment_metadata($attachment_id);

        if (!Helper::same_mime($old_file_path, $new_file_path)) {
            wp_send_json_error(
                [
                    'message' => Helper::trans(
                        sprintf(
                            'The new %s must have the same type as the old one: %s.',
                            $file_type,
                            basename($old_file_path)
                        )
                    ),
                ],
                400
            );
        }

        // Options
        $regen_metadata       = filter_input(
            INPUT_POST,
            'regenMetadata',
            FILTER_VALIDATE_BOOLEAN
        );
        $change_modified_time = filter_input(
            INPUT_POST,
            'modifiedTime',
            FILTER_VALIDATE_BOOLEAN
        );

        // Everthing is ok, then we override the old file with the new one.
        if (rename($new_file_path, $old_file_path)) {

            //update_attached_file($attachment_id, $old_file_path);

            // We re-generate other sizes if applicable.
            if ($file_type === 'image') {
                if ($regen_metadata) {

                    // delete old sizes.
                    foreach ($attachment_metadata['sizes'] as $size) {
                        unlink(dirname($old_file_path) . '/' . $size['file']);
                    }

                    // regenerate new replaced image thumbnails.
                    $new_attachment_metadata = wp_generate_attachment_metadata(
                        $attachment_id,
                        $old_file_path
                    );

                    wp_update_attachment_metadata(
                        $attachment_id,
                        $new_attachment_metadata
                    );
                }
            }

            // Maybe change modified time.
            if ($change_modified_time) {
                $post_update = [
                    'ID'                => $attachment_id,
                    'post_modified'     => current_time('mysql'),
                    'post_modified_gmt' => current_time('mysql', 1),
                ];
                wp_update_post($post_update);
            }

            wp_cache_flush();

            wp_send_json_success(
                [
                    'message' => Helper::trans(
                        sprintf(
                            '%s replaced successfully.',
                            ucfirst($file_type)
                        )
                    ),
                ]
            );
        } else {
            wp_send_json_error(
                [
                    'message' => Helper::trans(
                        sprintf(
                            'Unable to replace %s. Please, try again.',
                            ucfirst($file_type)
                        )
                    ),
                ],
                500
            );
        }
    }
}
