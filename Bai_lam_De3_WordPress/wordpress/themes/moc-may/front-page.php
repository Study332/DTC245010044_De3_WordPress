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
    array('title' => 'Arabica Sơn La', 'origin' => 'Tà Xùa · Sơn La', 'badge' => 'Rang sáng', 'note' => 'Hương hoa trắng, cam chín và hậu vị mật ong.', 'price' => '185.000đ', 'tone' => 'orange', 'pouch' => 'Arabica', 'taste' => 'Hoa · Cam · Mật'),
    array('title' => 'Robusta Gia Lai', 'origin' => 'Ia Grai · Gia Lai', 'badge' => 'Rang vừa', 'note' => 'Đậm đà, ngọt dịu, hợp pha phin mỗi sáng.', 'price' => '145.000đ', 'tone' => 'green', 'pouch' => 'Robusta', 'taste' => 'Ca cao · Hạt dẻ'),
    array('title' => 'Phin giấy Nương', 'origin' => 'Gói tiện lợi · 10 túi', 'badge' => 'Pha nhanh', 'note' => 'Một tách cà phê Việt gọn nhẹ cho ngày bận rộn.', 'price' => '95.000đ', 'tone' => 'rose', 'pouch' => 'Phin giấy', 'taste' => 'Thơm · Gọn · Tiện'),
);
?>
<main id="noi-dung">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-inner">
            <div class="hero-copy-block">
                <span class="eyebrow">Từ nương cà phê Việt</span>
                <h1 id="hero-title">Một tách nhỏ,<br><em>một miền thương.</em></h1>
                <p class="hero-copy">Cà phê đặc sản được tuyển chọn từ những vùng trồng Việt Nam, rang mới theo mẻ nhỏ để giữ trọn hương vị nguyên bản.</p>
                <div class="hero-actions">
                    <a class="button" href="#san-pham">Khám phá sản phẩm <span class="arrow" aria-hidden="true">↗</span></a>
                    <a class="button button--light" href="#cau-chuyen">Câu chuyện của Nương</a>
                </div>
                <div class="hero-note">
                    <span class="note-dots" aria-hidden="true"><span>N</span><span>V</span><span>H</span></span>
                    <span><strong>Thu hoạch theo mùa</strong><br>Trân trọng người trồng và hạt cà phê</span>
                </div>
            </div>
            <div class="hero-visual" aria-label="Minh họa túi cà phê Arabica Sơn La">
                <span class="hero-sun" aria-hidden="true"></span>
                <span class="hero-leaf" aria-hidden="true"></span>
                <div class="hero-pouch" aria-hidden="true">
                    <span class="pouch-seal">N</span>
                    <span class="pouch-origin">Tà Xùa · Sơn La</span>
                    <span class="pouch-name">Arabica<br>Sơn La</span>
                    <span class="pouch-rule"></span>
                    <span class="pouch-taste">Hoa trắng · Cam chín · Mật ong</span>
                    <span class="pouch-weight">Cà phê hạt · 250 g</span>
                </div>
                <span class="hero-sticker">Rang mới<br>mỗi tuần<br>✳</span>
                <span class="hero-index">01 / 03</span>
            </div>
        </div>
    </section>

    <div class="trust-strip" aria-label="Cam kết của Nương">
        <div class="trust-inner">
            <span class="trust-lead">Từ vùng trồng đến tách cà phê</span>
            <span class="trust-item"><b aria-hidden="true">✳</b> Hạt tuyển chọn</span>
            <span class="trust-item"><b aria-hidden="true">⌁</b> Rang mẻ nhỏ</span>
            <span class="trust-item"><b aria-hidden="true">↟</b> Truy xuất nguồn gốc</span>
            <span class="trust-item"><b aria-hidden="true">♡</b> Gói thân thiện</span>
        </div>
    </div>

    <section class="section" id="san-pham" aria-labelledby="products-title">
        <div class="section-inner">
            <div class="section-heading">
                <div><span class="eyebrow">Chọn hương vị của bạn</span><h2 id="products-title">Mỗi vùng đất,<br>một nét riêng.</h2></div>
                <p>Từ vị thanh sáng của Arabica đến nét đậm đà thân thuộc của Robusta — tìm loại cà phê hợp với khoảnh khắc của bạn.</p>
            </div>
            <div class="product-grid">
                <?php foreach ($products as $index => $product) :
                    $origin = get_post_meta($product->ID, '_moc_origin', true) ?: 'Cà phê đặc sản Việt';
                    $badge = get_post_meta($product->ID, '_moc_badge', true) ?: 'Rang mẻ nhỏ';
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
                            <span class="pack" aria-hidden="true"><span class="pouch-seal">N</span><span class="pouch-origin"><?php echo esc_html($origin); ?></span><span class="pouch-name"><?php echo esc_html($pouch_title); ?></span><span class="pouch-rule"></span><span class="pouch-taste"><?php echo esc_html($badge); ?></span><span class="pouch-weight">Cà phê · 250 g</span></span>
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
                            <span class="pack" aria-hidden="true"><span class="pouch-seal">N</span><span class="pouch-origin"><?php echo esc_html($product['origin']); ?></span><span class="pouch-name"><?php echo esc_html($product['pouch']); ?></span><span class="pouch-rule"></span><span class="pouch-taste"><?php echo esc_html($product['taste']); ?></span><span class="pouch-weight">Cà phê · 250 g</span></span>
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
            <p class="products-note">Sản phẩm được rang mới theo mẻ nhỏ. Hương vị có thể thay đổi nhẹ theo mùa thu hoạch.</p>
        </div>
    </section>

    <section class="story section" id="cau-chuyen" aria-labelledby="story-title">
        <div class="story-inner">
            <div class="story-art" role="img" aria-label="Minh họa túi cà phê rang mộc từ vùng cao">
                <div class="story-bag"><div class="story-bag-inner"><span>Thu hoạch mùa mới</span><strong>Rang<br>mộc</strong><span>Việt Nam · 250 g</span></div></div>
                <span class="story-caption">Từ tay người trồng · Đến tay bạn</span>
            </div>
            <div class="story-copy">
                <span class="eyebrow">Câu chuyện của Nương</span>
                <h2 id="story-title">Tôn trọng hạt cà phê, trân trọng người trồng.</h2>
                <p>Nương bắt đầu từ một niềm tin giản dị: cà phê ngon cần một hành trình tử tế. Chúng tôi kết nối với nông hộ, chọn hạt chín đúng vụ và rang vừa đủ để câu chuyện của vùng đất được kể bằng hương vị.</p>
                <div class="story-points">
                    <div class="story-point"><span class="point-number">01</span><span><strong>Chọn theo mùa</strong><span>Ưu tiên quả chín, thu hái cẩn thận.</span></span></div>
                    <div class="story-point"><span class="point-number">02</span><span><strong>Rang có chủ đích</strong><span>Rang mẻ nhỏ, giữ nét riêng của hạt.</span></span></div>
                    <div class="story-point"><span class="point-number">03</span><span><strong>Minh bạch nguồn gốc</strong><span>Ghi rõ vùng trồng trên từng gói.</span></span></div>
                    <div class="story-point"><span class="point-number">04</span><span><strong>Uống theo cách bạn thích</strong><span>Pha phin, pour-over hay pha máy.</span></span></div>
                </div>
                <a class="text-link" href="#pha-ca-phe">Tìm cách pha hợp gu <span class="arrow" aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="brew section" id="pha-ca-phe" aria-labelledby="brew-title">
        <div class="brew-inner">
            <div class="brew-copy">
                <span class="eyebrow">Pha một tách thật ngon</span>
                <h2 id="brew-title">Chậm một chút,<br>thơm lâu hơn.</h2>
                <p>Một công thức pour-over dịu nhẹ để bắt đầu ngày mới. Bạn có thể điều chỉnh lượng nước và thời gian theo khẩu vị riêng.</p>
                <ol class="brew-list">
                    <li><span class="brew-step">01</span><span><strong>Làm nóng dụng cụ</strong>Tráng giấy lọc và làm ấm bình.</span><span class="brew-time">30 giây</span></li>
                    <li><span class="brew-step">02</span><span><strong>Cho cà phê xay vừa</strong>15 g cà phê cho khoảng 240 ml nước.</span><span class="brew-time">1 phút</span></li>
                    <li><span class="brew-step">03</span><span><strong>Rót chậm thành vòng tròn</strong>Nước ở khoảng 92–94°C, chia làm 3 lượt.</span><span class="brew-time">2 phút</span></li>
                    <li><span class="brew-step">04</span><span><strong>Thưởng thức khi còn ấm</strong>Nhấp một ngụm, cảm nhận hương vị đổi dần.</span><span class="brew-time">Tuỳ gu</span></li>
                </ol>
            </div>
            <div class="brew-card" aria-label="Minh họa tách cà phê pour-over">
                <span class="brew-card-label">Gợi ý pha pour-over</span>
                <div class="brew-cup" aria-hidden="true"><span class="brew-steam"></span></div>
                <div class="brew-card-note"><span><strong>15 g : 240 ml</strong><br>Tỉ lệ khởi đầu dễ nhớ</span><span>92–94°C</span></div>
            </div>
        </div>
    </section>

    <section class="contact section" id="lien-he" aria-labelledby="contact-title">
        <div class="contact-inner">
            <div><span class="eyebrow">Bắt đầu từ một cuộc trò chuyện</span><h2 id="contact-title">Bạn muốn tìm gu cà phê của mình?</h2><p>Nương sẵn lòng gợi ý hạt phù hợp, cách pha và lựa chọn quà tặng.</p></div>
            <div class="contact-action"><a class="button" href="mailto:<?php echo esc_attr(antispambot(get_option('admin_email'))); ?>">Gửi lời nhắn <span class="arrow" aria-hidden="true">↗</span></a><small>Phản hồi trong ngày làm việc</small></div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
