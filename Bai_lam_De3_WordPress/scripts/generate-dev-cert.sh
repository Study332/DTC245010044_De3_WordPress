#!/bin/sh
set -eu

ROOT_DIR=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)
CERT_DIR="$ROOT_DIR/nginx/certs"
CERT_FILE="$CERT_DIR/selfsigned.crt"
KEY_FILE="$CERT_DIR/selfsigned.key"

if [ -e "$CERT_FILE" ] || [ -e "$KEY_FILE" ]; then
    echo "Chứng chỉ đã tồn tại trong nginx/certs; xóa cặp cũ trước khi tạo lại." >&2
    exit 1
fi

command -v openssl >/dev/null 2>&1 || {
    echo "Cần cài OpenSSL để tạo chứng chỉ demo." >&2
    exit 1
}

mkdir -p "$CERT_DIR"
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout "$KEY_FILE" \
    -out "$CERT_FILE" \
    -subj "/CN=localhost" \
    -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"

# The key is local, self-signed demo material and is excluded from Git.
# Nginx runs as an unprivileged UID inside the container and must be able to read it.
chmod 0644 "$KEY_FILE" "$CERT_FILE"
echo "Đã tạo chứng chỉ demo tại nginx/certs/; cặp khóa này chỉ dùng cho localhost."
