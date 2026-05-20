Firmware download task - Symfony implementation
==============================================

This repository now contains a Symfony app that reimplements the original:

- Customer page: `/carplay/software-download`
- API endpoint: `/api2/carplay/software/version`
- Admin panel: `/admin/software-versions`

The API behavior mirrors the old controller logic:

- Same required field validation messages
- Same HW pattern matching (ST/GD + LCI variants)
- Same version matching by `system_version_alt` (case-insensitive, optional leading `v`)
- Same fallback error behavior when no match exists
- Same "latest" messaging with `v3.3.7` and `v3.4.4` rules

Requirements
------------

- PHP 8.1+
- Composer 2+
- SQLite (default) or any DB supported by Doctrine

How to run locally (Linux)
--------------------------

1. Install dependencies:

   `composer install`

2. Create database (SQLite file path is preconfigured in `.env`):

   `mkdir -p var`
   `sqlite3 var/data.db < database_seed.sql`

3. Start the app:

   `php -S 127.0.0.1:8000 -t public`

4. Open:

- Customer page: `http://127.0.0.1:8000/carplay/software-download`
- Admin panel: `http://127.0.0.1:8000/admin/software-versions`

How to manage software versions
-------------------------------

Use `/admin/software-versions`:

- Add new versions with **Add new**
- Edit existing versions with **Edit**
- Remove records with **Delete**

Field meanings:

- `name`: product label (for example `MMI Prime NBT`, `LCI MMI PRO EVO`)
- `systemVersion`: original full version with `v` prefix
- `systemVersionAlt`: normalized version used for API matching
- `link`, `st`, `gd`: download targets returned by API
- `latest`: if checked, API returns "Your system is upto date!" for that record

Seed data
---------

- `database_seed.sql` includes table creation and all records converted from `softwareversions.json`
- Import it once into an empty DB to match existing page behavior immediately

Project structure
-----------------

- `src/Controller/SoftwareDownloadApiController.php` - API logic
- `src/Controller/SoftwareDownloadController.php` - customer page
- `src/Controller/AdminSoftwareVersionController.php` - admin CRUD
- `src/Entity/SoftwareVersion.php` - version entity
- `templates/software_download/index.html.twig` - customer UI
- `templates/admin/software_version/*` - admin UI

Maintenance note: README synced (2026-05-21).
