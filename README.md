# Laravel Skeleton 

This is a laravel skeleton for rapid backend development. 

## It Includes:

- Authentication for backend admin
- Authorization by roles and permissions
- Api Authentication

## Steps to install 

- clone the git repository `git clone https://github.com/ace113/Laravel-Skeleton.git` and `cd` inside the project root
- run `composer install --prefer-dist --div -vvv` (this might take a while)
- copy env.example to .env and configure your enviroment variables
- run `php artisan generate:key`
- run `php artisan config:cache`
- run `php artisan migrate --seed`
- run `php artisan serve`

## Please Note

This software uses the [Laravel](https://laravel.com/ "Laravel") framework.

Currently, [Laravel 7.0](https://laravel.com/docs/7.x "Laravel 7.0") is being used.

If you are getting any error, it is most probably due to
unfulfilled [requirements](https://laravel.com/docs/7.x#server-requirements "Server Requirements")
of the framework itself.

Also, make sure that you have proper database drivers. For an example, make sure
you have installed php7.2-mysql package so that you can use mysql database with php7.2 in your project. 