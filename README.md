# Teba Suci Suite — WordPress theme

Custom WordPress theme for [tebasucisuite.com](https://tebasucisuite.com/), rebuilt from the approved
“Teba Suci Rebuild” design (a single scrolling homepage in olive, forest green and parchment, with
Bellefair and Work Sans type).

**This repository is the theme folder.** On the server it lives at
`wp-content/themes/tebasuci/`. WordPress core, plugins, uploads and the database are not in Git —
only the theme is, so deploying can never overwrite content or plugins.

There is no build step: plain PHP, CSS and JavaScript. What is in Git is exactly what runs.

---

## What the theme includes

| Part | Where it is edited |
| --- | --- |
| Homepage: hero, welcome, highlights band, accommodation list (up to 8 rooms), experience, D’Gadon Cafe, booking banner, gallery (up to 5 photos), location | **Appearance → Customize → Teba Suci Suite** — every text, link and photo, and each section can be switched off |
| Booking engine link, Google Maps link, address, phone, WhatsApp, email, Instagram / Facebook / Tripadvisor | Customize → Teba Suci Suite → **Booking & contact** |
| Header menu and footer “Explore” links | **Appearance → Menus** (locations “Header menu” and “Footer ‘Explore’ links”). Until a menu is assigned, the links from the design are used. Use *Custom Links* such as `/#accommodation`, `/#cafe`, `/#gallery`, `/#location`, `/#contact` to point at homepage sections. |
| Logo image (optional — replaces the text logo) and browser icon | Customize → **Site Identity** |
| Browser-tab title (“Teba Suci Suite \| A Quiet Stay in Ubud, Bali”) | **Settings → General** → Site Title and Tagline |
| Inner pages, blog posts, blog list, search, 404 | Normal WordPress pages and posts, written in the block editor. Pages use the same look automatically; the *Full width (no title)* template is available for pages laid out entirely with blocks. |

Also built in:

- Fonts are self-hosted (no requests to Google), the hero photo and main fonts are preloaded, and
  every photo has responsive sizes.
- Basic SEO tags, social-sharing tags and hotel structured data — printed **only when no SEO plugin
  is active** (Yoast SEO, Rank Math, All in One SEO, SEOPress or The SEO Framework take over
  automatically).
- Accessible markup: skip link, keyboard-friendly mobile menu, visible focus outlines, reduced-motion
  support, “opens in a new tab” hints for screen readers.

### Differences from the design file (intentional)

- **Gallery:** the design’s grid left an empty cell with four photos. The last photo now spans the gap,
  and a fifth photo slot fills the grid exactly.
- **“Book your stay” button:** in the design its text turned the same colour as the button on hover
  (invisible). Olive buttons now turn dark green on hover.

---

## Deploying from GitHub

### Option A — your hosting’s Git deployment (recommended)

Most hosts (Hostinger hPanel → *Advanced → Git*, cPanel → *Git™ Version Control*, and others) can pull
this repository and redeploy on every push. The settings are:

| Setting | Value |
| --- | --- |
| Repository | `https://github.com/akanaradigitalsolutions-cmd/tebasucisuite` (or the SSH form `git@github.com:akanaradigitalsolutions-cmd/tebasucisuite.git`) |
| Branch | `main` |
| Install path / directory | `public_html/wp-content/themes/tebasuci` (adjust if WordPress is not in `public_html`). The folder must be empty or not exist yet. |
| Auto-deploy | Turn on if offered; the host gives a webhook URL to add in GitHub → *Settings → Webhooks*. |

Because the repository is private, the host will show an **SSH deploy key**: add it in GitHub →
repository *Settings → Deploy keys* (read-only is enough).

After the first deployment: WordPress admin → **Appearance → Themes → Teba Suci Suite → Activate**.

### Option B — upload a zip

Every push runs the *Theme checks* workflow (GitHub → *Actions*). It checks the PHP on versions 7.4–8.3
and attaches an installable **tebasuci-theme** zip to the run. Download it and upload it in
**Appearance → Themes → Add New → Upload Theme**.

---

## Before switching the live site

1. **Back up** the current site (files and database) — most hosts have a one-click backup.
2. If the host offers a **staging** copy, activate the theme there first.
3. Replace the four bundled photos with real photos of the property (Customize → each section’s
   *Photo* field). Photos of at least 1920 px wide work best for the hero.
4. Fill in phone, WhatsApp, email and social links under *Booking & contact*.
5. Check existing pages. Content written with the block editor, the classic editor or Elementor keeps
   working. Content built with a theme-specific page builder (for example the builder bundled with
   Avada or Divi) depends on that theme and will need to be rebuilt.
6. Set up the menus if the site needs links beyond the homepage sections.

Switching back to the previous theme is always possible from *Appearance → Themes*.

---

## Files

```
style.css                 Theme header read by WordPress (name, version, requirements)
functions.php             Loads the files in inc/
theme.json                Colours, fonts and widths for the block editor
inc/content.php           Every editable homepage field and its default text
inc/customizer.php        Builds the “Teba Suci Suite” panel in the Customizer
inc/template-tags.php     Helpers: links, photos, menus, icons
inc/setup.php             Theme features, menus, styles/scripts, preloading
inc/seo.php               Fallback SEO/sharing tags and hotel structured data
header.php, footer.php    Site header and footer
front-page.php            Homepage (sections in template-parts/front/)
template-parts/offer.php  Booking banner (homepage and bottom of inner pages)
page.php, single.php      Pages and posts
index.php                 Blog list, archives, search results
404.php, comments.php     Not-found page and comments
page-templates/           “Full width (no title)” page template
assets/css/theme.css      All front-end styles
assets/css/editor.css     Block-editor styles
assets/js/theme.js        Mobile menu and scroll-reveal animation
assets/fonts/             Bellefair and Work Sans (woff2)
assets/images/            Photos used until real ones are chosen in the Customizer
```

Requirements: WordPress 6.0 or newer, PHP 7.4 or newer.

Fonts: Bellefair (Shinntype) and Work Sans (Wei Huang and the Work Sans Project Authors), from Google
Fonts, licensed under the [SIL Open Font License 1.1](https://openfontlicense.org). Icons: shapes from
[Lucide](https://lucide.dev) (ISC licence).
