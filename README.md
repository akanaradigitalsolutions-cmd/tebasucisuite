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
| The nav pages: **Accommodation, each Room, Gallery, D’Gadon Cafe, Location, Contact, Special Offer** | Built-in **page templates** in the new design, pre-filled with the property’s own content (see *The inner pages* below). |
| Blog posts, blog list, search, 404, and any other page | Normal WordPress pages/posts in the block editor. They use the same look automatically; the *Full width (no title)* template is available for pages laid out entirely with blocks. |

Also built in:

- Fonts are self-hosted (no requests to Google), the hero photo and main fonts are preloaded, and
  every photo has responsive sizes.
- Basic SEO tags, social-sharing tags and hotel structured data — printed **only when no SEO plugin
  is active** (Yoast SEO, Rank Math, All in One SEO, SEOPress or The SEO Framework take over
  automatically).
- Accessible markup: skip link, keyboard-friendly mobile menu, visible focus outlines, reduced-motion
  support, “opens in a new tab” hints for screen readers.

### The inner pages (multi-page setup)

The site is multi-page, like the original. The homepage is the landing page, and each nav item is its
own page in the new design. The theme ships a **template** for each one, already filled with the
content pulled from the live site (room descriptions, amenities, specs, the cafe text, location
landmarks, contact details and the special-offer packages).

**One-time setup** — assign each template to its page. In WordPress: **Pages** → open (or Quick Edit)
the page → set **Template** → **Update**. Reuse the existing pages so the URLs stay the same:

| Page (existing URL) | Template to choose |
| --- | --- |
| `/accomodation/` | **Accommodation** |
| each room: `/one-bedroom-jungle-view/`, `/onebedroomricefieldview/`, `/onebedroomprivatekitchenwithricefieldview/`, `/one-bedroom-villa-private-pool/`, `/2-bedroom-villa-garden-view/` | **Room (single room)** |
| `/gallery/` | **Gallery** |
| `/dgadoncafe/` | **D’Gadon Cafe** |
| `/location/` | **Location** |
| `/contact/` | **Contact** |
| `/specialoffer/` | **Special Offer** |

The **Room** template knows which room to show by matching the page’s URL to the room links in
*Customize → Teba Suci Suite → Accommodation*. Room names, photos, rates and booking links live there;
the longer descriptions and amenities are set from the live-site content.

The **Contact** page includes a simple working message form (sent to the admin email under
*Settings → General*). To use a form plugin instead, drop its shortcode into the page content.

### Differences from the design file (intentional)

- **Gallery:** the design’s grid left an empty cell with four photos. The last photo now spans the gap,
  and a fifth photo slot fills the grid exactly.
- **“Book your stay” button:** in the design its text turned the same colour as the button on hover
  (invisible). Olive buttons now turn dark green on hover.

---

## Deploying on Hostinger (Git)

Hostinger hPanel can pull this repository straight into the theme folder.

1. hPanel → your site → **Advanced → GIT**.
2. **Create a new repository**:
   | Field | Value |
   | --- | --- |
   | Repository | `git@github.com:akanaradigitalsolutions-cmd/tebasucisuite.git` |
   | Branch | `claude/festive-heisenberg-fc7ssv` (or `main` once it exists) |
   | Directory | `public_html/wp-content/themes/tebasuci` |
3. The repository is **private**, so Hostinger shows an **SSH/deploy key**. Copy it, then in GitHub
   open the repo → **Settings → Deploy keys → Add deploy key**, paste it, and save (read-only is fine).
   Back in hPanel, finish creating the repository — it clones into the theme folder.
4. (Optional) In the same GIT page, enable **Auto-deployment** and add the webhook URL it gives you to
   GitHub → repo **Settings → Webhooks**. After that, every push redeploys automatically; otherwise
   click **Deploy** in hPanel after each change.
5. WordPress admin → **Appearance → Themes → Teba Suci Suite → Activate**.
6. Purge caches so the new look shows: **LiteSpeed Cache → Toolbox → Purge All**, and if Cloudflare is
   on, purge it too (Cloudflare plugin → **Purge Everything**).

### Option B — upload a zip (no Git)

Every push also builds an installable zip: GitHub → **Actions** → latest run → **tebasuci-theme**
artifact. Download it and upload under **Appearance → Themes → Add New → Upload Theme**.

## Your current plugins

The theme was built to sit alongside what the site already runs:

- **Elementor / Elementor Pro / ElementsKit** — Elementor pages keep working under any theme, so your
  existing inner pages (rooms, cafe, contact, special offer) stay intact. **Important:** if you built a
  site-wide **Header or Footer in Elementor Pro → Templates → Theme Builder**, it will replace this
  theme’s own header/footer (which are part of the design). Check Theme Builder after activating; if the
  header/footer look wrong or doubled, disable those Elementor templates so the theme’s own ones show.
  The new homepage is drawn by the theme (`front-page.php`), so it takes over from the old Elementor
  homepage automatically — the old homepage content is kept, just no longer shown.
- **Yoast SEO** — the theme detects Yoast and steps back, so titles, meta and sharing tags stay 100%
  Yoast’s. (The theme’s own SEO tags only appear if no SEO plugin is active.)
- **LiteSpeed Cache** — purge all after each deploy (see step 6 above).
- **Chaty** (floating WhatsApp/chat), **3D FlipBook/dFlip**, **Really Simple SSL**, **Cloudflare**,
  **Hostinger tools** — all work independently of the theme; no change needed.

---

## Before switching the live site

The theme already ships with the real photos, rooms, offer and contact details pulled from the live
site, so it looks finished the moment it is activated. Before flipping the live site:

1. **Back up** first — hPanel → **Files → Backups** (or **Websites → Manage → Backups**).
2. Use a **staging** copy if you can — hPanel → **WordPress → Staging**. Activate the theme there,
   check the homepage and a few inner pages, then push staging to live.
3. Add your **Instagram and Tripadvisor** links under *Customize → Teba Suci Suite → Booking & contact*
   (these could not be read from the live site). Everything else — rooms, photos, offer, phone,
   WhatsApp, email, address, map — is already filled in and can be changed in the same place.
4. Check the Elementor Theme Builder header/footer note under **Your current plugins** above.
5. Set up the **menus** (Appearance → Menus) if you want links beyond the homepage sections — for
   example a *Special Offer* item.
6. Purge **LiteSpeed Cache** (and Cloudflare) after activating.

Switching back to the previous theme is always possible from *Appearance → Themes* — nothing is
deleted.

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
