# Ngọc Rồng Online (NRO) — Official Web Portal & Billing Gateway

[![PHP](https://img.shields.io/badge/PHP-7.4%2B%20%2F%208.x-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![CSS3](https://img.shields.io/badge/CSS3-Responsive-1572B6?logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)

> Full-featured community web portal, billing gateway, player dashboard, and multi-platform client distribution system for the **Ngọc Rồng Online (Dragon Boy)** MMORPG server.

---

## 1. System Architecture

```mermaid
flowchart TD
    subgraph Browser["Player Web Browser"]
        PortalUI["Community Web Interface"]
        RechargeForm["Card Recharge / Billing Interface"]
        DownloadCenter["Multi-Platform Client Downloads"]
    end

    subgraph MVC["Application Core (PHP MVC)"]
        Router["index.php Routing"]
        Controllers["Controllers/ (Auth, Billing, Rankings)"]
        Pages["Pages/ (View Templates & Dashboards)"]
        ApiEndpoints["Api/ (Card Processing & Webhook Callbacks)"]
    end

    subgraph Database["Data Tier (MySQL)"]
        Accounts[("User Accounts Table")]
        Transactions[("Recharge & Billing Logs")]
        Rankings[("Player Power & Top Clan Stats")]
    end

    subgraph Downloads["Client Distribution Storage"]
        APK["Android APK (nrobt.apk)"]
        IPA["iOS IPA (Nro.ipa)"]
        PC["PC Client (PCBT.rar)"]
    end

    PortalUI --> Router
    RechargeForm --> Router
    DownloadCenter --> Downloads
    Router --> Controllers
    Controllers --> Pages
    Controllers --> ApiEndpoints
    ApiEndpoints --> Database
    Controllers --> Database
```

---

## 2. Key Modules & Features

* **Account Management & Authentication**:
  * Player registration and credential management synchronized directly with the game database.
  * Password hashing and session security.
* **Automated Billing & Card Recharge Gateway**:
  * Integration with telecom scratch card APIs (Viettel, Mobifone, Vinaphone) and payment gateway webhooks.
  * Real-time currency (Ngọc xanh, Thỏi vàng) credited to player accounts upon transaction confirmation.
* **Live Community Leaderboards**:
  * Top Power, Top Level, and Top Clan rankings dynamically queried and cached from MySQL.
* **Multi-Platform Client Distribution**:
  * Hosts verified game client packages for Android (`.apk`), iOS (`.ipa`), and Windows PC (`.rar`).
* **Client-Side Protection**:
  * Security obfuscation (`block.js`) preventing devtools tampering, inspect-element abuse, and automated scrapers.

---

## 3. Tech Stack

| Domain | Technology |
| :--- | :--- |
| **Backend** | PHP 7.4+ / 8.x (MVC pattern) |
| **Database** | MySQL 5.7+ / MariaDB 10.4+ |
| **Frontend** | HTML5, CSS3 Responsive Layout, JavaScript (Vanilla ES6) |
| **Web Server** | Apache (`.htaccess`) & IIS (`web.config`) |

---

## 4. Getting Started

### Prerequisites
- PHP 7.4+ with `pdo_mysql`, `curl`, `json` extensions
- MySQL 5.7+ (running with database matching your game server)
- Web server (Apache, Nginx, or XAMPP)

### Installation
1. Clone the repository into your web root (e.g. `htdocs/`):
   ```bash
   git clone https://github.com/btoan2802/nro-web.git
   ```
2. Configure database credentials in `Bkt.php` or configuration files.
3. Access via browser at `http://localhost/nro-web`.

---

## 5. Author & License

- **Author**: Nguyễn Bảo Toàn ([@btoan2802](https://github.com/btoan2802))
- **License**: Educational / Proprietary
