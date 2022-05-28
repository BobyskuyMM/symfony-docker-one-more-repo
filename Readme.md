

open /etc/host file on you host machine and
add new line:
 - `0.0.0.0 company-search.test`

Open terminal:
 - Run: 'cd <cloned project dir>'
 - Run: `docker-compose build`
 - Run: `docker-compose up -d`
 - Run: `docker-compose exec php /bin/bash`
 - Run: `composer install`
 - Run: `symfony console doctrine:migrations:migrate`
 - Run: `bin/console app:company-load`


Now application available in browser - http://company-search.test/  


Run unit tests:
- Run: `docker-compose exec php /bin/bash`
- Run: `php bin/phpunit tests`