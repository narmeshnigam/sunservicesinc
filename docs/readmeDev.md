# Sun Services Inc Website – Developer Handbook

## Overview

This repository contains the complete source code and assets for **Sun Services Inc**, a professional services provider offering residential and commercial solutions across India. The project is built with **PHP (core)**, **MySQL**, **HTML**, **CSS** and **vanilla JavaScript** with no external frameworks. The site is designed to be mobile–first, accessible and search–engine–optimised.

The public site includes around 50 pages covering service categories, sub‑services, use‑cases, B2B solutions, location pages, pricing, blog posts and common informational pages. A robust enquiry system collects leads into a database via a lightbox form on every page. An admin area allows management of leads and users, with CSV exports for both modules.

## Stack & Requirements

- **PHP:** 8.2+ (core, no frameworks)
- **MySQL:** 8.x
- **Apache/Nginx:** tested on Hostinger’s shared hosting environment
- **Vanilla JavaScript:** used for UI interactions (mobile nav toggle, lightbox, dynamic selects)
- **CSS:** single file `/assets/css/site.css` implementing a clean, modern design
- **Images:** stored in `/assets/images/` with WebP and JPEG variants where applicable
- **Time zone:** set to `Asia/Kolkata`

## Directory Structure

```
sun_services_inc/
├── index.php                 # Home page
├── services/                 # Service category & sub‑service pages
│   ├── index.php
│   ├── carpet-flooring.php
│   └── …
├── use-cases/               # Use‑case pages and index
│   ├── index.php
│   └── new-home-handover.php
├── b2b/                     # B2B solution pages and index
│   ├── index.php
│   └── facility-management.php
├── locations/               # Location pages and index
│   ├── index.php
│   └── delhi.php
├── about/                   # About page
├── contact/                 # Contact page
├── pricing/                 # Pricing & packages page
├── blog/                    # Blog index & posts
│   ├── index.php
│   └── top-benefits-cleaning-services.php
├── admin/                   # Admin panel
│   ├── login.php
│   ├── dashboard.php
│   ├── leads.php
│   ├── users.php
│   ├── change_password.php
│   ├── logout.php
│   └── index.php (redirects to dashboard)
├── includes/                # Shared includes
│   ├── header.php
│   ├── footer.php
│   ├── config.php
│   ├── db.php
│   ├── helpers.php
│   ├── auth_guard.php
│   └── lightbox_form.php
├── assets/                  # Front‑end assets
│   ├── css/site.css
│   ├── js/site.js
│   ├── images/
│   ├── icons/
│   └── fonts/
├── db/
│   ├── schema.sql
│   └── seed.sql
├── docs/
│   ├── pages.csv            # Inventory of all pages and metadata
│   ├── asset_sources.md
│   ├── redirects.csv
│   ├── qa_report.md
│   ├── readmeDev.md         # This document
│   └── readme.md            # Summary for stakeholders
├── sitemap.xml              # Generated from pages.csv
├── robots.txt               # Crawler directives
└── .htaccess                # Apache rules (HTTPS redirect, non‑www, etc.)
```

## Environment Configuration

Database credentials are defined in **`includes/config.php`**. The function `ss_get_config()` auto‑detects whether the application is running locally (`localhost` or `127.0.0.1`) or in production, and returns the appropriate credentials. Update the `local` and `production` arrays with your actual database parameters before deployment. The site uses **PDO** with exception handling and prepared statements.

Timezone is set in the enquiry form processing (`date_default_timezone_set('Asia/Kolkata')`) ensuring consistent timestamps.

## Database Schema

The schema (see `db/schema.sql`) defines three tables:

### `users`

| Column        | Type               | Notes                               |
|--------------|--------------------|-------------------------------------|
| id           | INT AUTO_INCREMENT | Primary key                         |
| name         | VARCHAR(100)       | Full name                           |
| email        | VARCHAR(150)       | Unique login email                  |
| password_plain | VARCHAR(255)     | **Plain‑text password** (per client requirement; see security notes) |
| role         | ENUM('Admin','Viewer') | Determines access level         |
| status       | ENUM('Active','Disabled') | Soft delete / disable user    |
| last_login   | DATETIME           | Last login timestamp (nullable)     |
| created_at   | DATETIME           | Created timestamp                   |
| updated_at   | DATETIME           | Updated timestamp                   |

### `leads`

| Column      | Type           | Notes                                 |
|------------|---------------|---------------------------------------|
| id         | INT AUTO_INCREMENT | Primary key                        |
| name       | VARCHAR(100)   | Enquirer’s name                       |
| mobile     | VARCHAR(20)    | 10‑digit mobile number                |
| email      | VARCHAR(150)   | Optional email                        |
| service    | VARCHAR(100)   | Selected service category             |
| sub_service| VARCHAR(100)   | Selected sub‑service (optional)       |
| city       | VARCHAR(100)   | City (optional)                       |
| pincode    | VARCHAR(10)    | 6‑digit pin code (optional)           |
| preferred_at | DATETIME     | Preferred date/time (optional)        |
| message    | TEXT           | Custom message (optional)             |
| source_page| VARCHAR(255)   | Landing page/slug for tracking        |
| created_at | DATETIME       | Lead creation timestamp               |

### `settings`

Provides a flexible key–value store for site configuration (unused in current build but available for future enhancements).

Seed data (`db/seed.sql`) creates one admin user (`admin@sunservicesinc.in` / `admin123`) and two sample leads. **Change the admin password immediately after deployment.**

## Enquiry Form & Lead Capture

The enquiry lightbox appears on every public page. It is loaded via `includes/lightbox_form.php` and inserted into the header. Trigger buttons carry a `data-service` attribute to preselect the service category. Key features:

- **Fields:** name, mobile, email, service, sub‑service (dependent), city, pincode, preferred date/time, message, consent checkbox.
- **Validation:** client‑side via HTML5 attributes and server‑side in `lightbox_form.php`. Mobile numbers must be 10 digits; consent checkbox is mandatory.
- **Database insertion:** uses prepared statements. Timestamps use `NOW()`. On success, an email notification is (optionally) sent using PHP’s `mail()` function (suppressed if disabled on host).
- **Spam protection:** includes a hidden honeypot field and rate limiting can be added if required.
- **Source tracking:** the current page’s URI is stored in `source_page`.

## Admin Panel

All admin pages include `includes/auth_guard.php` which checks for a valid session. Users are redirected to the login page if not authenticated.

### Login (`admin/login.php`)

Allows an authorised administrator to authenticate using their email and **plain‑text** password. On success the session stores the user ID, name and role. A `last_login` timestamp is updated.

### Dashboard (`admin/dashboard.php`)

Provides an at‑a‑glance overview:

- **Lead summary:** counts of leads received today, this week and this month.
- **Top services:** top five services by lead volume.
- **Recent leads:** table showing the latest ten enquiries.

### Leads Management (`admin/leads.php`)

- Search and filter by service, city and date range.
- Pagination (50 records per page).
- **CSV export:** exports filtered results with full details.

### Users Management (`admin/users.php`)

- List all users with their roles and status.
- Add new users or edit existing ones using an accordion‑style form.
- Delete users (hard delete).
- **CSV export** of user data.
- Change password for the currently logged–in user via `admin/change_password.php`.

### Sessions & Security Notes

- Sessions are started on every admin page.
- Plain‑text passwords are stored in the database at the request of the client. This is **not recommended** for production systems. A hash (e.g. `password_hash()` + `password_verify()`) should be used in future.
- CSRF tokens could be added for forms to further harden the system.

## Front‑End Design & UX

- **Responsive layout:** The CSS uses media queries to adapt navigation and columns across devices (mobile, tablet, desktop). The navigation collapses into a hamburger menu on small screens.
- **Colour palette:** Blue and green reflect trust and eco‑friendliness; orange highlights call–to–action buttons.
- **Typography:** System fonts are used for performance. Font sizes and spacing are tuned for readability.
- **Lightbox:** Implemented with basic CSS and JavaScript. The overlay can be dismissed by clicking outside the modal or using the close button.
- **Alt text:** All images include descriptive `alt` attributes for accessibility and SEO.

## SEO Considerations

- Each page defines a unique meta title, description and keywords in `$page_meta` which are output by `includes/header.php`.
- Canonical links prevent duplicate content issues.
- **Breadcrumb JSON‑LD, FAQPage and LocalBusiness schema** can be added easily via additional `<script type="application/ld+json">` blocks if required.
- Clean URLs: pages are stored as `*.php` files in their respective directories (e.g. `/services/carpet-flooring.php`). Use of `.htaccess` ensures HTTPS and non‑www canonicalisation.
- `sitemap.xml` is automatically generated from `docs/pages.csv` and referenced in `robots.txt`.

## Build & Deployment Instructions

1. **Clone or upload** the contents of the `sun_services_inc` directory to your hosting environment. Ensure the root of the domain points to this directory (do **not** put public files inside an additional `public/` folder).
2. **Create a MySQL database** and import the schema:
   ```sql
   SOURCE /path/to/db/schema.sql;
   SOURCE /path/to/db/seed.sql;
   ```
3. **Update configuration** in `includes/config.php` with your database credentials for both local and production arrays.
4. **Set file permissions:** PHP files should be `0644` and directories `0755`.
5. **Test locally** by setting your hosts file or running a local server. The site auto‑detects `localhost` to use the local DB credentials.
6. **Deploy** to Hostinger. Ensure `.htaccess` is honoured (Apache) and PHP 8.2 is selected.
7. **Log in** to the admin panel (`/admin/login.php`) using the seed credentials. Immediately change the password under **Change Password**.
8. **Verify** that enquiry submissions are stored and email notifications are received.
9. **Review and customise** content, images and package pricing as needed.

## Image Workflow

- **Source images:** Many images originate from the provided Google Drive folder (proof‑of‑work photos). They should be manually reviewed and compressed to WebP format before deployment.
- **Placeholder images:** Used where specific photos are not available; can be replaced with real photos later. The placeholder graphic in `/assets/images/service-placeholder.png` is intentionally generic.
- **Logo:** A simple vector‑style logo is provided in `/assets/images/logo.png`. Replace with the official logo when available.

## Testing Checklist

- [x] Navigation links work across all pages and return to the correct sections.
- [x] Lightbox opens and closes properly; form validates both client‑side and server‑side.
- [x] Leads table filters and exports operate without errors.
- [x] User management can add, edit, delete and export users.
- [x] Password change workflow updates the stored plain‑text password.
- [x] Pages render correctly on mobile (360px), tablet (768px) and desktop (1024+px) widths.
- [x] Meta tags and canonical links are set per page; `sitemap.xml` lists all pages.
- [x] `.htaccess` redirects HTTP→HTTPS and removes `www`.
- [x] Robots.txt disallows `/admin/` and references the sitemap.
- [x] 404 errors produce a helpful message (custom 404 page can be added later).

## Future Improvements

- Implement password hashing and token‑based authentication for improved security.
- Add CSRF tokens to all admin forms.
- Integrate Google reCAPTCHA on the enquiry form to reduce spam.
- Build an API endpoint to deliver leads to CRM systems.
- Add a search feature to the public site for better user navigation.
- Extend the blog with categories, tags and comment functionality.
- Create a custom 404 page and error logging system.
- Include multilingual support for Hindi and other regional languages.

---

For questions or further development, please refer to this handbook and the source code. Enjoy building with Sun Services Inc!