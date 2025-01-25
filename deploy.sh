#!/usr/bin/env bash

echo "Ты скопировал фото из storage/app/public/photo/? y/n"
read answer
if [ $answer == "y" ]; then
    echo "Ну поехали..."

    rm -rf ../gen-api
    cp -a ../api ../gen-api

    cd ../gen-api
    rm -rf storage/app/public/photo
    mkdir storage/app/public/photo
    rm .env
    cp .env.production .env
    rm .env.production

    composer update --optimize-autoloader --no-dev

    rm -rf storage/logs/laravel.log

    php artisan cache:clear

    php artisan route:cache
    php artisan config:cache
    php artisan view:cache
    php artisan event:cache

    php artisan l5-swagger:generate

    php -r '$fileName = __DIR__. "/bootstrap/cache/config.php";
        $fileContent = file_get_contents($fileName);

        $basePath = __DIR__;
        $fileContent = str_replace($basePath, "/var/www/danshin_gen/api", $fileContent);

        file_put_contents($fileName, $fileContent);
    '

    cd ../

    tar -cf gen-api.tar gen-api

    scp gen-api.tar root@5.35.93.48:/var/www
    ssh root@5.35.93.48 rm -r /var/www/danshin_gen/api
    ssh root@5.35.93.48 tar -C /var/www -xvf /var/www/gen-api.tar
    ssh root@5.35.93.48 rm -rf /var/www/gen-api.tar
    ssh root@5.35.93.48 mkdir /var/www/danshin_gen
    ssh root@5.35.93.48 mv /var/www/gen-api /var/www/danshin_gen/api
    ssh root@5.35.93.48 mkdir /var/www/danshin_gen/api/storage/app/public/download

    ssh root@5.35.93.48 mkdir /var/www/danshin_gen/api/storage/app/public/photo_temp
    scp ../../../"disk/Мои документы/projects/app/danshin_gen/api/backup/photo.zip" root@5.35.93.48:/var/www/danshin_gen/api/storage/app/public
    ssh root@5.35.93.48 unzip /var/www/danshin_gen/api/storage/app/public/photo.zip -d /var/www/danshin_gen/api/storage/app/public/photo
    ssh root@5.35.93.48 rm -rf /var/www/danshin_gen/api/storage/app/public/photo.zip
    ssh root@5.35.93.48 chmod -R 777 /var/www/danshin_gen/api/storage

    rm -rf gen-api
    rm -rf gen-api.tar

    echo "files \"gen-api\" compiled successfully"
else
    echo "Иди и копируй, а потом приходи"
fi
