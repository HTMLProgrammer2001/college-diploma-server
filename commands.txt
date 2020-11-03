composer install;
php artisan migrate:fresh;
php artisan db:seed;
php artisan vendor:publish --tag=passport-config;
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider";
