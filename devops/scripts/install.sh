#!/bin/sh

set -eux

# Install composer & npm packages.
function install_dependencies()
{
  composer install
  npm install && npm run build
}

# Initialize Laravel project.
function laravel_init()
{
  php artisan storage:link --force
  php artisan key:generate
  php artisan migrate:fresh --seed
}

# Generate passport private/public keys and create `password` client.
function generate_passport_keys()
{
  php artisan passport:keys --force
  php artisan passport:client --password --no-interaction
}

# Here starts everything.
function main()
{
  set -eux

  reset

  install_dependencies
  laravel_init
  generate_passport_keys
}
main "$@"; exit
