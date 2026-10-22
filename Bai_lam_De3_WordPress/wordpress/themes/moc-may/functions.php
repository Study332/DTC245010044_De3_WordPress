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

function moc_may_tea_leaf_icon($variant = 'cluster') {
    if ($variant === 'brand') {
        ?>
        <svg class="tea-leaf-icon tea-leaf-branch" viewBox="0 0 52 42" aria-hidden="true" focusable="false">
            <path class="tea-leaf-shape" d="M26 25C18.8 15.8 10.7 12.5 4.5 13.4c.8 9.2 6.6 15.2 15.3 16.1 2.5.2 4.6-1.4 6.2-4.5Z" />
            <path class="tea-leaf-shape" d="M26 29.1c6.3-9.5 14.3-13.2 21-12.2-.7 9.5-6.7 15.9-15.8 16.7-2.5.2-4.4-1.4-5.2-4.5Z" />
            <path class="tea-leaf-vein" d="M26 39C26.1 33.5 26.1 27.9 26 21.3M25.7 25.6C19.3 20 12.9 16.6 5.2 14.2m21.4 14.7c6-5.2 12.8-9.2 19.4-11.4" />
        </svg>
        <?php
        return;
    }
    ?>
    <svg class="tea-leaf-icon" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        <g class="tea-leaf-cluster">
            <path class="tea-leaf-shape" d="M11.5 23.2C6.4 23.7 3.9 21.2 3.8 16.2c4.8-.4 8.5 1.1 9.7 4.3.3 1.2-.7 2.2-2 2.7Z" />
            <path class="tea-leaf-shape" d="M17.2 16.6c-.1-4.7 2.3-8.1 7.4-9.2 1.2 4.7-.8 8.6-5.1 10-.9.1-1.7-.2-2.3-.8Z" />
            <path class="tea-leaf-shape" d="M21.7 10.1c-3.9-1.9-4.7-4.9-2.7-7.7 4.5.8 7 3.5 6.2 6.5-.7 1.2-2.1 1.6-3.5 1.2Z" />
            <path class="tea-leaf-vein" d="M7.2 26.8c4.2-4.3 10.4-11.5 17.6-21.1M12.7 21.1c-2.4-1.6-4.9-3.4-8-4.6m13.5.1c1.8-2.4 3.8-5.1 6-7.8m-2.5.8c-1.8-.8-3.5-2.1-4.9-4.1" />
        </g>
    </svg>
    <?php
}

function moc_may_assets() {
    wp_enqueue_style('moc-may-style', get_stylesheet_uri(), array(), '1.6.0');
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
