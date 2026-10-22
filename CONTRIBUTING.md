# Contributing to Spokora Free

Thank you for helping improve **Spokora Free**. This repo contains **only** the free GPL plugin under `spokora-free/`. We do not accept pull requests that add Spokora Pro features, license servers, or paid-only modules.

## Scope

- Bug fixes, accessibility, security hardening, and documentation improvements are welcome.
- Features that belong in [Spokora Pro](https://spokora.com) (API vault, rank tracking, GSC integration, etc.) will be declined here.

## Before you open a PR

1. Test on a clean WordPress 6.x site with PHP 7.4+.
2. Confirm **Spokora Pro is not** included or referenced as shipped code.
3. Follow WordPress coding standards where practical (escaping, nonces, capabilities).
4. Do not commit secrets, API keys, or customer data.

## Copy and UI strings

Dashboard and Plugins-screen blurbs are spec’d in [docs/HOME-DASHBOARD-BLURB.md](docs/HOME-DASHBOARD-BLURB.md). Update that doc and the matching PHP (`spokora-free/includes/home-intro.php`, etc.) together.

## Build a zip locally

```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\build-spokora-free-zip.ps1
```

Use the generated `dist/spokora-free-*.zip` for manual installs; do not use Windows Explorer “Send to compressed folder” (breaks Linux unzip paths).

## Questions

Use [GitHub Discussions](https://github.com/TOFChris/Spokora-FreeWPPlugin/discussions) or [forum.spokora.com](https://forum.spokora.com/) for support questions. Security issues: [SECURITY.md](SECURITY.md).
