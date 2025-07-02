# Seamless QR Code

**Seamless QR Code** is a powerful, all-in-one web platform for creating customizable QR codes, bio link pages, URL shortening, and deploying a suite of web utilities. Designed for flexibility and scalability, it's ideal for creators, marketers, developers, and businesses looking to streamline digital interactions under a single dashboard.

> Developed by **Leoivard Omondi**

---

## 📖 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Updating](#updating)
- [Troubleshooting](#troubleshooting)
- [License](#license)
- [Credits](#credits)

---

## 🚀 Features

- 🌐 **Biolink Pages** – Customizable mini-sites with social links, business hours, video/audio embeds, contact forms, PayPal integration, and more.
- 🔗 **URL Shortener** – Trackable links with traffic analytics and geographic/device targeting.
- 📸 **QR Code Generator** – Multi-style QR generation with logo overlay, export to PNG/JPG/WEBP.
- 🧰 **Web Tools Hub** – 120+ utility tools (text, image, converters, validators, etc.).
- 🧩 **Plugin Architecture** – Extend functionality with optional plugins like Teams, PWA, Push Notifications, Affiliate System, and more.
- ⚙️ **Admin Panel** – Full-featured backend for user management, SMTP configuration, theme control, email templates, and analytics.
- 🎨 **White-Label Support** – Customize branding, footers, email content, and multi-language support.

---

## 📦 Requirements

To run Seamless QR Code, ensure your server meets these prerequisites:

- **PHP 8.1+**
- **MySQL / MariaDB** with InnoDB support
- Apache with `mod_rewrite` or Nginx with equivalent URL rewriting
- Enabled PHP extensions: `mbstring`, `openssl`, `pdo`, `curl`, `gd`, `fileinfo`, `zip`
- Writable directories: `/uploads`, `/cache`, `/logs`
- Cron support for background tasks (e.g., cleanup, statistics)

---

## 🛠️ Installation

1. **Create a database** for the application.
2. **Upload all files** to your server (typically inside the `public_html` or `www` directory).
3. Visit `https://yourdomain.com/install` and follow the on-screen instructions:
   - File permission check
   - Database & admin account setup
   - SMTP configuration
4. After installation:
   - Set up **Cron Jobs** in your server (Admin Panel → Settings → Cron).
   - Remove or restrict access to the `/install` folder.

---

## 📌 Usage

- Access your Admin Dashboard via `https://yourdomain.com/admin`.
- Create or manage:
  - QR Codes
  - Biolinks
  - Shortened URLs
  - Web tools
- Monitor analytics, manage users, customize appearance, and control settings—all via the UI.

---

## ⚙️ Configuration

- **Themes**: Modify or extend from `/themes/` directory or via Admin Panel > Appearance.
- **Custom CSS/JS**: Add global styles/scripts from Admin Panel → Website Settings.
- **SMTP Settings**: Required for password resets, email verification, etc.
- **Branding**: White-label features allow you to customize logos, names, and footers.

---

## 🔄 Updating

To upgrade to a newer version:

1. Backup your **database** and **files**.
2. Replace old files with the new ones (excluding `config.php`).
3. Visit `/update` if a manual update process is included.
4. Clear `/cache/` directory contents after updates.

---

## 🧯 Troubleshooting

| Issue                      | Solution                                                                 |
|---------------------------|--------------------------------------------------------------------------|
| Admin login issues        | Manually reset password in database (`users` table, bcrypt hash).       |
| QR Code not generating    | Ensure `gd` PHP extension is installed and enabled.                     |
| Captcha lockout           | Disable CAPTCHA in database (`settings` table > `captcha` setting).     |
| SMTP not working          | Double-check credentials; test using Admin Panel → SMTP tab.            |
| 404 Errors                | Check `.htaccess` (Apache) or Nginx rewrite configuration.              |

---

## 📝 License

This project is proprietary and was developed by **Leoivard Omondi**. Redistribution or resale without permission is prohibited.

For usage rights or commercial licensing, please contact the author directly.

---

## 👤 Credits

- **Project Author**: Leoivard Omondi  
- **Framework & Libraries**: Bootstrap, jQuery, FontAwesome, PHP GD  
- **Icons & Graphics**: Provided within `/assets/`

---

---

