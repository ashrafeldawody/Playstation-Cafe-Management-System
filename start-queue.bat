php artisan queue:work --tries=3 --timeout=90 --daemon --queue=high,low
