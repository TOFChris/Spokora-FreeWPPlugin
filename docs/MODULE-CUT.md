# Module cut (IDs from paid plugin)

Source of IDs: `that-one-firm/projects/spokora-plugin/includes/module-manifest.php` and `README.md` (paid **1.5.x**). Do not edit that tree for Lite.

When code happens: **one loader**, Free = these modules allowed without a key; Pro license unlocks the rest. Settings that Hijack needs must work without Vault.

---

## Free (ungated)

| ID | Label | Free notes |
|----|--------|------------|
| `seo` | SEO & schema | Required |
| `metabox` | Page SEO meta box | Required |
| `seo_score` | SEO & AI readiness scores | Gauges + SERP; **generation** stays Pro/`ai` |
| `sitemap` | XML sitemap | Required |
| `redirects` | Redirects | Exact 301s; Hijack target |
| `settings` | Settings UI & migration | Hijack / legacy UX; Quick setup **must not** require keys |
| `llms` | LLMS hub & AI docs | Hub + spokes |
| `markdown` | Markdown | `/md/{slug}.md` list |
| `performance` | Performance | Lean only (dims, etc.) |
| `indexnow` | Search ping | Lean **in** (gray locked toward yes) |
| `backups` | Backups | **Lean in Free:** one-button DB + `wp-content` zip (no `wp-config.php`, scrub vault/license rows). Not scheduled restore UI. |
| `consent` | Cookie consent | **Lean in Free:** UK/GDPR banner, equal Reject / Accept, Consent Mode denied until accept. Optional GA4 ID. Skip if Spokora theme already banners. |

Forced-on in paid today: `settings`, `api_vault`. For Free, **do not force `api_vault`**. Hide or no-op the vault until Pro.

---

## Pro (license)

| ID | Label |
|----|--------|
| `api_vault` | API Vault |
| `ai` | AI content (model drafts) |
| `search_performance` | Search Performance (GSC) |
| `rank_tracker` | Rank tracker |
| `xray` | X-Ray competitor analysis |
| `spider` | Internal link spider |
| `backlinks` | Domain trust / backlinks |
| `auditor` | Local auditor |
| `matrix` | Deployment Matrix |
| `media_lab` | Media Lab |
| `social` | Social Studio |
| `site_pulse` | Site Pulse |
| `visits` | Visits |
| `heatmapper` | Heatmap |
| `tracking` | GA4 / GTM / pixels |
| `lead_router` | Lead router (Supabase) |
| `admin` | Agency admin / ROI |
| `live_dashboard` | Live Dashboard (empty without keys — Pro) |
| `agent_ready` | Agent Ready |
| `mcp` | MCP |
| `ucp` | Universal Commerce Protocol (off unless a commerce pilot) |
| `backups` | Extra backup/restore UI later — Free already ships the one-button zip |
| `tripwire` | Discord telemetry |
| `chatbot` | Admin chat → Discord |
| `ada` | ADA assists |
| `cpt` | Shows & Podcasts |
| `shortcodes` | Shortcodes |

---

## Hijack / legacy (not a module ID)

Paid: `includes/legacy-seo-plugins.php`, `modules/class-spokora-legacy-import.php`, settings engine. **Free must ship this.** It is the switcher. Confirm-before-deactivate. Pattern/temporary redirects stay out (same as current Hijack).

---

## Do not leak into Free Quick setup

Vault fields, GSC OAuth, DataForSEO, Discord, Supabase. Empty telemetry screens are already a known cold-start problem on Pro. Free must not inherit a wall of dead dashboards.
