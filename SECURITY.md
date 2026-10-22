# Security policy

## Supported versions

| Version | Supported |
|---------|-----------|
| Latest release on `main` | Yes |
| Older zip-only builds | Best effort |

## Reporting a vulnerability

Please **do not** open a public GitHub issue for security-sensitive reports.

Email **security@thatonefirm.com** with:

- Description and impact
- Steps to reproduce
- Affected Spokora Free version
- Your contact (optional PGP if you use it)

We aim to acknowledge within a few business days and will coordinate disclosure once a fix is ready.

## Out of scope for this repository

- **Spokora Pro** (commercial, private codebase) — report via [spokora.com](https://spokora.com) support channels.
- Third-party WordPress core, themes, or other plugins on the same site.

## Safe defaults we expect in contributions

- Escape output (`esc_html`, `esc_attr`, `esc_url`) and sanitize input.
- Use nonces and `current_user_can()` for admin actions.
- No hard-coded credentials or private API keys in committed files.
