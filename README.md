<h1 style="text-align:center; font-weight:bolder;">Catatan Sebelum Melakukan Admin-section</h1>

## Beberapa Catatan Terkait Penggunaan Repository Ini
1. Silahkan melakukan kloning pada repository ini dengan meng-copy url repository

2. Setelah melakukan kloning ketikan di terminal perintah berikut. Bertujuan agar APP KEY update otomatis dan vendor akan terinstal serta .env akan terbentuk
     ```shell
        composer update
     ```
     ```shell
        cp .env.example .env
     ```
     ```shell
        php artisan key:generate
     ```
     ```shell
        Modifikasi .env dengan menambahkan sintak berikut untuk terhubung ke database bagian user:
        DB_CONNECTION_2=mysql2
        DB_HOST_2=127.0.0.1
        DB_PORT_2=3306
        DB_DATABASE_2=technisi_web2 //sesuaikan nama database yang terhubung ke user
        DB_USERNAME_2=root
        DB_PASSWORD_2=
     ```
     ```shell
        Buka database.php dan atur mysql2 dengan nama database kedua seperti yang diatur sebelumnya
     ```
     ```shell
        php artisan migrate
     ```
     ```shell
        php artisan db:seed
     ```
     ```shell
        Ketik npm install
     ```
     ```shell
        Ketik npm audit fix
     ```
     ```shell
        Ketik npm update vue-loader
     ```
     ```shell
       Tekan split terminal di pojok terminal VS Code dan ketik php artisan serve di bagian kiri dan npm run watch di bagian kanan. Apabila ingin menjalankan 2 laravel secara bersamaan, yakni menjalankan laravel user dan admin, maka pada bagian admin ini di terminal bagian kiri bisa di ketik php artisan serve --port = 8081. Sehingga admin akan berjalan di localhost:8081, sedangkan user akan tetap berjalan di localhost:8000
     ```
     ```shell
        Login dengan username = "admin" dan password = "password"
     ```
     ```shell
        Agar bisa masuk menu dashboard link nya http://localhost:8081/admin/dashboard
     ```
3. Install beberapa package berikut
    - Laravel Debugbar -> Untuk membantu proses debug
        ```shell
        composer require barryvdh/laravel-debugbar --dev
        ```
    - Laravel Query Detector -> Membantu proses pengecekan query
        ```shell
        composer require beyondcode/laravel-query-detector --dev
        ```
    - Laravel IDE Helper
        ```shell
        composer require --dev barryvdh/laravel-ide-helper
        ```
    - Doctrine/dbal
        ```shell
        composer require doctrine/dbal
        ```

4. Ketentuan
    ```shell
        1. Harus melakukan refresh setelah melakukan CRUD agar dapat menggunakan CRUD lagi
        2. Terkadang ada freeze atau stuck, harus di refresh
        3. Dalam bagian edit, di bagian dropdown harus diisi lagi, karena sementara belum bisa otomatis terisi dengan data dari database
        4. Terdapat 2 role di admin yakni admin dan user. Admin dapat melakukan CRUD di semua fitur. Jika user tidak bisa melakukan CRUD di fitur admin, role, dan permission
        5. Jika membuat akun baru di admin, pastikan setelah membuat akun, lakukan edit dengan memilih role nya apakah jadi user atau admin. Apabila role kosong, maka saat login akan dilarang masuk jika tidak punya status role
        6. Untuk ganti password bisa dilakukan dengan menekan halaman site, kemudian diarahkan pada menu dashboard jetstream yang berwarna putih, maka klik profile di pojok kanan dan langsung bisa ganti password di kolom tersebut
    ```
 
 5. Hasil screencshot
 
 ## Halaman Home

    
