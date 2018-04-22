INSTALLATION

1. Clone the repo
2. Run: composer install
3. Set up an empty database, and add the database credentials to the .env file
4. Run: php artisan migrate
5. Set up a vhost for this project
6. Set the url to the application in the .env file
    Example: APP_URL=http://sportbetapi.loc/api/v1/
7. Run the tests: php codecept.phar run api UserCest
