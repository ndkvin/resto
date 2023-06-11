# Cara menjalankan

Aplikasi yang dibutuhkan:

- PHP dan apache (ada di xampp)
- MySQL (ada di xampp)
- phpMyAdmin (ada di xampp)
- Git (Install seperti tugas RPL)

## Step 1 - Clone Repository

1. Pelajari Git dan command line terlebih dahulu
3. jalankan perintah git clone https://github.com/ndkvin/resto

## Step 2 - Pasang Database

1. Jalankan mysql dan apache di xampp
2. kunjungi http://localhost/phpmyadmin di browser
3. Buat database baru: **resto**

## Step 3 - Pasang Website

1. Buka folder yang di clone dari github melalui vscode
2. Jalankan perintah `composer update` (harus ada koneksi internet terlebih dahulu)
3. Buat file **.env** dari template **.env.example** dan ubah kredensial database pada file **.env** sesuai dengan keadaan server masing-masing
4. Jalankan perintah `php artisan key:generate`
5. Jalankan perintah `php artisan migrate:fresh`
6. Jalankan perintah `php artisan serve` dan kunjungi URL nya
