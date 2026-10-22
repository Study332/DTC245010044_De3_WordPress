<?php
if (!defined('ABSPATH')) {
    exit;
}
$brand_name = get_bloginfo('name') ?: 'Trà Thái Nguyên';
?>
<footer class="site-footer">
    <div class="footer-inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
            <span class="brand-mark" aria-hidden="true">T</span>
            <span><span class="brand-name"><?php echo esc_html($brand_name); ?></span><span class="brand-caption">Chè từ Thái Nguyên</span></span>
        </a>
        <div class="footer-copy">
            <div>Hương chè xanh, trọn vị trà Việt.</div>
            <div class="footer-links"><a href="<?php echo esc_url(home_url('/#san-pham')); ?>">Sản phẩm</a><a href="<?php echo esc_url(home_url('/#lien-he')); ?>">Liên hệ</a></div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
