#!/bin/bash

./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate --env=testing
./vendor/bin/sail artisan db:seed
./vendor/bin/sail artisan l5-swagger:generate
