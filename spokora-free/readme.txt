=== Spokora Free ===
Contributors: chrismcmanus
Donate link: https://spokora.com/#licenses
Tags: seo, schema, sitemap, redirects, xml-sitemap
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 0.1.26
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Free SEO, schema, sitemap, and redirects for WordPress websites. No account and no license key.

== Description ==

Spokora Free is a GPL SEO plugin for WordPress websites: titles and meta, JSON-LD schema, an XML sitemap, exact 301 redirects, import from Yoast / Rank Math / AIOSEO / SEOPress, a one-button backup zip, search SEO scoring in the editor, `/llms.txt` and markdown URLs, optional IndexNow pings, an optional cookie banner with optional GA4 after Accept, and light performance helpers.

No Spokora account. No license key. SEO features in this plugin are not locked behind payment.

[Spokora Pro](https://spokora.com) is a **separate** commercial plugin (agency week, API vault, Search Console, rank tracking). Do not run Free and Pro at the same time; Pro already includes this SEO surface.

= Features =

* Titles, meta descriptions, canonical URLs, robots, editor metabox
* JSON-LD schema with site defaults and per-page overrides
* XML sitemap
* Exact 301 redirect rules
* Import titles, descriptions, keyphrases, and exact 301s from major SEO plugins (you confirm before deactivating the old plugin)
* Quick setup wizard (backup first when migrating)
* One-click database + `wp-content` zip (does not include `wp-config.php`)
* Optional cookie banner (off until you turn it on)
* Optional GA4 Measurement ID — loads only after the visitor accepts non-essential cookies
* `/llms.txt`, `/ai-docs/{slug}.md`, `/md/{slug}.md`
* Optional IndexNow pings (off until you turn them on)
* In-editor search SEO score (model drafting stays in Pro)

Product site: [spokora.com](https://spokora.com)
Source: [github.com/TOFChris/Spokora-FreeWPPlugin](https://github.com/TOFChris/Spokora-FreeWPPlugin)

= External services =

This plugin can call **IndexNow** (`https://api.indexnow.org/indexnow`) when you enable **Spokora → Search ping**. That sends the public URL that changed, your site host, and an IndexNow key so participating search engines (not Google) can recrawl. [IndexNow](https://www.indexnow.org/).

If you paste a **Google Analytics 4** Measurement ID and a visitor clicks Accept on the cookie banner, the official gtag script loads from Google (`https://www.googletagmanager.com/gtag/js`). That is your property, not Spokora’s. Analytics stay off until Accept.

Support on WordPress.org: [wordpress.org/support/plugin/spokora-free/](https://wordpress.org/support/plugin/spokora-free/)
Optional extra forum: [forum.spokora.com](https://forum.spokora.com/)

== Installation ==

1. Install from Plugins → Add New, or upload the `spokora-free` folder to `/wp-content/plugins/`.
2. Activate **Spokora Free**. On **multisite**, use **Network Activate** so every site in the network gets SEO, sitemap, redirects, and `/llms.txt`.
3. Open **Spokora → Quick setup** on each site that needs its own Business Info (shop NAP is per site).
4. Optional: **Cookies & privacy** to show a banner; **Search ping** to enable IndexNow.

== Frequently Asked Questions ==

= Does this plugin phone home to spokora.com? =

No. Directory builds update through WordPress.org. Optional emails on spokora.com/updates are a form you fill in yourself.

= Do I need an account or license? =

No for Spokora Free.

= Can I run this next to Spokora Pro? =

No. Activate Pro and leave Free off. Pro includes this SEO layer.

= Does it deactivate Yoast or Rank Math by itself? =

No. Import copies data into Spokora. Deactivating the old plugin is a separate, confirmed step.

= Is the cookie banner required? =

No. It is off on new installs until you enable it under Cookies & privacy.

= Does it work on WordPress multisite / subdomains? =

Yes. Network Activate so each site in the network runs the plugin. Titles, schema, sitemap, redirects, and `/llms.txt` are per site — a shop subdomain keeps its own Business Info. If you use ThreeWP Broadcast, SEO box fields copy with the post. Do not run Free next to Spokora Pro.

== Changelog ==

= 0.1.26 =
* Multisite: Network Activate seeds every site; Broadcast copies hidden SEO/LLMS post meta.

= 0.1.25 =
* Remove “Tested up to” from the plugin PHP header (WordPress.org scan: that field belongs only in readme.txt).

= 0.1.24 =
* WordPress.org Plugin Check: PHPCS fixes (i18n, escaping, redirects, backup export, GA4 enqueue).
* Admin menu icon scaled to match other dashboard icons.

= 0.1.23 =
* Broader Business type list on Quick setup and Business Info (software, trades, retail, and more schema.org types).

= 0.1.22 =
* Encode < and & in JSON-LD so custom schema cannot break out of the script tag.

= 0.1.21 =
* WordPress.org Contributors username: chrismcmanus.

= 0.1.20 =
* WordPress.org-ready: removed custom spokora.com updater and Update URI.
* Text domain `spokora-free`.
* Cookie banner and IndexNow are opt-in.
* Public UI says Import SEO (not Hijack).
* Added readme.txt and license.txt.

= 0.1.19 =
* Stay out of the way when activating Spokora Pro so both plugins are not loaded in the same request.

= 0.1.18 =
* Honest copy about version checks (removed in 0.1.20 for the directory).

== Upgrade Notice ==

= 0.1.26 =
Multisite-ready: Network Activate; SEO fields travel with ThreeWP Broadcast.

= 0.1.25 =
WordPress.org: Tested up to lives only in the readme.

= 0.1.24 =
Plugin Check PHPCS fixes for WordPress.org review.

= 0.1.23 =
More business types in Quick setup and Business Info.

= 0.1.22 =
Submit this build.

= 0.1.21 =
WordPress.org account chrismcmanus.

= 0.1.20 =
Updates now come from WordPress.org. Custom checks against spokora.com are removed. Turn on Search ping or the cookie banner if you still want those.
