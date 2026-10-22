# Đề 3 — Website quảng bá sản phẩm bằng WordPress

Repository: [Study332/DTC245010044_De3_WordPress](https://github.com/Study332/DTC245010044_De3_WordPress). Bài làm và cấu hình chạy đầy đủ nằm trong thư mục `Bai_lam_De3_WordPress/`.

## Chạy trên máy local

Yêu cầu Docker Engine, Docker Compose v2 và OpenSSL. Chạy các lệnh:

```bash
cd Bai_lam_De3_WordPress
cp .env.example .env
```

Thông tin đăng nhập demo local mặc định là `admin` / `admin123@` cho WordPress, phpMyAdmin và Grafana. MySQL root dùng tên `root` và mật khẩu `admin123@`; tài khoản exporter nội bộ giữ tên `exporter`. Đây là thông tin công khai trong repository, chỉ dùng cho bài tập trên máy local; không mở stack ra Internet. Sau đó tạo chứng chỉ HTTPS dùng riêng cho localhost và khởi động:

```bash
./scripts/generate-dev-cert.sh
docker compose pull
docker compose up -d
docker compose ps
```

Chờ dịch vụ `wordpress-init` hoàn tất khởi tạo ở lần chạy đầu. Các mật khẩu được đọc từ `.env`.

| Dịch vụ | Địa chỉ |
|---|---|
| Website WordPress | https://localhost |
| Quản trị WordPress | https://localhost/wp-admin |
| phpMyAdmin | http://127.0.0.1:8081 |
| Prometheus | http://127.0.0.1:9090 |
| Grafana | http://127.0.0.1:3000 |

Trình duyệt sẽ cảnh báo vì chứng chỉ self-signed chỉ dành cho localhost. Không dùng chứng chỉ này trên website công khai. Đọc [`Bai_lam_De3_WordPress/README.md`](Bai_lam_De3_WordPress/README.md) để xem kiến trúc, bảo mật, giám sát, LogQL và hướng dẫn xử lý lỗi.

## Dừng hệ thống

```bash
cd Bai_lam_De3_WordPress
docker compose down
```

Lệnh trên giữ lại dữ liệu. `docker compose down -v` sẽ xóa dữ liệu WordPress, MySQL, Grafana, Prometheus và Loki.
