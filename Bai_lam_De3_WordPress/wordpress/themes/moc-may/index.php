<?php
get_header();
?>
<main id="noi-dung" class="single-product">
    <div class="single-product-inner">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>><span class="eyebrow">Từ Nương</span><h1><a href="<?php the_permalink(); ?>" style="text-decoration:none"><?php the_title(); ?></a></h1><?php the_excerpt(); ?></article>
        <?php endwhile; else : ?>
            <div class="not-found"><div><span class="eyebrow">Chưa tìm thấy nội dung</span><h1>Trang này đang vắng.</h1><a class="button" href="<?php echo esc_url(home_url('/')); ?>">Về trang chủ</a></div></div>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
