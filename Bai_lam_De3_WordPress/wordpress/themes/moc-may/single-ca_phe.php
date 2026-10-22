<?php
get_header();
while (have_posts()) : the_post();
$origin = get_post_meta(get_the_ID(), '_moc_origin', true);
$price = get_post_meta(get_the_ID(), '_moc_price', true);
$note = get_post_meta(get_the_ID(), '_moc_note', true);
?>
<main id="noi-dung" class="single-product">
    <article class="single-product-inner">
        <span class="eyebrow">Chè Thái Nguyên</span>
        <h1><?php the_title(); ?></h1>
        <?php if (has_excerpt()) : ?><p class="single-product-lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php endif; ?>
        <div class="single-product-details">
            <?php if ($origin) : ?><span>Vùng chè<strong><?php echo esc_html($origin); ?></strong></span><?php endif; ?>
            <?php if ($note) : ?><span>Hương vị<strong><?php echo esc_html($note); ?></strong></span><?php endif; ?>
            <?php if ($price) : ?><span>Giá tham khảo<strong><?php echo esc_html($price); ?></strong></span><?php endif; ?>
        </div>
        <div class="single-product-content"><?php the_content(); ?></div>
        <a class="button back-link" href="<?php echo esc_url(home_url('/#san-pham')); ?>">← Xem các sản phẩm</a>
    </article>
</main>
<?php
endwhile;
get_footer();
