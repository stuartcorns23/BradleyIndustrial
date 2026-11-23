# Bradley Industrial 2026 — WordPress theme

Custom classic WordPress theme for Bradley Industrial Services, built from the `website-ideas` design and carrying over the content of the previous site.

## Install

1. Zip this folder (or clone it) into `wp-content/themes/bradley-industrial`.
2. Activate **Bradley Industrial 2026** under Appearance › Themes.

On first activation the theme sets up the site once:

- Pages: **Home** (front page), **About Us**, **Contact Us** (Contact template) and **News & Updates** (posts page). The reading settings are only changed if the site isn't already using a static front page.
- The ten **Services** from the old site, each with its list of what's covered, at `/services/{slug}/` (same URLs as before).
- A **Primary** menu: Home, About Us, Our Services, News & Updates, Contact Us (shown as the red button via the `menu-button` CSS class).

Existing pages or services with the same slug are left untouched. To run the import again, delete the `bi_content_installed` option and re-activate the theme.

Set **Settings › Permalinks** to “Post name” so `/services/` and old post URLs such as `/charity-bike-ride/` keep working.

## Editing

| What | Where |
| --- | --- |
| Phone, email, address, form recipient | Appearance › Customize › Bradley Industrial › Contact details |
| Home page hero, about, testimonial copy and images | Appearance › Customize › Bradley Industrial |
| Services (text, tile colour, icon, order) | Services in the admin menu; “Tile appearance” box and Page Attributes › Order |
| Menus | Appearance › Menus (add CSS class `menu-button` to show an item as a red button) |
| Logo | Appearance › Customize › Site Identity (falls back to the bundled logo) |
| Accreditation logos | `assets/images/accreditations/`, list in `bi_accreditations()` (`inc/template-tags.php`) — filterable via `bi_accreditations` |

The contact form is built in (no plugin needed) and sends with `wp_mail()`. Make sure the server can send mail, ideally through an SMTP plugin. The form is also available as the `[bi_contact_form]` shortcode.

## Structure

```
style.css               theme header + all styles
functions.php           setup, assets
inc/services.php        "service" post type + tile colour/icon meta box
inc/customizer.php      Customizer settings and defaults
inc/contact-form.php    enquiry form + handler
inc/starter-content.php one-off content import on activation
inc/icons.php           inline SVG service icons
inc/template-tags.php   helpers (fallback menu, banners, tiles)
front-page.php          home page
archive-service.php     /services/
single-service.php      a service
page-contact.php        Contact template
index.php / single.php  news listing and posts
```

Fonts: Big Shoulders Display (headings) and Open Sans (body) from Google Fonts.
