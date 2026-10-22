# Keys — three stories, do not mash

Chris called keys the differentiator. They are **Pro’s** differentiator. Free wins by **not needing any**.

---

## 1. Free: no keys

The SEO plugin does not need a Spokora account, an application password, or a license. Titles work on activate + Quick setup.

This is the trust offer during the Rank Math week **and** the boring-year offer vs “connect your SEO plugin to our cloud.”

Hide the vault. Do not show empty GSC / DataForSEO fields.

---

## 2. Pro: bring your own keys

Agencies already pay OpenRouter (or any OpenAI-compatible endpoint), DataForSEO, Google Cloud, Supabase. Spokora does not sell tokens and does not run those models in a Spokora cloud by default.

Paid plugin today: **Spokora → API Vault**, plus `SPOKORA_*` constants documented in `spokora-plugin/SECURITY.md`.

That is the opposite of Yoast AI / Rank Math Content AI **meters**.

---

## 3. Lock secrets on the host

Vault values live in `wp_options` unless overridden. Constants in `wp-config.php` win at runtime; the Vault screen can disable and not echo the secret. A junior cannot copy a production key out of settings as easily.

That is an agency feature a “log into our app” SEO suite cannot honestly claim.

**Honest tradeoff:** GSC on Pro is **harder** than Rank Math or Site Kit because we do not broker OAuth. More setup, smaller blast radius. Say both halves.

---

## v1 Free vs later

| | v1 Free | Later maybe |
|--|---------|-------------|
| Vault UI | Absent | Still Pro |
| Paste own model key to draft meta | **No** | Optional Free switch — anti-account trick; do not do it until Free is keyless and boring |

Security notes that stay true whenever keys exist: backups contain keys; prefer least-privilege; never put a Supabase **service role** in a public site’s vault; `SPOKORA_ALLOW_LOCAL_MODEL` exists because local endpoints are SSRF-shaped.
