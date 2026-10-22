<?php
if (!defined('ABSPATH')) {
    exit;
}
$brand_name = get_bloginfo('name') ?: 'Nương';
?>
<footer class="site-footer">
    <div class="footer-inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
            <span class="brand-mark" aria-hidden="true">N</span>
            <span><span class="brand-name"><?php echo esc_html($brand_name); ?></span><span class="brand-caption">Cà phê từ vùng cao</span></span>
        </a>
        <div class="footer-copy">
            <div>Hạt cà phê tử tế, rang mới mỗi ngày.</div>
            <div class="footer-links"><a href="<?php echo esc_url(home_url('/#san-pham')); ?>">Sản phẩm</a><a href="<?php echo esc_url(home_url('/#lien-he')); ?>">Liên hệ</a></div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
