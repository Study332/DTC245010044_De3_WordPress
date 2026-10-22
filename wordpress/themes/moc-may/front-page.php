<?php
get_header();
$products = get_posts(array(
    'post_type' => 'ca_phe',
    'post_status' => 'publish',
    'numberposts' => 3,
    'orderby' => 'menu_order ID',
    'order' => 'ASC',
));
$fallback_products = array(
    array('title' => 'Chè Móc Câu Tân Cương', 'origin' => 'Tân Cương · Thái Nguyên', 'badge' => 'Đặc sản vùng chè', 'note' => 'Hương chè xanh rõ nét, vị chát dịu và hậu ngọt.', 'price' => '150.000đ / 100 g', 'tone' => 'orange', 'pouch' => 'Móc Câu', 'taste' => 'Xanh · Dịu · Hậu ngọt'),
    array('title' => 'Chè Nõn Tôm Tân Cương', 'origin' => 'Tân Cương · Thái Nguyên', 'badge' => 'Búp chè tuyển chọn', 'note' => 'Vị thanh, hương thơm nhẹ, phù hợp nhâm nhi mỗi ngày.', 'price' => '180.000đ / 100 g', 'tone' => 'green', 'pouch' => 'Nõn Tôm', 'taste' => 'Thanh · Thơm · Êm'),
    array('title' => 'Chè Xanh La Bằng', 'origin' => 'La Bằng · Thái Nguyên', 'badge' => 'Hương vị truyền thống', 'note' => 'Chén chè xanh mộc mạc, đậm đà theo cách thưởng trà Việt.', 'price' => '95.000đ / 100 g', 'tone' => 'rose', 'pouch' => 'Chè Xanh', 'taste' => 'Mộc · Đậm · Dịu'),
);
?>
<main id="noi-dung">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-inner">
            <div class="hero-copy-block">
                <span class="eyebrow">Hương chè từ Thái Nguyên</span>
                <h1 id="hero-title">Một ấm chè xanh,<br><em>một miền hương.</em></h1>
                <p class="hero-copy">Khám phá chè Thái Nguyên với những lựa chọn từ Tân Cương và La Bằng. Thông tin vùng chè, hương vị và cách pha được giới thiệu rõ ràng cho người yêu trà.</p>
                <div class="hero-actions">
                    <a class="button" href="#san-pham">Khám phá sản phẩm <span class="arrow" aria-hidden="true">↗</span></a>
                    <a class="button button--light" href="#cau-chuyen">Câu chuyện vùng chè</a>
                </div>
                <div class="hero-note">
                    <span class="note-dots" aria-hidden="true"><span>T</span><span>C</span><span>L</span></span>
                    <span><strong>Trà từ vùng chè</strong><br>Trân trọng người làm chè Thái Nguyên</span>
                </div>
            </div>
            <div class="hero-visual" aria-label="Minh họa gói chè Móc Câu Tân Cương">
                <span class="hero-sun" aria-hidden="true"></span>
                <span class="hero-leaf" aria-hidden="true"></span>
                <div class="hero-pouch" aria-hidden="true">
                    <span class="pouch-seal">T</span>
                    <span class="pouch-origin">Tân Cương · Thái Nguyên</span>
                    <span class="pouch-name">Chè Móc Câu<br>Tân Cương</span>
                    <span class="pouch-rule"></span>
                    <span class="pouch-taste">Chè xanh · Chát dịu · Hậu ngọt</span>
                    <span class="pouch-weight">Chè xanh · 100 g</span>
                </div>
                <span class="hero-sticker">Hương chè<br>Thái Nguyên<br>✳</span>
                <span class="hero-index">01 / 03</span>
            </div>
        </div>
    </section>

    <div class="trust-strip" aria-label="Thông tin sản phẩm chè">
        <div class="trust-inner">
            <span class="trust-lead">Từ vùng chè đến ấm trà</span>
            <span class="trust-item"><b aria-hidden="true">✳</b> Chè Thái Nguyên</span>
            <span class="trust-item"><b aria-hidden="true">⌁</b> Nhiều dòng chè</span>
            <span class="trust-item"><b aria-hidden="true">↟</b> Ghi rõ vùng chè</span>
            <span class="trust-item"><b aria-hidden="true">♡</b> Gợi ý cách pha</span>
        </div>
    </div>

    <section class="section" id="san-pham" aria-labelledby="products-title">
        <div class="section-inner">
            <div class="section-heading">
                <div><span class="eyebrow">Khám phá sản phẩm</span><h2 id="products-title">Chè Thái Nguyên,<br>nhiều nét hương.</h2></div>
                <p>Từ chè Móc Câu, Nõn Tôm ở Tân Cương đến chè xanh La Bằng — chọn hương vị hợp với ấm trà và khoảnh khắc của bạn.</p>
            </div>
            <div class="product-grid">
                <?php foreach ($products as $index => $product) :
                    $origin = get_post_meta($product->ID, '_moc_origin', true) ?: 'Thái Nguyên';
                    $badge = get_post_meta($product->ID, '_moc_badge', true) ?: 'Chè Thái Nguyên';
                    $note = get_the_excerpt($product) ?: get_post_meta($product->ID, '_moc_note', true);
                    $price = get_post_meta($product->ID, '_moc_price', true) ?: 'Liên hệ';
                    $tone = array('orange', 'green', 'rose')[$index % 3];
                    $url = get_permalink($product);
                    $title = get_the_title($product);
                    $excerpt = $note;
                    $pouch_title = $title;
                ?>
                    <article class="product-card">
                        <a class="product-art product-art--<?php echo esc_attr($tone); ?>" href="<?php echo esc_url($url); ?>" aria-label="Xem <?php echo esc_attr($title); ?>">
                            <span class="pack" aria-hidden="true"><span class="pouch-seal">T</span><span class="pouch-origin"><?php echo esc_html($origin); ?></span><span class="pouch-name"><?php echo esc_html($pouch_title); ?></span><span class="pouch-rule"></span><span class="pouch-taste"><?php echo esc_html($badge); ?></span><span class="pouch-weight">Chè xanh · 100 g</span></span>
                            <span class="product-number">0<?php echo esc_html((string) ($index + 1)); ?> / 03</span>
                        </a>
                        <div class="product-info">
                            <div class="product-meta"><span><?php echo esc_html($origin); ?></span><span class="product-badge"><?php echo esc_html($badge); ?></span></div>
                            <h3><a href="<?php echo esc_url($url); ?>" style="text-decoration:none"><?php echo esc_html($title); ?></a></h3>
                            <p><?php echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt), 14)); ?></p>
                            <div class="product-bottom"><span class="product-price"><?php echo esc_html($price); ?></span><a class="text-link" href="<?php echo esc_url($url); ?>">Tìm hiểu <span class="arrow" aria-hidden="true">↗</span></a></div>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if (empty($products)) : foreach ($fallback_products as $index => $product) : ?>
                    <article class="product-card">
                        <a class="product-art product-art--<?php echo esc_attr($product['tone']); ?>" href="#lien-he" aria-label="Tìm hiểu <?php echo esc_attr($product['title']); ?>">
                            <span class="pack" aria-hidden="true"><span class="pouch-seal">T</span><span class="pouch-origin"><?php echo esc_html($product['origin']); ?></span><span class="pouch-name"><?php echo esc_html($product['pouch']); ?></span><span class="pouch-rule"></span><span class="pouch-taste"><?php echo esc_html($product['taste']); ?></span><span class="pouch-weight">Chè xanh · 100 g</span></span>
                            <span class="product-number">0<?php echo esc_html((string) ($index + 1)); ?> / 03</span>
                        </a>
                        <div class="product-info">
                            <div class="product-meta"><span><?php echo esc_html($product['origin']); ?></span><span class="product-badge"><?php echo esc_html($product['badge']); ?></span></div>
                            <h3><?php echo esc_html($product['title']); ?></h3>
                            <p><?php echo esc_html($product['note']); ?></p>
                            <div class="product-bottom"><span class="product-price"><?php echo esc_html($product['price']); ?></span><a class="text-link" href="#lien-he">Tìm hiểu <span class="arrow" aria-hidden="true">↗</span></a></div>
                        </div>
                    </article>
                <?php endforeach; endif; ?>
            </div>
            <p class="products-note">Giá hiển thị là giá tham khảo cho website demo; vui lòng liên hệ để xác nhận giá bán và thông tin từng lô chè.</p>
        </div>
    </section>

    <section class="story section" id="cau-chuyen" aria-labelledby="story-title">
        <div class="story-inner">
            <div class="story-art" role="img" aria-label="Minh họa gói chè xanh Thái Nguyên">
                <div class="story-bag"><div class="story-bag-inner"><span>Vùng chè Thái Nguyên</span><strong>Chè<br>xanh</strong><span>Thái Nguyên · 100 g</span></div></div>
                <span class="story-caption">Từ vùng chè · Đến ấm trà nhà</span>
            </div>
            <div class="story-copy">
                <span class="eyebrow">Câu chuyện vùng chè</span>
                <h2 id="story-title">Chè Thái Nguyên, đậm tình đất và người.</h2>
                <p>Thái Nguyên được biết đến với những vùng chè như Tân Cương và La Bằng. Mỗi sản phẩm giới thiệu rõ vùng chè, dòng chè và gợi ý pha để bạn dễ chọn một ấm trà hợp khẩu vị.</p>
                <div class="story-points">
                    <div class="story-point"><span class="point-number">01</span><span><strong>Khám phá vùng chè</strong><span>Tìm hiểu các dòng chè Tân Cương, La Bằng.</span></span></div>
                    <div class="story-point"><span class="point-number">02</span><span><strong>Chọn dòng chè hợp gu</strong><span>Móc Câu, Nõn Tôm hay chè xanh truyền thống.</span></span></div>
                    <div class="story-point"><span class="point-number">03</span><span><strong>Thông tin rõ ràng</strong><span>Ghi vùng chè và khối lượng tham khảo.</span></span></div>
                    <div class="story-point"><span class="point-number">04</span><span><strong>Pha theo khẩu vị</strong><span>Điều chỉnh nhiệt độ và thời gian hãm.</span></span></div>
                </div>
                <a class="text-link" href="#pha-che">Tìm cách pha hợp gu <span class="arrow" aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="brew section" id="pha-che" aria-labelledby="brew-title">
        <div class="brew-inner">
            <div class="brew-copy">
                <span class="eyebrow">Gợi ý pha chè xanh</span>
                <h2 id="brew-title">Nước vừa độ,<br>hương chè tròn vị.</h2>
                <p>Cách pha tham khảo cho một ấm chè xanh. Hãy điều chỉnh lượng chè, nhiệt độ và thời gian hãm theo khẩu vị của bạn.</p>
                <ol class="brew-list">
                    <li><span class="brew-step">01</span><span><strong>Làm nóng ấm chén</strong>Tráng ấm và chén bằng nước nóng.</span><span class="brew-time">30 giây</span></li>
                    <li><span class="brew-step">02</span><span><strong>Cho chè vào ấm</strong>Dùng khoảng 5 g chè cho 150 ml nước.</span><span class="brew-time">Tuỳ gu</span></li>
                    <li><span class="brew-step">03</span><span><strong>Rót nước nóng vừa độ</strong>Thử ở khoảng 80–85°C để hương vị dịu hơn.</span><span class="brew-time">20–30 giây</span></li>
                    <li><span class="brew-step">04</span><span><strong>Rót trà ra chén</strong>Không ngâm lá quá lâu; điều chỉnh lần pha sau.</span><span class="brew-time">Thưởng thức</span></li>
                </ol>
            </div>
            <div class="brew-card" aria-label="Minh họa ấm trà xanh">
                <span class="brew-card-label">Gợi ý pha chè xanh</span>
                <div class="brew-cup" aria-hidden="true"><span class="brew-steam"></span></div>
                <div class="brew-card-note"><span><strong>5 g : 150 ml</strong><br>Tỉ lệ tham khảo ban đầu</span><span>80–85°C</span></div>
            </div>
        </div>
    </section>

    <section class="contact section" id="lien-he" aria-labelledby="contact-title">
        <div class="contact-inner">
            <div><span class="eyebrow">Bắt đầu từ một cuộc trò chuyện</span><h2 id="contact-title">Bạn muốn chọn chè Thái Nguyên?</h2><p>Liên hệ để hỏi thêm về dòng chè, khối lượng, giá bán và lựa chọn quà tặng.</p></div>
            <div class="contact-action"><a class="button" href="mailto:<?php echo esc_attr(antispambot(get_option('admin_email'))); ?>">Gửi lời nhắn <span class="arrow" aria-hidden="true">↗</span></a><small>Phản hồi trong ngày làm việc</small></div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
