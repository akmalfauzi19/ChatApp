<h2>Installasi </h2>

<p>Cara install,jalankan perintah composer dibawah ini.</p>


```sh
composer install
```


Kemudian konfirgurasi file .env.example menjadi .env dan ubah database sesuai dengan nama database yg dibuat:

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

```
untuk mendapatkan key jalankan perintah :
```sh
php artisan key:generate
```



Jangan lupa lakukan printah artisan berikut :

```sh
php artisan migrate
```

install passport dengan command agar mendapatkan token keys :

```sh
php artisan passport:install
```

<h2>Penggunaan </h2
    <p>
setelah itu Jalankan dengan perintah :
</p>

```sh
php artisan serve
```
