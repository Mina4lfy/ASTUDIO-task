<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<br/>

## Get Started

### Local Server (Xampp/Wamp/..)
- run `cd <YOUR LOCAL SERVER ROOT DIRECTORY>`
    - xampp : `C:\xampp\htdocs`
    - wamp  : `C:\wamp64\www`
    - .. and so on
- run `git clone https://github.com/Mina4lfy/astudio-task astudio-task`
- run `cd astudio-task`
- run `composer install` (for production, use `--no-dev`) `preferred to run using bash`
    - This command creates your `/vendor` directory
- run `npm install` (for production, use `--prod`)
    - This command creates your `/node_modules` directory
- run `xcopy .env.example .env`
- <span id="configure-dotenv">Configure `.env` file with your new settings</span>
    - Modify your database connection creds:
        ```
        DB_CONNECTION=mariadb
        DB_HOST=database
        DB_PORT=3306
        DB_DATABASE=astudio
        DB_USERNAME=root
        DB_PASSWORD=root
- run `php artisan key:generate`
- run `php artisan storage:link`

### Docker
- Similarly to local servers, <a href="#configure-dotenv">configure your dotenv.</a> You may also need to change your ports:
    ```
    DOCKER_APPSERVER_PORT="80"
    DOCKER_DATABASE_PORT="3306"
    DOCKER_DBADMIN_PORT="88"
    DOCKER_REDIS_PORT="6379"
    ```
- Simply run: `./devops/scripts/docker-restart.sh`. It accepts one of the following options:
    - `--volumes` ~ removes the persistent volumes. Watch out! You will be about to lose all your database and cached data.
    - `--reinstall` ~ removes all existing docker images of the app, volumes, networks, and do a fresh installation.
- Get inside the `app` container. When first used, you need to install the app using: `./devops/scripts/install.sh`. It can accept the following options:
    - `--remove-compiled` ~ removes compiled CSS/JS/JSON files. (`/public/js`, `/public/css`)
    - `--dev` ~ runs the app for development. (`composer install` | `npm run build`)
    - `--prod` ~ runs the app for production. (`composer install --no-dev` | `npm run build`)
