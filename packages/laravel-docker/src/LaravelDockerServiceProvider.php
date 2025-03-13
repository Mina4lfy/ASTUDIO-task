<?php

namespace Minaalfy\LaravelDocker;

use Illuminate\Support\ServiceProvider;

class LaravelDockerServiceProvider extends ServiceProvider
{
  /**
   * Boot the LaravelDocker service
   *
   * @return void
   */
  public function boot()
  {
    if (!$this->app->runningInConsole()) {
      return;
    }

    $src = __DIR__ . '/../resources';
    $dst = \base_path('devops');

    $this->publishes([
      # Nginx.
      "$src/nginx/nginx.conf"               => "$dst/nginx/nginx.conf",
      "$src/nginx/conf.d/default.conf"      => "$dst/nginx/conf.d/default.conf",

      # PHP.
      "$src/php/conf.d/custom.ini"          => "$dst/php/conf.d/custom.ini",
      "$src/php/conf.d/disable-opcache.ini" => "$dst/php/conf.d/disable-opcache.ini",
      "$src/php/Dockerfile"                 => "$dst/php/Dockerfile",

      # MariaDB.
      "$src/mariadb/custom.cnf"             => "$dst/mariadb/custom.cnf",

      # Supervisord.
      "$src/supervisord/supervisord.conf"   => "$dst/supervisord/supervisord.conf",
      "$src/supervisord/Dockerfile"         => "$dst/supervisord/Dockerfile",

      # Docker & docker-compose.
      "$src/.dockerignore"                  => "$dst/../.dockerignore",
      "$src/docker-compose.yml"             => "$dst/../docker-compose.yml",

      # Logs.
      "$src/logs/.gitignore"                => "$dst/logs/.gitignore",

      # Helper scripts.
      "$src/scripts/install.sh"             => "$dst/scripts/install.sh",
      "$src/scripts/docker-restart.sh"      => "$dst/scripts/docker-restart.sh",
    ], 'laravel-docker');
  }

  /**
   * {@inheritDoc}
   */
  public function register()
  {
    //
  }
}