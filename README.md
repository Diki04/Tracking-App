Langkah Pembuatan:
1. Koneksikan Database
2. Lalu buat Model, Controller dan Migrasi nya lalu migrasikan ke database
3. Membuat seed sebagai data dummy login as a admin
4. Buat sebuah route Api untuk sistem login yang memang sudah disediakan laravel php artisan install:api
5. Lalu buat fungsi di AuthController sebagai sistem login dan me sebagai yang menangkap data yang sudah/sedang login
6. Install Resources, php artisan make:resource UserResource sebagai response untuk user supaya beberapa saja yang diperlihatkan, tidak detail seperti di database yang menampilkan token dan hal kredensial lainnya
7. Lalu setelah buat fungsi me di AuthController maka masukkan ke routes/api lalu tambahkan middleeware auth-sanctum dan masukkan ke group function
8. Lalu buat logout
9. Buat fungsi register dan buat php artisan make:request RegisterStoreRequest berguna untuk memvalidasi data yang wajib di isi pada setiap register yang dibuat