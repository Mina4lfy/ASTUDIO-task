#!/bin/sh

set -eux

# Removed cached css/js/json files.
function remove_compiled_files()
{
  find public/css/* ! -type f -exec rm -f {} +
  find public/js/* ! -name *.min.js -type f -exec rm -f {} +
}

# Install composer & npm packages for development.
function install_npm_and_composer_packges_for_dev()
{
  composer install
  npm install && npm run dev
}

# Install composer & npm packages for production. 
function install_npm_and_composer_packges_for_prod()
{
  composer install --no-dev --ignore-platform-reqs --optimize-autoloader
  npm install --prod && npm run build
}

# Switch on given options.
if [ ! "$#" -eq 0 ]; then
  for opt in "$@"
  do
    case $opt in

      --remove-compiled)
        remove_compiled_files
      ;;

      --dev)
        remove_compiled_files
        install_npm_and_composer_packges_for_dev
      ;;

      --prod)
        running_for_production=true
        remove_compiled_files
        install_npm_and_composer_packges_for_prod
      ;;

      # --build)
      #   if [[ -v running_for_production ]]; then
      #     echo -e "\nYou cannot build the database unless you are running this script with --dev due to missing dependencies\n"
      #     exit 1
      #   fi
      #   php artisan migrate:fresh --seed
      # ;;

    esac
  done
fi

# install composer packages if not already installed.
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor)" ]; then
  composer install
fi

# Do Laravel stuff.
php artisan storage:link --force
php artisan key:generate
php artisan migrate # --seed

# chmod -R 777 storage public
