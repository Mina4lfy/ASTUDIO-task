<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<br/>

## #1 Get Started

### Local Server (Xampp/Wamp/..)

1. Move to your local server directory: `cd <YOUR LOCAL SERVER ROOT DIRECTORY>`
    - xampp : `C:\xampp\htdocs`
    - wamp : `C:\wamp64\www`
    - .. and so on
2. Run

    ```
    git clone git@github.com:Mina4lfy/ASTUDIO-task.git astudio-task
    cd astudio-task

    composer install
    npm install; npm run build

    xcopy .env.example .env
    php artisan key:generate
    php artisan storage:link

    php artisan passport:keys --force
    php artisan passport:client --password --no-interaction
    ```

3. <span id="configure-dotenv">Configure `.env` file with your new settings</span>
    - Modify your database connection creds:
        ```
        DB_CONNECTION=mysql
        DB_HOST=database
        DB_PORT=3306
        DB_DATABASE=astudio
        DB_USERNAME=root
        DB_PASSWORD=
        ```
4. Migrate database: `php artisan migrate:fresh --seed`.

### Docker

Simply run: `./devops/scripts/docker-restart.sh --reinstall`.<br/>
<i>You may need to change the following ports or versions in `.env`:</i>

```
DOCKER_APPSERVER_PORT="80"
DOCKER_DATABASE_PORT="3306"
DOCKER_DBADMIN_PORT="88"
DOCKER_APP_VERSION="1.0.0"
DOCKER_PHP_VERSION="8.2"
```

### Update your passport client id and secret

After the installation script is finished, copy the client id and secret to your `.env` vars as follows.
![image](https://github.com/user-attachments/assets/23dd3806-6863-4f2e-9c37-6b202f2c6f90)

<br/>

## #2 API Documentation

I am not a Swagger fan! You can import the Postman collection from `docs/postman/postman-collection.json` and environment, `docs/postman/postman-environment.json`.<br/>
Documentation is accessible at <a href="https://documenter.getpostman.com/view/43226766/2sAYkEpKVH">https://documenter.getpostman.com/view/43226766/2sAYkEpKVH</a>.

In the collection, you will find example requests/responses for:
- issuing/revoking access tokens using Laravel Passport.
- CRUD operations for attributes, projects, and timesheet logs/records.
- filtration using both, regular and EAV attributes.
- filtration using basic operators, such as `>`, `<`, `=`, and `like`.

<br/>

### #3 SQL Dump & Credentials

Database dump can be found in `./astudio.sql.gz`.<br/>

Testing credentials are:
```
username: minaalfy8@gmail.com
password: newPassw&rd1
```

<br/>

## #4 More Context

- Instead of re-inventing the wheel, I used the <a href="https://github.com/rinvex/laravel-attributes">`rinvex/laravel-attributes`</a> package to handle the EAV stuff, It has a quite good structre and implements some of the needed features here. So, I extended it with the missing attribute types, `Date` and `Select`.<br/>
Modifications were made to get it (and its dependencies) compatible with PHP >= 8.2 and Laravel 12. Packages can be found on packagist <a href="https://packagist.org/packages/mina4lfy/laravel-attributes">@1</a> and <a href="https://packagist.org/packages/mina4lfy/laravel-support">@2</a>.
- I am not using Windows, so setup steps in above are not tested, but should work. Anyways, you'd better go with Linux.
