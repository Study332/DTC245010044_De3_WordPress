#!/bin/sh
set -eu

WP_PATH=/var/www/html

echo "Đợi WordPress và MySQL sẵn sàng..."
until [ -f "$WP_PATH/wp-includes/version.php" ]; do
    sleep 2
done

mkdir -p "$WP_PATH/wp-content/themes/moc-may"
cp -R /usr/local/share/moc-may/. "$WP_PATH/wp-content/themes/moc-may/"

# WP-CLI's `wp db check` calls an external mariadb-check binary, which may
# reject MySQL 8's caching_sha2_password/self-signed local TLS certificate.
# Probe with PHP's mysqli driver, the same driver WordPress uses at runtime.
until php -r '
$parts = explode(":", getenv("WORDPRESS_DB_HOST") ?: "db:3306", 2);
$port = isset($parts[1]) ? (int) $parts[1] : 3306;
$db = mysqli_init();
exit(@mysqli_real_connect(
    $db,
    $parts[0],
    getenv("WORDPRESS_DB_USER"),
    getenv("WORDPRESS_DB_PASSWORD"),
    getenv("WORDPRESS_DB_NAME"),
    $port
) ? 0 : 1);
' >/dev/null 2>&1; do
    sleep 3
done

if ! wp core is-installed --path="$WP_PATH" >/dev/null 2>&1; then
    echo "Khởi tạo website Trà Thái Nguyên lần đầu..."
    wp core install \
        --path="$WP_PATH" \
        --url="$SITE_URL" \
        --title='Trà Thái Nguyên' \
        --admin_user="$WP_ADMIN_USER" \
        --admin_password="$WP_ADMIN_PASSWORD" \
        --admin_email="$WP_ADMIN_EMAIL" \
        --skip-email

    wp theme activate moc-may --path="$WP_PATH"
    wp option update blogdescription 'Khám phá các sản phẩm chè xanh từ Tân Cương và La Bằng, Thái Nguyên.' --path="$WP_PATH"
    wp option update timezone_string 'Asia/Ho_Chi_Minh' --path="$WP_PATH"
    wp option update permalink_structure '/%postname%/' --path="$WP_PATH"

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_name='che-moc-cau-tan-cuong' \
        --post_title='Chè Móc Câu Tân Cương' \
        --post_excerpt='Hương chè xanh rõ nét, vị chát dịu và hậu ngọt.' \
        --post_content='Chè Móc Câu Tân Cương, Thái Nguyên. Gợi ý thưởng thức: tráng ấm, dùng khoảng 5 g chè cho 150 ml nước nóng 80–85°C, hãm ngắn rồi điều chỉnh theo khẩu vị. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' \
        --meta_input='{"_moc_price":"150.000đ / 100 g (tham khảo)","_moc_origin":"Tân Cương · Thái Nguyên","_moc_note":"Chè xanh · Chát dịu · Hậu ngọt","_moc_badge":"Đặc sản vùng chè"}'

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_name='che-non-tom-tan-cuong' \
        --post_title='Chè Nõn Tôm Tân Cương' \
        --post_excerpt='Vị thanh, hương thơm nhẹ, phù hợp nhâm nhi mỗi ngày.' \
        --post_content='Chè Nõn Tôm Tân Cương, Thái Nguyên. Dòng chè xanh có thể pha với nước nóng vừa độ; nên điều chỉnh lượng chè và thời gian hãm theo khẩu vị. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' \
        --meta_input='{"_moc_price":"180.000đ / 100 g (tham khảo)","_moc_origin":"Tân Cương · Thái Nguyên","_moc_note":"Thanh · Thơm · Êm","_moc_badge":"Búp chè tuyển chọn"}'

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_name='che-xanh-la-bang' \
        --post_title='Chè Xanh La Bằng' \
        --post_excerpt='Chén chè xanh mộc mạc, đậm đà theo cách thưởng trà Việt.' \
        --post_content='Chè xanh La Bằng, Thái Nguyên. Sản phẩm được giới thiệu với hương vị mộc mạc, phù hợp thưởng thức nóng hoặc dùng trong sinh hoạt hằng ngày. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' \
        --meta_input='{"_moc_price":"95.000đ / 100 g (tham khảo)","_moc_origin":"La Bằng · Thái Nguyên","_moc_note":"Mộc · Đậm · Dịu","_moc_badge":"Hương vị truyền thống"}'

    wp rewrite flush --hard --path="$WP_PATH"
    echo "Website đã sẵn sàng tại $SITE_URL"
else
    echo "Cập nhật nội dung demo thành chè Thái Nguyên; giữ nguyên các dữ liệu khác."
    wp option update blogname 'Trà Thái Nguyên' --path="$WP_PATH"
    wp option update blogdescription 'Khám phá các sản phẩm chè xanh từ Tân Cương và La Bằng, Thái Nguyên.' --path="$WP_PATH"

    update_demo_product() {
        old_slug="$1"
        new_slug="$2"
        title="$3"
        excerpt="$4"
        content="$5"
        price="$6"
        origin="$7"
        note="$8"
        badge="$9"
        product_id="$(wp post list --path="$WP_PATH" --post_type=ca_phe --name="$old_slug" --field=ID --format=ids)"
        if [ -n "$product_id" ]; then
            wp post update "$product_id" --path="$WP_PATH" --post_name="$new_slug" --post_title="$title" --post_excerpt="$excerpt" --post_content="$content" >/dev/null
            wp post meta update "$product_id" _moc_price "$price" --path="$WP_PATH" >/dev/null
            wp post meta update "$product_id" _moc_origin "$origin" --path="$WP_PATH" >/dev/null
            wp post meta update "$product_id" _moc_note "$note" --path="$WP_PATH" >/dev/null
            wp post meta update "$product_id" _moc_badge "$badge" --path="$WP_PATH" >/dev/null
        fi
    }

    update_demo_product 'arabica-son-la' 'che-moc-cau-tan-cuong' 'Chè Móc Câu Tân Cương' 'Hương chè xanh rõ nét, vị chát dịu và hậu ngọt.' 'Chè Móc Câu Tân Cương, Thái Nguyên. Gợi ý pha: khoảng 5 g chè với 150 ml nước nóng 80–85°C, hãm ngắn và điều chỉnh theo khẩu vị. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' '150.000đ / 100 g (tham khảo)' 'Tân Cương · Thái Nguyên' 'Chè xanh · Chát dịu · Hậu ngọt' 'Đặc sản vùng chè'
    update_demo_product 'robusta-gia-lai' 'che-non-tom-tan-cuong' 'Chè Nõn Tôm Tân Cương' 'Vị thanh, hương thơm nhẹ, phù hợp nhâm nhi mỗi ngày.' 'Chè Nõn Tôm Tân Cương, Thái Nguyên. Dòng chè xanh có thể pha với nước nóng vừa độ; nên điều chỉnh lượng chè và thời gian hãm theo khẩu vị. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' '180.000đ / 100 g (tham khảo)' 'Tân Cương · Thái Nguyên' 'Thanh · Thơm · Êm' 'Búp chè tuyển chọn'
    update_demo_product 'phin-giay-nuong' 'che-xanh-la-bang' 'Chè Xanh La Bằng' 'Chén chè xanh mộc mạc, đậm đà theo cách thưởng trà Việt.' 'Chè xanh La Bằng, Thái Nguyên. Sản phẩm được giới thiệu với hương vị mộc mạc, phù hợp thưởng thức nóng hoặc dùng trong sinh hoạt hằng ngày. Giá và mô tả trên website là thông tin tham khảo cho bài demo.' '95.000đ / 100 g (tham khảo)' 'La Bằng · Thái Nguyên' 'Mộc · Đậm · Dịu' 'Hương vị truyền thống'
    wp rewrite flush --hard --path="$WP_PATH"
    echo "Nội dung website đã chuyển sang chè Thái Nguyên."
fi
