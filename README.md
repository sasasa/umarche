<!--
curl -s https://laravel.build/umarche | bash
sail composer require barryvdh/laravel-debugbar
sail composer require laravel/breeze --dev
sail artisan breeze:install
sail npm install
sail npm run dev
sail php artisan migrate

down()を実行後にup()を実行
sail php artisan migrate:refresh --seed
全テーブル削除してup()を実行
sail php artisan migrate:fresh --seed

sail npm run watch


sail artisan make:controller ComponentTestController
sail artisan make:component TestClassBase
sail artisan make:controller LifeCycleTestController
sail php artisan view:clear
sail artisan make:provider SampleServiceProvider

sail artisan make:model Owner -m
sail artisan make:model Admin -m
sail artisan make:migration create_owner_password_resets
sail artisan make:migration create_admin_password_resets

sail artisan storage:link

sail artisan make:controller Admin/OwnersController --resource
sail artisan make:seeder AdminSeeder
sail artisan make:seeder OwnerSeeder
sail artisan db:seed

sail artisan vendor:publish --tag=laravel-pagination

sail artisan make:model Shop -m
sail artisan make:seed ShopSeeder

sail artisan tinker

sail artisan make:controller Owner/ShopController

sail artisan vendor:publish --tag=laravel-errors

sail composer require intervention/image

sail artisan make:request UploadImageRequest

mkdir app/Services
sail artisan make:model Image -m
sail artisan make:controller Owner/ImageController --resource

sail artisan make:seed ImageSeeder

sail artisan make:model PrimaryCategory -m
sail artisan make:model SecondaryCategory

sail artisan make:seed CategorySeeder

sail artisan make:model Product -m
sail artisan make:controller Owner/ProductController --resource

sail artisan make:seed ProductSeeder

sail artisan make:model Stock -m
sail artisan make:seed StockSeeder

npm install micromodal --save

sail artisan make:request ProductRequest
sail artisan make:seed UserSeeder
sail artisan make:controller User/ItemController

sail artisan config:clear
sail artisan make:factory ProductFactory --model=Product
sail artisan make:factory StockFactory --model=Stock

sail npm install swiper@6.7.0

sail artisan make:model Cart -m
sail artisan make:controller User/CartController

sail composer require stripe/stripe-php

.envを書き換えたときにする
sail artisan config:cache

sail artisan make:mail TestMail

sail artisan queue:table

sail artisan make:job SendThanksMail

ジョブの実行
sail artisan queue:work

sail artisan make:mail ThanksMail

sail artisan make:mail OrderedMail
sail artisan make:job SendOrderedMail


sail artisan make:factory ImageFactory --model=Image
-->

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
