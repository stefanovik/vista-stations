## Starting/Stopping the application

- The only thing needed to run the application is executing the start.sh script found in the root folder. It handles:
  - the startup of the containers
  - running a composer install
  - running the migrations for the database, both for prod and testing.
  - seeding the database
  - generating swagger documentation
- Stopping the application can be done by executing ./vendor/bin/sail down
- Swagger documentation of the API can be found at http://localhost/api/documentation

## Technical aspects

- Migrations are stored in database/migrations and are run using artisan
- Seeders are being stored in database/seeders. An initial seed is being run on container start
- Sail is being used to run the laravel app and the MYSQL
- DDD was used when transcribing business requirements into code and for the modeling of the application.
- TDD was used when developing the domain.
- ATDD was used when creating the APIs supported by the app.

## Framework and technologies used

- Laravel ^10.10 for the API
- Pest for writing and running tests
- MYSQL for storing data about companies and stations.
- Redis was considered as storage for its geospatial capabilities but decided to go with MYSQL, a safer/more traditional approach
- Postgres was considered as storage for its geospatial capabilities but decided to go with a more familiar storage solution (namely MYSQL)
- Swagger for API documentation

## Libraries used

- For geospatial calculations (distance between points): https://github.com/mjaschen/phpgeo
- For generating swagger annotations, thus documenting the API correctly and accurately: https://github.com/DarkaOnLine/L5-Swagger
