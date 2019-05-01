<?php
/*
Plugin Name: WP Lorem ipsum
Description: Automatically create new fake posts to fill the database and get a very good impression for your website.
Author: Matteo Manna
Version: 2.2
Author URI: http://matteomanna.com/
Text Domain: wp-lorem-ipsum
License: GPL2
*/

/**
 * Automatically require all library files
 */
$lib_path = dirname(__FILE__).'/lib/';
if ( file_exists( $lib_path ) ) {
    $open = opendir( $lib_path );
    while( false !== ( $file = readdir( $open ) ) ) if ( $file != '.' && $file != '..' ) require('lib/'.$file);
}

/**
 * @param $plugin
 * @Usage: Redirect after Plugin activation
 */
function li_redirect_after_activation( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) exit( wp_redirect( admin_url('options-general.php?page=wp-lorem-ipsum') ) );
}
add_action( 'activated_plugin', 'li_redirect_after_activation' );

function li_load_textdomain()
{
    load_plugin_textdomain( 'wp-lorem-ipsum', false, basename(dirname(__FILE__)) . '/languages' );
}
add_action( 'init', 'li_load_textdomain' );

function li_admin_head_scripts()
{
    wp_enqueue_media();
    wp_enqueue_style('li-css-style', plugins_url('css/style.css', __FILE__), array(), null);
    wp_enqueue_script('li-js-custom', plugins_url('js/scripts.js', __FILE__), array(), '1.0', true);
}
add_action( 'admin_enqueue_scripts', 'li_admin_head_scripts' );

/**
 * @param $links
 * @return array
 */
function li_add_action_links($links)
{
    $new_links = array(
        '<a href="'.admin_url('options-general.php?page=wp-lorem-ipsum').'">'.__('Settings', 'wp-lorem-ipsum').'</a>',
    );
    return array_merge( $links, $new_links );
}
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'li_add_action_links' );

function li_admin_menu()
{
    add_options_page(
        __('WP Lorem ipsum settings', 'wp-lorem-ipsum'),
        __('WP Lorem ipsum', 'wp-lorem-ipsum'),
        'manage_options',
        'wp-lorem-ipsum',
        'li_admin_page'
    );
}
add_action( 'admin_menu', 'li_admin_menu' );

function get_nonce_string() {
    return 'matteomanna-wp-lorem-ipsum';
}

function li_admin_page()
{
    global $li_posts;

    $num_start = $li_posts->get_count_post_limit('min');
    $num_end = $li_posts->get_count_post_limit('max');
    $post_types = li_get_post_types();
    $post_statuses = li_get_post_statuses();
    $post_authors = li_get_authors();
    ?>
    <div class="wrap">
        <h2><?php echo __('WP Lorem ipsum', 'wp-lorem-ipsum'); ?></h2>
        <p><?php echo __('You can create fake posts to fill your database.', 'wp-lorem-ipsum'); ?></p>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="li-form">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td><label for="post-count"><?php echo __('Number of posts', 'wp-lorem-ipsum'); ?></label></td>
                        <td>
                            <select name="post_count" id="post-count" required="required">
                                <option value=""><?php echo __('Select', 'wp-lorem-ipsum'); ?>...</option>
                                <?php
                                while( $num_start <= $num_end ) {
                                    ?>
                                    <option value="<?php echo $num_start; ?>"><?php echo $num_start; ?></option>
                                    <?php
                                    $num_start = $num_start + 5;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="post-type"><?php echo __('Post type', 'wp-lorem-ipsum'); ?></label></td>
                        <td>
                            <select name="post_type" id="post-type" required="required">
                                <option value=""><?php echo __('Select', 'wp-lorem-ipsum'); ?>...</option>
                                <?php
                                if( count($post_types) ) {
                                    foreach( $post_types as $post_type ) {
                                        ?>
                                        <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="post-status"><?php echo __('Post status', 'wp-lorem-ipsum'); ?></label></td>
                        <td>
                            <select name="post_status" id="post-status" required="required">
                                <option value=""><?php echo __('Select', 'wp-lorem-ipsum'); ?>...</option>
                                <?php
                                if( count($post_statuses) ) {
                                    foreach( $post_statuses as $post_status ) {
                                        ?>
                                        <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="post-author"><?php echo __('Post author', 'wp-lorem-ipsum'); ?></label></td>
                        <td>
                            <select name="post_author" id="post-author" required="required">
                                <option value=""><?php echo __('Select', 'wp-lorem-ipsum'); ?>...</option>
                                <?php
                                if( count($post_authors) ) {
                                    foreach( $post_authors as $post_author ) {
                                        ?>
                                        <option value="<?php echo (int)$post_author->ID; ?>"><?php echo $post_author->user_login; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="has-post-thumbnail"><?php echo __('Post thumbnail', 'wp-lorem-ipsum'); ?></label></td>
                        <td>
                            <input type="checkbox" name="has_post_thumbnail" id="has-post-thumbnail" value="1" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="button button-primary button-large"><?php echo __('Send', 'wp-lorem-ipsum'); ?></button>
            <input type="hidden" name="action" value="li_post_submit" />
            <?php wp_nonce_field( get_nonce_string(), '_wpnonce' );?>
        </form>
    </div>
    <?php
}

function li_post_submit()
{
    global $li_posts;

    if( !current_user_can('manage_options') ) wp_die( __('Error.', 'wp-lorem-ipsum') );
    if (
            isset( $_POST['_wpnonce'] )
            && wp_verify_nonce( $_POST['_wpnonce'], get_nonce_string() )
    ) {
        // Check fields
        if(
            (
                isset($_POST['post_count']) && is_numeric($_POST['post_count'])
                && (
                        $_POST['post_count'] >= $li_posts->get_count_post_limit('min')
                        && $_POST['post_count'] <= $li_posts->get_count_post_limit('max')
                    )
            )
            && ( isset($_POST['post_type']) && !empty($_POST['post_type']) && is_string($_POST['post_type']) )
            && ( isset($_POST['post_status']) && !empty($_POST['post_status']) && is_string($_POST['post_status']) )
            && ( isset($_POST['post_author']) && is_numeric($_POST['post_author']) )
        ) {
            // Post Thumbnail
            $has_post_thumbnail = ( isset($_POST['has_post_thumbnail']) && is_numeric($_POST['has_post_thumbnail']) && $_POST['has_post_thumbnail'] == 1 ) ? true : false ;

            // Insert posts
            $args = array(
                'post_count' => (int)$_POST['post_count'],
                'post_type' => sanitize_text_field($_POST['post_type']),
                'post_status' => sanitize_text_field($_POST['post_status']),
                'post_author' => (int)$_POST['post_author'],
                'has_post_thumbnail' => $has_post_thumbnail
            );
            $li_posts->insert_posts($args);

            // Redirect to selected post_type archive
            exit( wp_redirect( admin_url('edit.php?post_type='.$_POST['post_type']) ) );
        } else {
            // Error during insert
            wp_die( __('Error.', 'wp-lorem-ipsum') );
        }
    } else {
        // Error during insert
        wp_die( __('Error.', 'wp-lorem-ipsum') );
    }
}
add_action('admin_post_li_post_submit', 'li_post_submit');
//add_action('admin_post_nopriv_li_post_submit', 'li_post_submit');