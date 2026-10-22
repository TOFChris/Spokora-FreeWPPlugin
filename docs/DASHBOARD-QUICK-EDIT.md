# List Quick Edit — Free now, Pro later

Chris (2026-10-19): Quick Edit for SEO + AI belongs on the **native WordPress Posts / Pages screens** (All Posts, All Pages), the same **Quick Edit** link already under each title. Not on Spokora Home.

---

## Free (done, v0.1.9 on ez.spokora.com)

| | |
|--|--|
| Screen | **Posts → All Posts** and **Pages → All Pages** (any scored public type) |
| UI | Core row **Quick Edit**. Extra fieldset **Spokora — SEO & AI** under the usual title/slug/date fields |
| Save | Same `save_post` handlers as the editor (`spokora_seo_meta_nonce` + `spokora_llms_meta_nonce`) |
| Code | `plugin/spokora-free/includes/class-spokora-list-quick-edit.php` · `assets/js/list-quick-edit.js` |

Fields:

- `_spokora_seo_title`, `_spokora_seo_desc`
- `_spokora_focus_keyword`, `_spokora_additional_keywords`
- `_spokora_content_kind`
- `_spokora_llms_public`, `_spokora_llms_include`, `_spokora_llms_summary`, `_spokora_llms_md`
- `_spokora_seo_score_exclude`

JSON-LD paste, video URL, and **Draft with the model** stay on the full editor.

Spokora Home no longer lists posts for this. An earlier Home-column experiment was removed.

---

## NOTE FOR A LATER AGENT — port to Pro (`spokora-plugin`)

**Shipped Pro 1.5.42 (2026-10-20):** `includes/class-spokora-list-quick-edit.php` · `assets/js/list-quick-edit.js`. Do not put this on the Pro Live Dashboard unless Chris asks again.

Original port checklist (reference):

1. Hook `quick_edit_custom_box` on scoring post types. Hidden payload in the SEO column. Wrap `inlineEditPost.edit` like Free `list-quick-edit.js`.
2. Reuse editor field names + existing `save_post`. After save, `spokora_compute_and_save_scores` already runs from the score module.
3. Pro extras in the same Quick Edit **only if keys exist**: Draft with the model (or a “open editor for AI draft” link), Market Visibility watchlist. Titles must save without vault.
4. Do not add a second post list on the Pro dashboard for this job.
5. Keep confirm-before-overwrite if you add Spokora self-hijack in the same pass (see QUICK-SETUP.md).
