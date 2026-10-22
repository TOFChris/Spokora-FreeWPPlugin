# Spokora Free vs Spokora Pro — product cut

Locked 2026-10-19 from the Lite/Pro discussion. Module IDs: [`MODULE-CUT.md`](MODULE-CUT.md).

**Free** is a complete SEO plugin. **Pro** is the client week. Same future codebase; this folder is not a fork.

Homepage `#tiers` (theme 1.4.0) describes Free more narrowly (search basics + lean install, roadmap). **This file wins** for what we intend to build. Do not ship Free that is weaker than this cut just because the live bullets are shorter.

---

## Spokora Free

**Job:** Turn off Yoast or Rank Math Free (on a **clean** site) and the public site still has titles, schema, sitemap, and exact 301s — with no Spokora account.

**Who:** Staging a migration, a personal/self-hosted site, later WordPress.org. Not “paywall until they crack.”

**Rules:**

- No license key, no site cap, no vault, no required outbound call to spokora.com.
- Help is local docs. No “connect for support,” no application passwords.
- Front-end SEO, schema, redirects, `/llms.txt` keep working without Pro.
- One quiet upsell on the Spokora menu: SEO is running; unlock the rest of the week.

**In:**

| Surface | Notes |
|---------|--------|
| Titles, meta, canonical, robots | Table stakes |
| JSON-LD + per-page override | Org / Article / LocalBusiness-class graph, not a Rank Math-style schema studio |
| Editor metabox, SERP preview, Search SEO score | People will not leave a traffic light for nothing |
| XML sitemap | So they delete the extra sitemap plugin |
| Exact 301 redirects | Switchers will not move if this is Pro-only |
| Hijack | Yoast / Rank Math / AIOSEO / SEOPress titles, descriptions, exact 301s; **confirm** before deactivating the old plugin |
| Front-end SEO output toggle | Themes that already print schema |
| Quick setup | Fresh → Business Info. **Already have a setup** → backup + Hijack **then** Business Info. Must not stall on empty API fields |
| One-button backups | DB + `wp-content` zip so switchers can protect the site before Hijack. No `wp-config.php` |
| List Quick Edit | Native All Posts / All Pages Quick Edit for SEO + AI fields |
| Cookie consent | Equal Reject / Accept banner. Optional GA only after Accept. Aligns with `web-build/protocols/security-and-privacy.md` |
| `/llms.txt`, `/ai-docs/{slug}.md`, `/md/{slug}.md` | Durable 2026 reason to stay |
| AI-readiness **gauge** | Visible deliverable; generation stays Pro |
| Lean performance | e.g. image width/height — not a cache plugin |

**Out of first Free cut:**

API Vault as a required UI; model-written titles/meta; GSC; rank tracker; X-Ray; spider; backlinks; Media Lab; Social Studio; Site Pulse; Visits; heatmaps; GA4/GTM/pixels; lead inbox / Supabase; Deployment Matrix; MCP; Agent Ready extras; UCP; scheduled/restore-console backups (the one-button zip is Free); Discord; ADA pack; Agency ROI; Shows/Podcasts CPT; shortcodes; seat licensing.

**Gray (not locked):**

| Item | Lean |
|------|------|
| IndexNow ping | **In Free** — a ping, not a product |
| Optional BYOK on Free (paste OpenRouter, generate meta) | **Out of v1** — keep keys as Pro identity |

---

## Spokora Pro

**Job:** What Chris already sells: one plugin for the client week, lifetime seats, BYOK, email support for a year.

**Who:** Agencies and operators who already live in wp-admin. Same buyer as spokora.com.

**In (on top of everything Free does):**

| Surface | Why it is Pro |
|---------|----------------|
| API Vault + `SPOKORA_*` in `wp-config.php` | The commercial differentiator |
| AI generation (SEO + LLMS) from **their** endpoint | No token markup |
| GSC / Search Performance | Their OAuth; we do not broker |
| Rank tracker, X-Ray, backlinks, spider | Their DataForSEO / crawl bill |
| Media Lab | Vision alt + WebP; week deliverable |
| Social Studio | Webhook, not silent auto-post |
| Site Pulse, Visits, heatmaps | Telemetry; privacy/support load |
| Tracking (GA4/GTM/pixels) | Easy to get wrong |
| Lead inbox / router | CRM, not SEO |
| Deployment Matrix | Programmatic pages |
| MCP / Agent Ready extras | 2026 stack after they bought in |
| Agency ROI admin | Firm buyer |
| Extra backups UI, Discord, ADA, Shows CPT, shortcodes | Adjacent. Free already has the one-button zip |
| Seats, My Account zip, email support | The SKU |

**License ethics (Pro only):** failed check-in locks **Spokora admin**, not public title tags / schema / redirects / llms. Never invent that behavior for Free.

---

## What we will not do

- Two plugins, two menus (`spokora-seo` + `spokora`).
- Site cap on Free.
- Nag on every post save.
- Rewrite the homepage H1 into “free Rank Math alternative.”
- Tell a site that activated tainted Rank Math PRO 3.0.123 to “just install Free.”
