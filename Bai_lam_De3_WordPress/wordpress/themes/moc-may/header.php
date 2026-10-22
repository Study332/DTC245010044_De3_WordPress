<?php
if (!defined('ABSPATH')) {
    exit;
}
$brand_name = get_bloginfo('name') ?: 'Nương';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#noi-dung">Bỏ qua điều hướng</a>
<header class="site-header">
    <div class="header-inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($brand_name); ?> — trang chủ">
            <span class="brand-mark" aria-hidden="true">N</span>
            <span><span class="brand-name"><?php echo esc_html($brand_name); ?></span><span class="brand-caption">Cà phê từ vùng cao</span></span>
        </a>
        <nav class="main-nav" aria-label="Điều hướng chính">
            <?php if (has_nav_menu('primary')) : ?>
                <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1)); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/#san-pham')); ?>">Sản phẩm</a>
                <a href="<?php echo esc_url(home_url('/#cau-chuyen')); ?>">Câu chuyện</a>
                <a href="<?php echo esc_url(home_url('/#pha-ca-phe')); ?>">Cách pha</a>
                <a class="nav-cta" href="<?php echo esc_url(home_url('/#lien-he')); ?>">Liên hệ <span class="arrow" aria-hidden="true">↗</span></a>
            <?php endif; ?>
        </nav>
    </div>
</header>
