#!/bin/sh
set -eu

WP_PATH=/var/www/html

echo "Đợi WordPress và MySQL sẵn sàng..."
until [ -f "$WP_PATH/wp-includes/version.php" ]; do
    sleep 2
done

mkdir -p "$WP_PATH/wp-content/themes/moc-may"
cp -R /usr/local/share/moc-may/. "$WP_PATH/wp-content/themes/moc-may/"

until wp db check --path="$WP_PATH" >/dev/null 2>&1; do
    sleep 3
done

if ! wp core is-installed --path="$WP_PATH" >/dev/null 2>&1; then
    echo "Khởi tạo website Nương lần đầu..."
    wp core install \
        --path="$WP_PATH" \
        --url="$SITE_URL" \
        --title='Nương' \
        --admin_user="$WP_ADMIN_USER" \
        --admin_password="$WP_ADMIN_PASSWORD" \
        --admin_email="$WP_ADMIN_EMAIL" \
        --skip-email

    wp theme activate moc-may --path="$WP_PATH"
    wp option update blogdescription 'Cà phê đặc sản từ những vùng trồng Việt Nam.' --path="$WP_PATH"
    wp option update timezone_string 'Asia/Ho_Chi_Minh' --path="$WP_PATH"
    wp option update permalink_structure '/%postname%/' --path="$WP_PATH"

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_title='Arabica Sơn La' \
        --post_excerpt='Hương hoa trắng, cam chín và hậu vị mật ong.' \
        --post_content='Arabica từ vùng cao Tà Xùa, được sơ chế cẩn thận và rang sáng để giữ nét hương hoa, cam chín cùng hậu vị mật ong. Hợp pour-over, Aeropress và pha máy nhẹ.' \
        --meta_input='{"_moc_price":"185.000đ / 250 g","_moc_origin":"Tà Xùa · Sơn La","_moc_note":"Hoa trắng · Cam · Mật ong","_moc_badge":"Rang sáng"}'

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_title='Robusta Gia Lai' \
        --post_excerpt='Đậm đà, ngọt dịu, hợp pha phin mỗi sáng.' \
        --post_content='Robusta tuyển chọn từ Ia Grai, Gia Lai. Vị đậm đà, cân bằng với nốt ca cao và hạt dẻ, dành cho phin truyền thống hoặc espresso sữa.' \
        --meta_input='{"_moc_price":"145.000đ / 250 g","_moc_origin":"Ia Grai · Gia Lai","_moc_note":"Ca cao · Hạt dẻ","_moc_badge":"Rang vừa"}'

    wp post create \
        --path="$WP_PATH" --post_type=ca_phe --post_status=publish \
        --post_title='Phin giấy Nương' \
        --post_excerpt='Một tách cà phê Việt gọn nhẹ cho ngày bận rộn.' \
        --post_content='Từng túi phin giấy được chia sẵn từ hạt Robusta rang vừa. Chỉ cần nước nóng và vài phút chờ đợi để có một tách cà phê thơm đậm, tiện mang theo.' \
        --meta_input='{"_moc_price":"95.000đ / hộp 10 túi","_moc_origin":"Cà phê Việt · 10 túi","_moc_note":"Thơm · Gọn · Tiện","_moc_badge":"Pha nhanh"}'

    wp rewrite flush --hard --path="$WP_PATH"
    echo "Website đã sẵn sàng tại $SITE_URL"
else
    echo "Website đã được cài đặt; giữ nguyên dữ liệu và tài khoản hiện có."
fi
