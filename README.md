## Payroll Timesheet Submission

## Tool used

-   Laravel 11
-   Laravel Jetstream with Livewire
-   MySQL
-   JQuery
-   Docker

## Installation

You may choose to download or git pull the code base, then follow the installation instructions below to run the system.

-   Go to the project directory
-   You may want to edit `db_password.txt` and `db_database.txt` inside **secrets** folder, these 2 files will generate default root password and database.
-   You may also need to change NGINX configuration in `default.conf` at **nginx folder**
-   After done edit config files, do execute the commands below:

```bash
  docker compose build

  docker compose run -d
```

-   The commands above will build and run containers as well as setup all the basics file in order to run the program.
-   You may want to wait for MySQL container setup for a while, then proceed the commands below at same project directory:

```bash
  docker exec app php artisan key:generate

  docker exec app php artisan migrate

  docker exec app php artisan db:seed
```

-   These commands will generate key, setup database and insert an default admin account. Default admin account login are as below:

```bash
  admin@admin.com
  password
```

## Usage Guideline

### Login and Registration Sign-up

![Login](docs/images/login.png)
![Registration](docs/images/registration.png)

You will be redirected to login screen if you are unauthenticated. You may sign-up from the button to register as new user, the registration here will create **normal user account**.

### Timesheet Submission

![Timesheet view](docs/images/add_timesheet.png)

After logged in, you will come to Timesheet screen, user can submit their timesheet by clicking the Add Timesheet button. Newly submitted timesheet will be in **Pending** status until admin approved the submission.

![Update Timesheet view](docs/images/update_timesheet.png)

User can update their submitted timesheet in case they submit wrong details by clicking **view** button. Updated timesheet will changed status back to **Pending** for admin to review and approve again.

### Profile Update

![Update Profile view](docs/images/update_profile.png)
![Update Profile view](docs/images/update_profile_2.png)

User can update their profile information by clicking the option from the dropdown as well as change password and logged out from other browser.

### Admin Timesheet

![Update Profile view](docs/images/admin_timesheet_view.png)

Admin user can _filter timesheet record by user_ as well as submit their own timesheet like normal user do.

### Timesheet Approval

![Update Profile view](docs/images/admin_timesheet_view_2.png)
![Update Profile view](docs/images/after_approved.png)

Admin can update and delete any timesheet as well as approve the submission by clicking the **view** button. After approved, the status will display as **Approved** together with checkmark icon.

### User Management

![Update Profile view](docs/images/admin_add_user.png)

Admin user can view User list from navigation menu above and create new user or admin account by clicking **Add User** button.

![Update Profile view](docs/images/admin_update_user_profile.png)

Admin also can update and delete any user accounts.

# Codebase Structure

## Highlight Root Directories

-   `Dockerfile` - Docker configuration file.
-   `docker-compose.yml` - Docker Compose configuration.
-   `docker-entrypoint.sh` - Docker entry point script.
-   `phpunit.xml` - PHPUnit configuration.
-   `tailwind.config.js` - Tailwind CSS configuration.
-   `app/` - Application core code.

| Directory/File     | Description                                            |
| ------------------ | ------------------------------------------------------ |
| `app/Console`      | Contains artisan commands and custom console commands. |
| `app/Exceptions`   | Handles the application's exception handling.          |
| `app/Http`         |                                                        |
| ├── `Controllers/` | Contains the controllers for the application.          |
| ├── `Middleware/`  | Contains the middleware for the application.           |
| └── `Kernel.php`   | HTTP kernel configuration.                             |
| `app/Models`       | Contains the Eloquent models.                          |
| `app/Policies`     | Contains the authorization policies.                   |
| `app/Providers`    | Contains the service providers for the application.    |
| `app/Services`     | Contains custom service classes.                       |
| `app/Traits`       | Contains reusable traits for the application.          |

-   `config/` - Configuration files.
-   `database/` - Database migrations and seeders.
-   `nginx/` - Nginx configuration files.
-   `public/` - Publicly accessible files.
-   `resources/` - View files and raw assets.

| Directory/File    | Description                               |
| ----------------- | ----------------------------------------- |
| `resources/css`   | Contains CSS files.                       |
| `resources/js`    | Contains JavaScript files.                |
| `resources/lang`  | Contains language files for localization. |
| `resources/views` | Contains Blade template files for views.  |

-   `routes/` - Application routes.
-   `secrets/` - Docker Secret files.
-   `tests/` - Automated test files.

| Directory/File       | Description                         |
| -------------------- | ----------------------------------- |
| `tests/Feature`      | Contains feature tests.             |
| `tests/Unit`         | Contains unit tests.                |
| `tests/TestCase.php` | Base test case class for all tests. |
