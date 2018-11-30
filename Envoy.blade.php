@servers(['web-1' => 'root@142.93.25.79', 'web-2' => 'root@104.248.70.115'])

@task('deploy', ['on' => ['web-1', 'web-2'], 'parallel' => true])
cd /var/www/dcynsd
git pull origin master
composer install --no-dev
php artisan migrate --force
@endtask