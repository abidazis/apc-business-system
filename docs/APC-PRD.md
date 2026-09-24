# APC — PRODUCT REQUIREMENTS DOCUMENT

```
PRD Version: 1.1.0
Last Updated: 2026-09-24
Status: Active
```

---

## 1. Product Overview

**APC** adalah Business Management System berbasis web untuk perusahaan percetakan/promo yang mengelola seluruh aspek operasional bisnis mulai dari lead generation, order management, produksi, keuangan, hingga publikasi katalog produk.

**Tech Stack:**
- Framework: Laravel 11 (PHP 8.3)
- Frontend: Blade + Bootstrap 5.3.3 + Bootstrap Icons 1.13.1
- Build Tool: Vite + Sass
- Database: MySQL/SQLite
- PDF: Barryvdh DomPDF
- Fonts: Inter (Google Fonts)

---

## 2. Business Context

APC adalah sistem ERP ringan yang dirancang untuk:
- Mengelola alur kerja percetakan dari lead hingga selesai
- Melacak keuangan (omzet, HPP, profit, piutang)
- Menampilkan katalog produk dan portfolio secara publik
- Mengkonversi pengunjung website menjadi lead via WhatsApp

---

## 3. Business Objectives

1. **Efisiensi Operasional** — Mengotomatisasi alur order dari lead hingga produksi
2. **Transparansi Keuangan** — Real-time tracking omzet, biaya, dan profit
3. **Lead Conversion** — Mengubah pengunjung website menjadi pelanggan via WhatsApp
4. **Branding** — Memperkuat brand APC melalui website profesional
5. **Auditability** — Activity logging untuk tracking perubahan sistem

---

## 4. Target Users

| Segment | Description |
|---------|-------------|
| **Super Admin** | Pemilik dengan akses penuh sistem |
| **Admin** | Staff senior dengan akses full admin |
| **Staff** | Staff operasional dengan akses terbatas |
| **Public Visitors** | Potensial customer yang mengunjungi website |

---

## 5. User Roles

| Role | Access Level | Description |
|------|--------------|-------------|
| `super_admin` | Full System | Akses tak terbatas |
| `admin` | Full Admin | Akses penuh ke admin panel |
| `staff` | Limited Admin | Akses terbatas sesuai permission |

**Implementation Notes:**
- Role disimpan di column `role` pada tabel `users`
- Authorization menggunakan Gate: `Gate::authorize('admin.access')`
- Middleware `EnsureAdmin` untuk proteksi route admin

---

## 6. Business Model

APC menjalankan bisnis **percetakan dan promotional items** dengan flow:

```
Lead → Quotation → Order → Production → Delivery → Payment
```

---

## 7. Core Business Flow

```
[Website] → Lead Generation
    ↓
[Admin] → Qualifikasi Lead → Convert ke Order
    ↓
[Production] → Job Processing → Quality Control
    ↓
[Delivery] → Selesai → Invoice → Payment
```

---

## 8. Public Website

### 8.1 Homepage (`/`)
**Objective:** Brand awareness, product discovery, trust building, lead generation, WhatsApp conversion

**Required Content:**
- Hero section dengan tagline
- Featured products
- Portfolio highlights
- Testimonial/trust indicators
- CTA WhatsApp

**Data Source:** Products (is_featured=1), PortfolioProjects (is_published=1)

**Acceptance Criteria:**
- [ ] Homepage load dalam < 3 detik
- [ ] WhatsApp floating button visible di semua page
- [ ] Featured products display correctly

---

### 8.2 Products (`/produk`)
**Objective:** Product browsing, specification exposure

**Required Content:**
- Product grid/list
- Category filter
- Product detail dengan spesifikasi

**Data Source:** Products (is_published=1), Categories (is_active=1)

**Acceptance Criteria:**
- [ ] Products filterable by category
- [ ] Product detail show specs dan price
- [ ] WhatsApp CTA per product

---

### 8.3 Portfolio (`/portfolio`)
**Objective:** Social proof, project showcase, trust building

**Required Content:**
- Project gallery
- Project detail dengan images
- Related products

**Data Source:** PortfolioProjects (is_published=1)

**Acceptance Criteria:**
- [ ] Portfolio images display correctly
- [ ] Projects sortable/filterable

---

### 8.4 About (`/tentang`)
**Objective:** Brand story, company profile, trust building

**Required Content:**
- Company story
- Team/company info

**Data Source:** Static content / Pages table

---

### 8.5 Contact (`/kontak`)
**Objective:** Lead generation, inquiry handling

**Required Content:**
- Contact form
- Company contact info
- WhatsApp link

**Acceptance Criteria:**
- [ ] Form submission creates lead or sends notification

---

### 8.6 FAQ (`/faq`)
**Objective:** Customer education, reduce support load

**Data Source:** Faqs table (is_published=1)

**Acceptance Criteria:**
- [ ] FAQs display in sort order

---

### 8.7 Sitemap (`/sitemap.xml`)
**Objective:** SEO optimization

**Data Source:** Products, PortfolioProjects, Pages

---

## 9. Admin System

### 9.1 Dashboard
**Purpose:** Central overview seluruh KPI bisnis

**KPI Cards:**
- Omzet (total penjualan dalam periode)
- Payment In (total pembayaran masuk)
- Expense (total pengeluaran)
- HPP (harga pokok penjualan)
- Gross Profit (omzet - HPP)
- Net Profit (gross profit - expense)
- Piutang (outstanding payments)
- Order Count & Completed Count

**Additional Widgets:**
- Overdue Orders (deadline < today)
- Deadline Near (deadline within 3 days)
- Production Overview (counts per stage)
- Recent Activity (activity log feed)

**Date Range Filter:** today, this_week, this_month, this_year, custom

**Acceptance Criteria:**
- [ ] Dashboard menampilkan data real-time
- [ ] Filter date range berfungsi
- [ ] KPI calculations accurate

---

### 9.2 Orders
**Purpose:** Mengelola seluruh pesanan APC

**Data:**
- Order number (auto-generate)
- Customer (required)
- Lead (optional, link ke lead)
- Order items (multiple)
- Status (10 stage workflow)
- Financial: subtotal, discount, shipping_cost, total
- Dates: order_date, deadline

**Order Status Workflow:**
```
lead → quotation → confirmed → dp_received → design → production → quality_control → ready_to_deliver → completed
                                                                                              ↘ cancelled
```

| Status | Description | Next Possible |
|--------|-------------|---------------|
| lead | Initial lead/quotes | quotation, cancelled |
| quotation | Quotation sent | confirmed, cancelled |
| confirmed | Order confirmed | dp_received, cancelled |
| dp_received | DP/bayar uang muka | design, cancelled |
| design | Dalam tahap desain | production, cancelled |
| production | Dalam produksi | quality_control, cancelled |
| quality_control | QC/check quality | ready_to_deliver, production |
| ready_to_deliver | Siap kirim/ambil | completed, cancelled |
| completed | Order selesai | - |
| cancelled | Order dibatalkan | - |

**Business Rules:**
- Saat convert lead ke order: auto-update lead.status = 'won'
- HPP calculation: SUM(order_items.hpp * quantity)
- Outstanding: total - total_paid
- Status hanya bisa berubah sesuai workflow

**Acceptance Criteria:**
- [ ] Admin dapat membuat order baru
- [ ] Admin dapat ubah status sesuai workflow
- [ ] Financial calculations accurate
- [ ] Order items dapat di-manage

---

### 9.3 Production
**Purpose:** Tracking status produksi per order

**Current Implementation:** View-only kanban-style display

**Production Statuses:** design, production, quality_control, ready_to_deliver

**Acceptance Criteria:**
- [ ] Display orders by production stage
- [ ] Quick view order details

**[NEEDS ENHANCEMENT]** - Detail tracking per job belum tersedia

---

### 9.4 Customers
**Purpose:** Database pelanggan

**Data:**
- Name (required)
- Organization (optional)
- Phone (optional)
- Email (optional)
- Address (optional)
- Notes (optional)

**Relationships:**
- HasMany: Orders
- HasMany: Leads

**Acceptance Criteria:**
- [ ] CRUD operations berfungsi
- [ ] Customer history visible (orders, leads)

---

### 9.5 Leads
**Purpose:** Prospect/sales pipeline management

**Data:**
- Contact info (name, phone, email, organization)
- Source
- Estimated value
- Status: new, contacted, negotiation, quotation, won, lost
- Follow-up date
- Notes
- Customer (optional link)
- Assigned to (user)

**Lead Status Workflow:**
```
new → contacted → negotiation → quotation → won
                                         ↘ lost
```

**Business Rules:**
- Convert ke Order: Lead status = 'won', create Order dengan link ke lead
- Follow-up date tracking

**Acceptance Criteria:**
- [ ] CRUD operations berfungsi
- [ ] Status workflow berfungsi
- [ ] Convert ke order berfungsi

---

### 9.6 Products (Katalog)
**Purpose:** Katalog produk untuk dijual

**Data:**
- Name, slug, SKU
- Category
- Short description, description, specifications
- Price, price_type (fixed/starting_from/contact)
- Image
- is_featured, is_published

**Price Types:**
- `fixed` — Harga tetap
- `starting_from` — Harga mulai dari
- `contact` — Hubungi untuk harga

**Acceptance Criteria:**
- [ ] CRUD operations berfungsi
- [ ] Image upload berfungsi
- [ ] Filter by category works
- [ ] Featured products display on homepage

---

### 9.7 Categories
**Purpose:** Mengorganisir produk

**Data:**
- Name, slug
- Description
- Sort order
- is_active

**Acceptance Criteria:**
- [ ] CRUD dengan drag-sort order

---

### 9.8 Portfolio
**Purpose:** Showcase hasil kerja/proyek

**Data:**
- Title, slug
- Customer name
- Project date
- Description
- Cover image
- Images (multiple)
- Products (many-to-many)
- is_published, sort_order

**Acceptance Criteria:**
- [ ] CRUD dengan multi-image upload
- [ ] Link ke products berfungsi

---

### 9.9 Invoices
**Purpose:** Faktur untuk pelanggan

**Data:**
- Invoice number (auto-generate)
- Order (required)
- Customer (required)
- Issue date, due date
- Financial breakdown (subtotal, discount, shipping, total)
- Status: unpaid, partial, paid

**Auto-generation:** Buat invoice dari order

**PDF Export:** Menggunakan DomPDF

**Acceptance Criteria:**
- [ ] Create from order
- [ ] PDF generation works
- [ ] Status tracking berfungsi

---

### 9.10 Payments
**Purpose:** Record pembayaran dari customer

**Data:**
- Order (required)
- Payment date
- Amount
- Method: cash, bank_transfer, ewallet, other
- Reference (transfer number, etc)
- Notes

**Acceptance Criteria:**
- [ ] CRUD operations berfungsi
- [ ] Payment ter-link ke order

---

### 9.11 Expenses
**Purpose:** Record pengeluaran

**Data:**
- Date
- Category (ExpenseCategory)
- Description
- Amount
- Payment method
- Reference
- Notes

**Acceptance Criteria:**
- [ ] CRUD dengan category filter

---

### 9.12 Expense Categories
**Purpose:** Mengorganisir expense

**Data:** Name, slug

---

### 9.13 Reports
**Purpose:** Laporan keuangan periodik

**Metrics:**
- Revenue (sum of order totals)
- Payment (sum of payments)
- Expense (sum of expenses)
- HPP
- Gross Profit (revenue - HPP)
- Net Profit (gross - expense)

**Analysis:**
- Top Customers by revenue
- Top Products by quantity sold
- Order list dalam periode

**Date Range Filter:** this_month, this_year, custom

**[NEEDS ENHANCEMENT]** - Export PDF/Excel belum tersedia

---

### 9.14 FAQs
**Purpose:** CMS untuk FAQ publik

**Data:** Question, answer, sort_order, is_published

**Acceptance Criteria:**
- [ ] CRUD berfungsi
- [ ] Sortable
- [ ] Display di /faq page

---

### 9.15 Pages
**Purpose:** CMS untuk static pages

**Data:** Slug, title, content, is_published

**Acceptance Criteria:**
- [ ] CRUD berfungsi
- [ ] WYSIWYG content editor

---

### 9.16 Settings
**Purpose:** Konfigurasi sistem

**Data:** Key-value storage di tabel `settings`

**Usage:**
```php
Settings::get('key', 'default');
Settings::set('key', 'value');
```

**Acceptance Criteria:**
- [ ] Key-value CRUD berfungsi
- [ ] Settings accessible via helper class

---

## 10. Financial Business Rules

### Formulas

```
OMZET = SUM(orders.total) WHERE status != 'cancelled' AND date IN range

PAYMENT_IN = SUM(payments.amount) WHERE payment_date IN range

EXPENSE = SUM(expenses.amount) WHERE date IN range

HPP = SUM(order_items.hpp * order_items.quantity) WHERE order.order_date IN range

GROSS_PROFIT = OMZET - HPP

NET_PROFIT = GROSS_PROFIT - EXPENSE

OUTSTANDING/PIUTANG = SUM(orders.total - orders.total_paid) WHERE orders.status NOT IN ('completed', 'cancelled')
```

**[CONFLICT CHECK]** - Perlu verifikasi source code untuk formula aktual

---

## 11. Authentication

**Implementation:**
- Custom auth (bukan Laravel Breeze/Fortify)
- Login: POST /admin/login
- Logout: POST /admin/logout
- Session-based authentication

**Middleware:**
- `auth` — Standard Laravel auth
- `admin.active` — Cek user active dan role

**Login Page:** /admin/login

---

## 12. Security Requirements

### Middleware
- `EnsureAdmin` — Cek active status + role
- `SecurityHeaders` — HTTP security headers

### Security Headers Applied
```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()
Cross-Origin-Opener-Policy: same-origin
Strict-Transport-Security: max-age=31536000 (HTTPS only)
```

### Implemented Protections
- CSRF Protection (Laravel default)
- Password Hashing (automatic via $casts)
- Mass Assignment Protection ($fillable on models)
- Soft Deletes (products, orders, portfolio)
- XSS Prevention (Blade escaping)
- SQL Injection Prevention (Eloquent ORM)

---

## 13. UI/UX Requirements

### Brand Colors
| Color | Hex | Usage |
|-------|-----|-------|
| APC Yellow | #FFC600 | Primary accent |
| APC Yellow Bright | #FFD60A | Hover state |
| APC Yellow Soft | #FFF3B0 | Subtle backgrounds |
| APC Black | #0B0B0B | Primary dark |
| APC Ink | #14171A | Text dark |
| White | #FFFFFF | Background |
| Success | #16A34A | Success states |
| Warning | #F59E0B | Warning states |
| Danger | #DC2626 | Error states |
| WhatsApp | #25D366 | WA button |

### Existing Components
```
Buttons:   apc-btn-primary, apc-btn-dark, apc-btn-outline-dark,
           apc-btn-outline-light, apc-btn-wa, apc-btn-danger, apc-btn-ghost

Cards:     apc-card, apc-card-hover, apc-card-flat, apc-card-dark, apc-card-yellow

Badges:    apc-badge-yellow, apc-badge-dark, apc-badge-light,
           apc-badge-success, apc-badge-warning, apc-badge-danger, apc-badge-info

Forms:     apc-input, apc-select, apc-textarea, apc-switch,
           apc-field, apc-label, apc-help

Layout:    apc-container, apc-section, apc-hero, apc-sidebar, apc-topbar
```

**Rule:** REUSE FIRST — Jangan buat component baru jika sudah tersedia

---

## 14. Responsive Requirements

- Mobile-first approach
- Breakpoints: 480px, 640px, 768px, 1024px, 1280px
- Admin sidebar: Desktop only (1024px+)
- Mobile: Offcanvas sidebar
- WhatsApp floating button: Always visible

---

## 15. Database Requirements

### Tables
| Table | Purpose |
|-------|---------|
| users | User management dengan role |
| settings | Key-value configuration |
| categories | Product categories |
| products | Product catalog |
| customers | Customer database |
| leads | Sales leads |
| orders | Order management |
| order_items | Order line items |
| payments | Payment records |
| expense_categories | Expense grouping |
| expenses | Expense tracking |
| invoices | Invoice generation |
| portfolio_projects | Portfolio showcase |
| portfolio_images | Portfolio images |
| portfolio_project_product | Pivot: portfolio-products |
| activity_logs | Audit trail |
| pages | CMS pages |
| faqs | FAQ management |

### Soft Deletes
- products
- orders
- portfolio_projects

---

## 16. Technical Architecture

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/ (20 controllers)
│   │   └── Public/ (4 controllers)
│   └── Middleware/
│       ├── EnsureAdmin.php
│       └── SecurityHeaders.php
├── Models/ (17 models)
├── Services/
│   ├── Activity.php
│   ├── Formatter.php
│   └── NumberGenerator.php
└── Support/
    └── Settings.php

routes/
├── admin.php
├── web.php
└── api.php [MISSING]

database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2026_08_28_000001_create_apc_schema_tables.php
├── 2026_08_28_000002_add_role_to_users_table.php
└── 2026_08_28_000003_add_soft_deletes_to_invoices.php
```

---

## 17. Routes

**Total Routes:** 109

| Category | Count |
|----------|-------|
| Admin | 86 |
| Public | 14 |
| Boost | 9 |

### Admin Routes (prefix: /admin)
| Module | Routes |
|--------|--------|
| Dashboard | 2 (GET) |
| Categories | 7 (CRUD) |
| Customers | 7 (CRUD) |
| Expense Categories | 7 (CRUD) |
| Expenses | 7 (CRUD) |
| FAQs | 6 (CRUD) |
| Invoices | 8 (CRUD + PDF) |
| Leads | 7 (CRUD) |
| Orders | 9 (CRUD + Status) |
| Pages | 6 (CRUD) |
| Payments | 7 (CRUD) |
| Portfolio | 9 (CRUD + Images) |
| Production | 1 (GET) |
| Products | 7 (CRUD) |
| Reports | 1 (GET) |
| Settings | 2 (GET/POST) |
| Auth | 3 (Login/Logout) |

### Public Routes
| Page | URI |
|------|-----|
| Home | / |
| Products List | /produk |
| Product Detail | /produk/{slug} |
| Portfolio List | /portfolio |
| Portfolio Detail | /portfolio/{slug} |
| About | /tentang |
| Contact | /kontak |
| FAQ | /faq |
| Sitemap | /sitemap.xml |
| Login | /login |

---

## 18. Acceptance Criteria

### Authentication
- [ ] Admin login berfungsi
- [ ] Session timeout berfungsi
- [ ] Logout invalidate session

### Orders
- [ ] Create order dengan items
- [ ] Update status sesuai workflow
- [ ] Convert lead ke order
- [ ] Financial calculations accurate

### Financial
- [ ] Omzet calculation correct
- [ ] HPP calculation correct
- [ ] Profit margins accurate
- [ ] Piutang tracking correct

### Public Website
- [ ] Homepage displays correctly
- [ ] Products filterable
- [ ] Portfolio images load
- [ ] WhatsApp floating button works

---

## 19. Testing Requirements

**[NOT IMPLEMENTED]** - Testing suite perlu di-setup

**Required Tests:**
- Order workflow (status transitions)
- Financial calculations
- Lead conversion
- Authentication
- CRUD operations

---

## 20. Current Implementation Status

| Feature | Requirement | Existing | Status | Priority |
|---------|-------------|----------|--------|----------|
| Homepage | Business landing page | Yes | Working | P0 |
| Product Catalog | Product browsing | Yes | Working | P0 |
| Portfolio | Project showcase | Yes | Working | P0 |
| About | Company info | Yes | Working | P0 |
| Contact | Lead generation | Yes | Working | P0 |
| FAQ | Public FAQ | Yes | Working | P0 |
| Sitemap | SEO | Yes | Working | P1 |
| Lead | Lead tracking | Yes | Working | P0 |
| Customer | Customer management | Yes | Working | P0 |
| Order | Order workflow | Yes | Working/Verify | P0 |
| Production | Production tracking | Yes | Partial | P0 |
| Payment | Payment tracking | Yes | Working | P0 |
| Invoice | Invoice + PDF | Yes | Working/Verify | P1 |
| Expense | Expense tracking | Yes | Working | P1 |
| Reports | Financial reporting | Yes | Partial | P1 |
| User Management | Admin user CRUD | No | Missing | P1 |
| Authentication | Admin auth | Yes | Working | P0 |
| Settings | System config | Yes | Working | P1 |
| Export Reports | PDF/Excel export | No | Missing | P2 |
| API | REST API | No | Future | P3 |
| Mobile App | Native app | No | Future | P3 |

---

## 21. Known Issues

1. **[NEEDS VERIFICATION]** Production module hanya view-only, detail tracking belum ada
2. **[NEEDS ENHANCEMENT]** Reports belum ada export PDF/Excel
3. **[MISSING]** User Management (CRUD admin users)
4. **[MISSING]** Public user registration/authentication
5. **[MISSING]** Email notifications
6. **[MISSING]** WhatsApp API integration
7. **[MISSING]** Testing suite

---

## 22. Future Roadmap

### P1 — Important
1. User Management — CRUD admin users dengan role
2. Reports Export — PDF/Excel download
3. Email Notifications — Order status, etc
4. Advanced Production — Detail job tracking

### P2 — Enhancement
1. Dashboard Charts — Visual analytics
2. Customer Portal — Self-service untuk customer
3. Media Library — Centralized asset management

### P3 — Future
1. REST API — Untuk mobile app
2. WhatsApp Integration — Auto notification
3. Advanced Automation — Workflow triggers

---

## 23. Change Log

### 2026-09-24

**Change:** Major feature implementations and fixes

**Features Implemented:**
1. **Contact Form Handler** - POST route, ContactController, Lead auto-creation from form
2. **User Management CRUD** - Full CRUD, role assignment, activate/deactivate, gate authorization
3. **Order Status Transition Validation** - `canTransitionTo()`, `getNextPossibleStatuses()` methods, UI dropdown filter
4. **Invoice Auto-Update on Payment** - Invoice status sync when payments created/updated/deleted

**Affected Modules:**
- Contact (Public) - ContactController, contact.blade.php
- Users - UserController, UserRequest, 3 views (index, create, edit, show)
- Orders - OrderController, Order model (status transitions)
- Payments - PaymentController (invoice sync)
- AppServiceProvider (Gate definitions)

**Database:** No

**Breaking Change:** No

**Tests:** 28 tests passing

**Implemented By:** Claude Agent

---

### 2026-09-01

**Change:** Initial PRD creation based on system audit

**Reason:** Establish single source of truth untuk development

**Affected Modules:** All

**Database:** No

**Breaking Change:** No

**Implemented By:** Claude Agent

---

## 24. Quick Reference

### Important Files
- Routes: `routes/admin.php`, `routes/web.php`
- Controllers: `app/Http/Controllers/Admin/`, `app/Http/Controllers/Public/`
- Models: `app/Models/`
- Views: `resources/views/admin/`, `resources/views/public/`
- Services: `app/Services/`
- Middleware: `app/Http/Middleware/`
- Schema: `database/migrations/2026_08_28_000001_create_apc_schema_tables.php`

### Key Commands
```bash
php artisan route:list          # List all routes
php artisan migrate:status      # Check migrations
php artisan tinker              # Debug PHP
```

### Design System
- SCSS: `resources/scss/`
- Colors: See Section 13
- Components: See Section 13

---

*End of PRD*
