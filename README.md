# Create Project

```
docker run --rm -v "D:\I4\Internet Programs I\Laravel\Laravel-Docker:/app" composer create-project --prefer-dist laravel/laravel laravel
```

# Run build

```
docker compose up -d --build
docker compose up -d
docker compose ps
```

# Set up permission

```
docker exec -it laravel_app bash
root@d1deb2be4532:/var/www# chmod -R 775 ./storage ./bootstrap/cache
root@d1deb2be4532:/var/www# chown -R www-data:www-data storage bootstrap/cache
root@6638c6507143:/var/www# ls -l /var/www/database
root@6638c6507143:/var/www# chmod 664 ./database/database.sqlite
root@6638c6507143:/var/www# chown www-data:www-data /var/www/database/database.sqlite
exit
```
