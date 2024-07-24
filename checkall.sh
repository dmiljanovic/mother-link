#!/bin/bash
echo "MySQL drop db, create db"
echo "========================================================================="
mysqladmin -uroot -proot drop mother_link
mysqladmin -uroot -proot create mother_link
echo "==================== Composer dump autoload===================="
composer dump-autoload
echo "==================== Artisan migrate===================="
php artisan migrate
echo "==================== Artisan db:seed===================="
php artisan db:seed
echo "======================================================"
echo "git status"
git status
echo "======================================================"
composer dump-autoload
