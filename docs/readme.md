# Sun Services Inc Website Overview

Welcome to the official website codebase for **Sun Services Inc**, your one–stop solution for residential and commercial services across India. This project delivers a modern, mobile‑friendly and search‑optimised website ready for deployment on Hostinger or any standard LAMP stack.

## What’s Included?

- A **comprehensive public website** with around 50 pages, covering service categories and sub‑services (flooring, cleaning, blinds, curtains, décor, facility management and more), detailed use‑case pages, B2B solutions, city‑specific pages, pricing, blog posts, and essential company information.
- A **lead capture system** that appears as a lightbox on every page, allowing visitors to enquire without leaving the current page. Submitted leads are stored in a database and optionally emailed to your team.
- An **admin panel** for staff to log in, review enquiries, export leads, manage user accounts (add/edit/delete) and change their own password. Simple dashboards provide insight into lead volume and top services.
- **Clean design and responsive layout** that adapts gracefully to mobile phones, tablets and desktops.
- **SEO best practices**: unique meta titles and descriptions for each page, logical URL structure, canonical tags, an automatically generated sitemap and robots directives.
- **Documentation** including this summary, a detailed developer guide, quality assurance report, asset source listing, page inventory CSV and database schema.

## How It Benefits You

- **Lead Generation:** The website is structured to convert visitors into leads through clear calls‑to‑action and easy enquiry submission.
- **Trust & Professionalism:** Proof‑of‑work galleries, detailed service descriptions and frequently asked questions help establish credibility.
- **Scalability:** Modular architecture makes it straightforward to add new services, locations or blog posts without disrupting existing pages.
- **Control:** Through the admin area you can manage enquiries and team members without developer intervention.
- **Search Visibility:** Thoughtful keyword planning and technical SEO ensure your services are discoverable by customers searching online.

## Getting Started

1. **Deploy the site** to your hosting provider. Place the contents of the `sun_services_inc` directory at the web root.
2. **Set up the database** by importing the `db/schema.sql` and `db/seed.sql` files into a new MySQL database. Update the database credentials in `includes/config.php` for both local and production environments.
3. **Log in** to the admin panel at `/admin/login.php` using the default credentials (`admin@sunservicesinc.in` / `admin123`) and change the password immediately.
4. **Review and customise**: update images, adjust service descriptions, set actual pricing and update your contact information and social media links.

## Important Notes

- Passwords are stored in **plain text** as specified by the project requirements. This is not recommended; consider hashing passwords before going live.
- Some images included are placeholders and should be replaced with real photos from your own projects or the provided Google Drive folder.
- The enquiry form includes a consent checkbox for terms and conditions. You should supply appropriate privacy and terms pages.

## Need Help?

Refer to the `readmeDev.md` for detailed technical guidance or contact your development team for assistance. We hope this website helps you showcase your services and grow your business!