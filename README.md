<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<br/>

## Get Started

### Local Server (Xampp/Wamp/..)
1. run `cd <YOUR LOCAL SERVER ROOT DIRECTORY>`
    - xampp : `C:\xampp\htdocs`
    - wamp  : `C:\wamp64\www`
    - .. and so on
2. run `git clone https://github.com/Mina4lfy/astudio-task astudio-task`
3. run `cd astudio-task`
4. run `composer install` (preferred to run using bash)
5. run `npm install; npm run build`
6. run `xcopy .env.example .env`
7. <span id="configure-dotenv">Configure `.env` file with your new settings</span>
    - Modify your database connection creds:
        ```
        DB_CONNECTION=mysql
        DB_HOST=database
        DB_PORT=3306
        DB_DATABASE=astudio
        DB_USERNAME=root
        DB_PASSWORD=
8. run `php artisan key:generate`
9. run `php artisan storage:link`

### Docker
1. Simply run: `./devops/scripts/docker-restart.sh`. It accepts one of the following options:
    - `--volumes` ~ removes the persistent volumes.
    - `--hard` ~ removes the local images, volumes, networks, etc. and then bring new images and containers up again.
    - `--reinstall` ~ removes all existing images, volumes, networks, and do a fresh installation.
2. You will be inside the `app` container. When first used, you need to install the app using: `./devops/scripts/install.sh`.
