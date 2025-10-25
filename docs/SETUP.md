# Eatrofit Setup Guide

## Requirements
- PHP 7.4+
- MySQL 5.0+
- Apache (XAMPP/cPanel/Hostinger)

## Installation
1. Clone repo to your web server directory (e.g., `htdocs/eatrofit`)
2. Import `/sql/schema.sql` into MySQL
3. Update `/config/config.php` with your DB credentials
4. Access frontend via `/public/index.html`
5. Admin panel at `/admin/index.html`

## PWA Features
- Installable via browser (manifest.json)
- Offline support (service worker)
- Push notifications (demo logic)

## CI/CD
- GitHub Actions workflow in `.github/workflows/ci.yml`
