# Changelog

All notable changes to **Spokora Free** in this repository are documented here.

Format based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [0.1.22] - 2026-10-23

### Security

- JSON-LD output uses `JSON_HEX_TAG | JSON_HEX_AMP` so a `</script>` in custom schema cannot break the tag.

---

## [0.1.21] - 2026-10-23

### Fixed

- `readme.txt` Contributors is **chrismcmanus** ([WordPress.org profile](https://profiles.wordpress.org/chrismcmanus/)).

---

## [0.1.20] - 2026-10-23

### Changed

- **WordPress.org directory:** removed the spokora.com update checker, `Update URI`, and Plugins-row update panel. Updates go through WordPress.org after listing.
- Text domain is **`spokora-free`** (matches the plugin slug).
- Cookie banner and IndexNow are **opt-in** (existing cookie settings keep the banner; sites that already pinged IndexNow stay on).
- Public UI uses **Import SEO** instead of Hijack.
- Added `readme.txt` and `license.txt` in the plugin folder.

---

## [0.1.19] - 2026-10-22

### Fixed

- **Activate Spokora Pro** while Free is still installed: Free steps aside on that request so WordPress can activate Pro without a duplicate-function error.

---

## [0.1.18] - 2026-10-22

### Changed

- Home note and copy: Spokora Free **does** check spokora.com for a newer zip (version check only — no account, no license key). Optional update emails stay extra.

---

## [0.1.17] - 2026-10-22

### Added

- Public source repository ([Spokora-FreeWPPlugin](https://github.com/TOFChris/Spokora-FreeWPPlugin)) — **Free plugin only**; Pro remains commercial.

### Changed

- Product naming: **Spokora Free** only (retired internal “Lite” workspace naming).

---

## [0.1.16] and earlier

Shipped via spokora.com theme downloads and internal builds before this repo went public. See git history of `spokora-free/` for file-level changes from 0.1.17 backward.
