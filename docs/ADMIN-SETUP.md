# Admin area — setting it up on Hostinger

The Media, Toolkits, Jobs and Training pages, and the Leadership Team on the
About page, now come from a database that staff manage at **https://safecenterdev.org/admin**. Every other page is still
a plain `.html` file. The site keeps the same addresses (`media.html`,
`jobs.html`, …), so links and search results keep working.

Do these steps once, in this order. They take about 15 minutes.

## 1. Check the PHP version

hPanel → **Websites → Manage → Advanced → PHP Configuration**. Choose
**PHP 8.1 or newer** (8.3 recommended). On the **PHP options** tab, set
`upload_max_filesize` to `20M` and `post_max_size` to `25M` so staff can upload
PDFs and photos up to 20 MB.

## 2. Create the database

hPanel → **Databases → MySQL Databases**. Create a database and a user (any
names; Hostinger adds a prefix such as `u123456789_`). Write down:

- database name
- user name
- password

## 3. Load the tables

hPanel → **Databases → phpMyAdmin → Enter phpMyAdmin** next to the new
database. Then, with the database selected on the left:

1. **Import** → choose `database/schema.sql` from this repository → **Go**.
2. **Import** again → choose `database/seed.sql` → **Go**.

`seed.sql` creates the five roles and moves the vacancies, courses and
Leadership Team that used to be written into the HTML pages into the database.

## 4. Deploy the code

Deploy as you do today (Hostinger's Git deployment, or uploading the files to
`public_html`). The new folders — `app/`, `config/`, `database/`, `storage/`,
`docs/` — must be uploaded too. Each one contains an `.htaccess` that blocks
it from the web, and the main `.htaccess` blocks them again.

## 5. Tell the site the database password

In hPanel → **Files → File Manager**, open `public_html/config/`, copy
`config.local.example.php` to **`config.local.php`**, and fill in the three
values from step 2 (`host` stays `localhost`).

`config.local.php` is never committed to GitHub, so the password stays on the
server. Re-deploying does not remove it.

## 6. Make storage writable

In File Manager, right-click `public_html/storage` → **Permissions** → `755`
(and the same for `storage/uploads` and `storage/logs`). Uploaded photos and
documents are saved in `storage/uploads`; **include this folder in backups**.

## 7. Create the administrator account

Open **https://safecenterdev.org/admin**. Because no account exists yet, it
shows *Create the administrator account*. Enter your name, email and a strong
password. This page switches itself off as soon as the first account exists.

## 8. Add staff

**Admin → Staff accounts → Add staff member.** Pick a role and type a
temporary password; share it privately. They must choose their own password
the first time they sign in.

| Role | Can manage |
|---|---|
| Administrator | Everything, including the Leadership Team, staff accounts, role permissions and the audit log |
| Content Editor | News & media, toolkits, jobs, training |
| Communications | News & media, toolkits |
| HR Officer | Jobs |
| Training Officer | Training |

An administrator can change what each role may do under **Admin → Roles**.
The Administrator role always keeps every permission, and the last active
administrator cannot be demoted or suspended, so nobody can lock the site out.

## Day-to-day

- **Draft vs Published.** Only *Published* items appear on the website.
- **Jobs** disappear from the site automatically the day after their deadline.
  With no open vacancies, the Jobs page shows the talent-pool form instead.
- **Media and Toolkits** show their original “coming soon” message until the
  first item is published.
- **Deleting** hides an item; it stays in the database and the audit log.
- **Forgotten password:** an administrator sets a new temporary one under
  *Staff accounts → Edit*. Five wrong passwords lock an account for 15 minutes.
- **Audit log** (administrators): every sign-in, failed sign-in and change, with
  who, when, what changed and from which IP address.

The website's forms (contact, newsletter, training registration, job
applications) still go to FormSubmit and arrive by email, as before.

## Updates to an existing site

Some changes need a one-off database update as well as the code. Each update is
a file in `database/updates/`. Import it in phpMyAdmin (select the database →
**Import** → choose the file → **Go**) **before** merging the change, and only
once. A site set up from scratch with `schema.sql` + `seed.sql` already includes
every update.

| File | Adds |
|---|---|
| `2026-10-26-leadership-team.sql` | Leadership Team on the About page, editable under **Admin → Team** (Administrators only) |

## Troubleshooting

| Symptom | Fix |
|---|---|
| “Something went wrong” on Media/Jobs/Training/Toolkits or /admin | Usually the database details in `config/config.local.php`. Errors are written to `storage/logs/`. |
| `/admin` shows 404 | The main `.htaccess` was not uploaded (it starts with a dot; enable “show hidden files”). |
| Upload says the file is too large | Raise the PHP limits from step 1. |
| “Session expired” after leaving a form open | Sessions end after 30 minutes without activity. Reload the page and save again. |
