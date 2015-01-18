#Carty

Basic PHP Shopping Cart

Laravel package

Tools used:

*   PHP 5.4
*   MySQL
*   Laravel 4.2
*   jQuery
*   Handlebars


##Installation Instructions

1. Install Laravel and setup your database connection in app/config/database.php
2. Add to composer.json require:
    "dersam/carty": "dev-master"
3. Install composer packages
    composer install
4. Add the Carty service provider to the provider array in app/config/app.php
    'Dersam\Carty\CartyServiceProvider'
5. Publish the public assets
    php artisan asset:publish
6. Create the database tables (will use your application's connection string from app/config/database.php)
    php artisan migrate --package="dersam/carty"
    