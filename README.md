# ĐỀ TÀI THỰC HÀNH: ĐỀ 3 - WEBSITE QUẢNG BÁ SẢN PHẨM (WORDPRESS)
**Môn học:** Triển khai và Quản trị Hệ thống Phần mềm

## Thông tin sinh viên thực hiện
- **Họ và tên:** Quách Minh Hiếu
- **Mã số sinh viên:** DTC245010044
- **Email:** dtc245010044@ictu.edu.vn

## Kiến trúc hệ thống (Docker Compose Stack)
- **Ứng dụng & CSDL:** WordPress + MySQL 8.0 + phpMyAdmin
- **Reverse Proxy & Bảo mật:** Nginx (Unprivileged Non-root, HTTPS Self-Signed SSL, Security Headers)
- **Giám sát (Monitoring):** Prometheus + Grafana + cAdvisor + Node Exporter
- **Quản lý Log (Logging):** Grafana Loki + Promtail (Truy vấn qua LogQL)

## Hướng dẫn cài đặt và khởi chạy
1. Clone repository về máy:
   git clone https://github.com/study332/DTC245010044_De3_WordPress.git
   cd DTC245010044_De3_WordPress

2. Khởi chạy toàn bộ dịch vụ bằng Docker Compose:
   docker compose up -d

3. Kiểm tra trạng thái các container:
   docker compose ps

## Danh sách cổng dịch vụ (Endpoints)
- **Website WordPress (HTTPS):** https://localhost
- **Quản trị CSDL (phpMyAdmin):** http://localhost:8081
- **Prometheus Metrics:** http://localhost:9090
- **Grafana Dashboard & LogQL:** http://localhost:3000
