## REST API implementation for ABZ

#### Deploy
composer install<br/>
cp .env.example .env<br/>
php artisan key:generate<br/>
php artisan migrate<br/>
php artisan storage:link<br/>

#### Seed
php artisan db:seed<br/><br/>
Before use, you must controll APP_URL
#### Enjoy!
