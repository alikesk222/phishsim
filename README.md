# PhishSim

> **Phishing awareness training platform** — Run simulated phishing campaigns, track employee behavior, and measure your organization's security posture.

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![SQLite](https://img.shields.io/badge/SQLite-003B57?style=flat-square&logo=sqlite&logoColor=white)](https://sqlite.org)
[![License: MIT](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## Features

- **Multi-tenant** — each organization has isolated data (employees, campaigns, templates)
- **8 built-in phishing templates** — IT password reset, invoice, HR policy, DHL delivery, Microsoft 365, CEO wire fraud, SharePoint, payslip
- **Email tracking** — open tracking (1x1 pixel), click tracking, credential submission detection
- **Credential capture awareness** — records only field names (`[CAPTURED]`/`[EMPTY]`), never actual values
- **Employee risk scoring** — automatic risk level (low/medium/high/critical) based on phishing history
- **Campaign management** — draft, schedule, launch; per-target status tracking
- **CSV import** — bulk employee import with `updateOrCreate` logic
- **Dark UI** — built with Tailwind CSS

---

## Quick Start

### Requirements

- PHP 8.2+
- Composer
- `pdo_sqlite` and `mbstring` PHP extensions

### Install

```bash
git clone https://github.com/alikesk222/phishsim
cd phishsim
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000) and register your organization.

> **Windows note:** If `pdo_sqlite` or `mbstring` extensions aren't enabled in `php.ini`, prefix artisan commands:
> ```bash
> php -d extension=pdo_sqlite -d extension=mbstring artisan migrate --seed
> ```

---

## Architecture

### Multi-tenancy

Every resource is scoped to an `Organization`. All controllers call `Auth::user()->organization` and scope queries accordingly — no cross-tenant data leakage.

```
Organization
  ├── Users (owner, admin, member roles)
  ├── Employees (targets)
  ├── PhishingTemplates
  └── Campaigns
        └── CampaignTargets (one per employee, unique token)
```

### Tracking Flow

```
Email sent
  → Employee opens email  → GET  /t/pixel/{token}   → markOpened()
  → Employee clicks link  → GET  /t/click/{token}   → markClicked() → landing page
  → Employee submits form → POST /t/submit/{token}  → markSubmitted() → awareness page
  → Employee reports it   → GET  /t/report/{token}  → markReported()
```

### Privacy Design

`CampaignTarget::markSubmitted()` stores only field names and whether they contained a value — **never the actual credentials entered**:

```json
{
  "email": "[CAPTURED]",
  "password": "[CAPTURED]"
}
```

---

## Phishing Templates

| Template | Category | Scenario |
|----------|----------|----------|
| IT Password Reset | Credential Harvesting | Urgent password expiry warning |
| Invoice Payment | Financial Fraud | Overdue invoice from finance |
| HR Policy Update | Credential Harvesting | New policy requires acknowledgment |
| DHL Package Delivery | Credential Harvesting | Delivery confirmation needed |
| Microsoft 365 License | Credential Harvesting | License expiration alert |
| CEO Wire Transfer | Financial Fraud | Urgent wire transfer request |
| SharePoint Document | Credential Harvesting | Document shared requiring sign-in |
| Payslip Available | Credential Harvesting | Monthly payslip notification |

---

## Employee Risk Levels

| Level | Condition |
|-------|-----------|
| Low | Never phished |
| Medium | Phished 1 time |
| High | Phished 2–3 times |
| Critical | Phished 4+ times |

---

## CSV Import Format

```csv
first_name,last_name,email,department,position
Jane,Smith,jane@example.com,Engineering,Developer
John,Doe,john@example.com,Finance,Analyst
```

---

## License

MIT — See [LICENSE](LICENSE)

---

> Built by [Ali Kesik](https://github.com/alikesk222) — Security awareness tools for teams
