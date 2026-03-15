# PASF-Abong Noga College WordPress Website

Custom WordPress theme and plugin for [PASF-Abong Noga College](https://pasfanc.ac.in/). Replicates the design of the live college website with all sections fully editable from the WordPress admin panel.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- MySQL 5.7+ or MariaDB 10.2+

## Installation

### 1. WordPress Installation (Pre-installed)

WordPress core files are already in this folder. Complete setup:

1. **Create database:** In phpMyAdmin (`http://localhost/phpmyadmin`), create a database named `pasfanc` (or edit `wp-config.php` with your database name)
2. **Configure wp-config.php:** Database settings are pre-set for XAMPP (DB: `pasfanc`, User: `root`, Password: blank). Change if needed.
3. **Run installer:** Visit `http://localhost/pasfanc.ac.in/wp-admin/install.php` to complete the 5-minute setup
4. **For production:** Update `WP_HOME` and `WP_SITEURL` in wp-config.php to `https://pasfanc.ac.in`

### 2. Activate Theme

- The **pasfanc-theme** is pre-installed in `wp-content/themes/pasfanc-theme`
- Go to **Appearance → Themes** and activate **PASF-Abong Noga College**

### 3. Activate Plugin

- The **pasfanc-college** plugin is pre-installed in `wp-content/plugins/pasfanc-college`
- Activate the plugin from **Plugins → Installed Plugins**

### 4. Configuration

1. **Settings → General**
   - Set Site URL to `https://pasfanc.ac.in` for production
   - Set timezone and language

2. **Settings → Permalinks**
   - Choose "Post name" structure
   - Click **Save Changes** (flushes rewrite rules)

3. **Appearance → Customize**
   - Upload logo under **Site Identity**
   - Configure **Top Bar** (email, phone, prospectus URL)
   - Set **Hero** image and text
   - Add **Guiding Principles** (motto, aims, vision, mission)
   - Add **Principal** name, image, and message
   - Add **Why Choose** cards
   - Set **Footer** address and copyright

4. **Appearance → Menus**
   - Create a Primary menu and assign to "Primary Menu"
   - Create a Footer menu and assign to "Footer Menu"

### 5. Create Pages

Create these pages with the given slugs:

- **Home** (slug: `home`) – Set as **Settings → Reading → Your homepage displays**
- **About** (slug: `about`)
- **Contact** (slug: `contact`)
- **Admissions** (slug: `admissions`)
- **Downloads** (slug: `downloads`)
- **AQAR**, **IQAC**, **NAAC**, **NIRF** (under Administration)

## Custom Post Types (Admin)

| CPT | Purpose |
|-----|---------|
| News | Notice board items, news articles |
| Events | College events |
| Gallery | Campus photos (use Gallery Categories) |
| Testimonials | Student quotes |
| Courses | Course listings with subjects |
| Flash News | Ticker announcements on homepage |
| Downloads | Prospectus and PDF documents |

## Customizer Sections

| Section | Editable Fields |
|---------|-----------------|
| Top Bar | Email, Phone, Prospectus, AQAR/IQAC/NAAC/NIRF URLs |
| Hero | Hero image, overlay text |
| Guiding Principles | Motto, 6 aims, Vision, Mission |
| About Section | Founder image |
| Principal | Name, image, message |
| Why Choose | 4 card titles and descriptions |
| Admissions CTA | Heading, text, Apply URL |
| Footer | Address, copyright, Maps URL |

## Security

- Output escaping (`esc_html`, `esc_url`, `esc_attr`) applied throughout
- Input sanitization and nonces on all forms
- X-Content-Type-Options and X-Frame-Options headers
- XML-RPC disabled by plugin

**Recommended post-launch:** Wordfence or Sucuri, limit login attempts, 2FA for admins.

## File Structure

```
pasfanc.ac.in/
├── wp-content/
│   ├── themes/pasfanc-theme/    # Custom theme
│   └── plugins/pasfanc-college/ # Custom plugin
├── README.md
└── .htaccess.example
```

## Support

For issues or customizations, contact the development team.
