# Home / Dashboard blurb copy

**For agents:** Edit the **Approved copy** sections below. After Chris approves, sync the same paragraphs into PHP (paths in each section). Do not change dismiss behavior or tab URLs without Chris.

---

## Spokora Free — **Spokora → Home**

**PHP:** `plugin/spokora-free/includes/home-intro.php` (`spokora_get_home_intro_copy()`)

**UI:** Yellow dismissible box above Quick setup / “What is running”. Snooze **30 days**, then it returns.

### Approved copy

**Paragraph 1**

This one is on the house. Titles, schema, sitemap, redirects — the SEO stack, no meter, no account. You do not register this site and you do not need a key. The plugin still checks spokora.com for a newer zip when you open Plugins or tap Check for updates. That is a version check, not a login. After we list on WordPress.org, you can also use automatic updates like any other .org plugin. Optional: sign up so we can email you when a build ships.

**Paragraph 2**

If it saves you a headache, the kindest thank-you is a Pro license when you need the rest of a client week. If you like it, leave us a review. If you just want to buy the next pot of coffee, that works too. Old school. We still notice.

**Sign-off**

— Chris, That One Firm

### Tabs (labels fixed; URLs in `admin-ui-helpers.php`)

| Label | Purpose |
|-------|---------|
| Sign up for updates | `/updates/#signup` |
| Support | forum.spokora.com |
| Updates | spokora.com/updates |
| Leave a review | WP.org reviews URL |

---

## Spokora Pro — **Spokora → Dashboard**

**PHP:** `spokora-plugin/includes/dashboard-intro.php` (`spokora_get_dashboard_intro_copy()`)

**UI:** Same yellow box pattern, placed **below the dashboard header** and **above** Agency ROI, Friday proof, Agent Ready, and the “Open API Vault” ready cards.

**Hidden on** spokora.com (license store). Snooze **30 days** per user.

### Approved copy (draft — Chris / Free agent may revise)

**Paragraph 1**

This is your Spokora command screen. Core SEO is already on the site; the numbers at the top stay quiet until you connect Search Console or rank tracking in **API Vault**—only when you want clicks and keyword trends here.

**Paragraph 2**

Your license includes updates from spokora.com. When a new version ships, use **Plugins** or **Dashboard → Updates** on this site (same as any WordPress plugin).

**Sign-off** *(optional — leave empty in PHP to hide)*

— Chris, That One Firm

### Tabs

| Label | Target |
|-------|--------|
| Support | https://forum.spokora.com/ |
| API Vault | `admin.php?page=spokora-api-vault` |
| Licenses | `admin.php?page=spokora-licenses` |
| What’s new | https://spokora.com/updates/ |

---

## Spokora Free — **Plugins → Installed Plugins**

**PHP:** `plugin/spokora-free/includes/plugin-plugins-screen.php` · updates `plugin-updates.php` · store REST `inc/free-download.php` (`/wp-json/spokora/v1/free-plugin-info`)

**UI:** Panel under the Spokora Free row. View details uses `plugins_api` slug `spokora-free`. Check for updates talks to spokora.com with **no license key**.

### Approved copy

**Plugin list description**

Free SEO, schema, sitemap, and redirects for WordPress websites. No account. Updates from spokora.com without registering the site. Built by That One Firm.

**Panel**

You do not register this site. Check for updates talks to spokora.com anyway. When a newer Free zip ships, WordPress can install it from this screen.

---

## Spokora Pro — **Plugins → Installed Plugins**

**PHP:** `spokora-plugin/includes/plugin-plugins-screen.php`

**UI:** Panel under the Spokora row on client sites (not spokora.com). Same Support / Updates destinations as the dashboard blurb. Row description uses the plugin header + `all_plugins` Name **Spokora Pro**.

### Approved copy

**Plugin list description**

Licensed SEO, schema, LLMS docs, and client-week tools for WordPress. Updates from spokora.com with your seat. Built by That One Firm.

**Seated panel**

Your license includes updates from spokora.com. When a new version ships, use **Plugins** or **Dashboard → Updates** on this site (same as any WordPress plugin). The Licenses menu item stays hidden while this seat is active — open License & Safe-Mode from here if you need it.

**Unseated panel**

Paste your spk_ key from spokora.com → My Account. One seat is used per production domain; staging URLs on the same license do not take an extra seat.

### Tabs

| Label | Target |
|-------|--------|
| Support | https://forum.spokora.com/ |
| Updates | https://spokora.com/updates/ |
| API Vault | `admin.php?page=spokora-api-vault` (seated) |
| License & Safe-Mode | `admin.php?page=spokora-licenses` (seated, if the screen is allowed) |
