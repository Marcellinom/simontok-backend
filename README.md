<p align="center"><img src="https://user-images.githubusercontent.com/74979139/197404526-9df78957-1dc6-424c-ae84-79b115a7b664.png" alt="Stocky Logo"></p>

# Description
Project ini menggunakan Framework Laravel dan menggunakan Eloquent Model.

Arsitektur yang digunakan terinspirasi dari Arsitektur Onion, tetapi disini tidak menggunakan dependency injection melainkan semua dependency ada di dalam Model.

## To Contribute
1. clone atau fork repository ini
2. ```composer install```
3. ```cp .env.example .env```
4. ```php artisan key:generate```
5. ```php artisan migrate```

## File Structure Documentation
- Flow aplikasi:
```Route``` -> ```Controller``` -> ```Services```

![image](https://user-images.githubusercontent.com/74979139/197405462-beec9a30-e71f-4ca5-873e-11b88a2ab916.png)

- Services dalam folder ```Services``` memiliki dependency ke Model, jadi gunakanlah class dalam Model untuk CRUD di service
- pada controller, jika sebuah service perlu menggunakan Database Transaction, gunakanlah function helper
https://github.com/Marcellinom/simontok-backend/blob/470eec0a18ada068d39768ec6b09c0ec410b89e5/app/Http/Controllers/UserController.php#L35
- jika merasa perlu menambakan fungsi helper, ada di ```App/helpers.php```

## Model Documentation
untuk mempermudah penggunaan functional model, dibuat sistem getter setter yang depends kepada ```public const ATTRIBUTES``` dalam class Model

- pemanggilan getter dan setter dipanggil melalui trait ```App/Models/Shared/SimontokClassTrait.php``` yang harus di use di setiap Model:
https://github.com/Marcellinom/simontok-backend/blob/470eec0a18ada068d39768ec6b09c0ec410b89e5/app/Models/Otp.php#L38-L44

- ```ATTRIBUTES``` diisi nama kolom beserta type nya, jika memiliki default value gunakan "|" dalam type nya:
https://github.com/Marcellinom/simontok-backend/blob/6184ec109adb76abea4eed1d10b3f969fe968e5d/app/Models/User.php#L87-L96

- karena getter setter dipanggil menggunakan magic method dari ```__call()``` method di ```App/Models/Shared/SimontokClassTrait.php```, agar IDE dapat nge-load intellisense methodnya, jalankan command ```php artisan generate:model-docs``` setiap membuat model atau perubahan baru:
![image](https://user-images.githubusercontent.com/74979139/197405323-8e8c302f-4317-4796-a5de-4c1d6b8430e5.png)
