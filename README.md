# OutRun CTF

A self-hosted Capture The Flag (CTF) training platform built with PHP and MySQL. Users register, work through five security challenges of increasing difficulty, and track their progress on a live dashboard and leaderboard.

**Live site:** [outrun-ctf.com](https://outrun-ctf.com)

## Overview

OutRun CTF demonstrates the core components of a secure, dynamic web application: authentication, session management, database-driven challenge delivery, and a structured MVC codebase — deployed and hardened end to end on self-managed infrastructure rather than a managed hosting platform.

## Challenges

| Challenge | Difficulty | Technique |
|---|---|---|
| What Lies Beneath | Easy | Hidden HTML comment |
| No Robots | Easy | `robots.txt` reconnaissance |
| Sweet Tooth | Easy | Browser cookie inspection |
| Encoded Secrets | Medium | Base64 decoding |
| Hidden in Transit | Medium | HTTP response headers |

## Architecture

The application follows an MVC structure:

- **Model** — all database interaction via PDO with prepared statements
- **View** — custom CSS design system, no framework
- **Controller** — handles form submissions, flag validation, and session state

The database is normalized across six tables: `users`, `challenges`, `categories`, `challenge_categories`, `user_challenges`, and `countries`.

## Security

- Passwords hashed with bcrypt via `password_hash()` / `password_verify()`
- All queries run through PDO prepared statements (SQL injection prevention)
- Output escaped with `htmlspecialchars()` (XSS prevention)
- CSRF tokens on every form (login, registration, flag submission)
- Session ID regenerated after login (`session_regenerate_id()`)
- Flag comparison via `hash_equals()` for constant-time comparison
- Rate limiting on login and flag submission
- Flags validated and stored server-side only

## Infrastructure

Self-hosted on a Dell OptiPlex 390 running Docker Compose, with Nginx as a reverse proxy and Cloudflare in front for DNS, SSL, and DDoS protection. UFW and fail2ban handle network-level hardening, and the site has been scanned with OWASP ZAP, Nikto, and WhatWeb.

## Tech Stack

PHP · MySQL · PDO · Docker · Nginx · Cloudflare

## Running Locally

```bash
git clone https://github.com/Yanek-K/outrun-ctf.git
cd outrun-ctf
docker compose up -d
```

The app will be available at `http://localhost` once the containers are up.

## Author

Built by [Yanek K.](https://yanek-k.com)
