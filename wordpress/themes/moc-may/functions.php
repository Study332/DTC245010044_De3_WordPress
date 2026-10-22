<?php
/** Theme setup and the editable Thai Nguyen tea product catalog. */

if (!defined('ABSPATH')) {
    exit;
}

function moc_may_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    register_nav_menus(array('primary' => __('Menu chính', 'moc-may')));
}
add_action('after_setup_theme', 'moc_may_setup');

function moc_may_assets() {
    wp_enqueue_style('moc-may-style', get_stylesheet_uri(), array(), '1.4.0');
    wp_enqueue_script('moc-may-motion', get_template_directory_uri() . '/assets/js/motion.js', array(), '1.2.0', true);
}
add_action('wp_enqueue_scripts', 'moc_may_assets');

function moc_may_register_products() {
    register_post_type('ca_phe', array(
        'labels' => array(
            'name' => __('Sản phẩm chè', 'moc-may'),
            'singular_name' => __('Sản phẩm', 'moc-may'),
            'add_new_item' => __('Thêm sản phẩm chè', 'moc-may'),
            'edit_item' => __('Sửa sản phẩm', 'moc-may'),
            'menu_name' => __('Sản phẩm', 'moc-may'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'san-pham'),
        'menu_icon' => 'dashicons-leaf',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
    ));
}
add_action('init', 'moc_may_register_products');

function moc_may_add_product_details() {
    add_meta_box('moc-may-product-details', __('Thông tin sản phẩm', 'moc-may'), 'moc_may_product_details_box', 'ca_phe', 'normal', 'high');
}
add_action('add_meta_boxes', 'moc_may_add_product_details');

function moc_may_product_details_box($post) {
    wp_nonce_field('moc_may_save_product_details', 'moc_may_product_nonce');
    $fields = array(
        '_moc_price' => __('Giá bán (ví dụ: 185.000đ)', 'moc-may'),
        '_moc_origin' => __('Vùng chè', 'moc-may'),
        '_moc_note' => __('Ghi chú ngắn / hương vị', 'moc-may'),
        '_moc_badge' => __('Nhãn nổi bật', 'moc-may'),
    );
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<p><label for="' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label><br>';
        echo '<input class="widefat" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '"></p>';
    }
}

function moc_may_save_product_details($post_id) {
    if (!isset($_POST['moc_may_product_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['moc_may_product_nonce'])), 'moc_may_save_product_details')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    foreach (array('_moc_price', '_moc_origin', '_moc_note', '_moc_badge') as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }
}
add_action('save_post_ca_phe', 'moc_may_save_product_details');
