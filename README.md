# php query builder
php orqali ma'lumotlar bazasiga so'rovlarlarni yuborish uchun ishlab chiqilgan kichik kutubxona
## Ishga tushurish
### fayllarni sozlash
1. `.env` fayli `.env.example` kabi ochiladi
2. `.env` fayliga kerakli ma'lumotlar kiritiladi
```dotenv
DATABASE=your_database
HOST=your_host
DB_NAME=your_dbname
DB_USER=your_dbusername
DB_PASSWORD=your_dbpassword
```
3. `index.php` faylini oching
4. Terminalda `composer dump-autoload` buyrug'ini bering. (Sizda composer o'rnatilmagan bo'lsa uni [o'rnating](https://getcomposer.org/download/))
5. `index.php` fayligi composer orqali barcha class'larni chaqirib olish uchun quyidagi kodlarni qo'shing:
```php
<?php
require 'vendor/autoload.php';
```
So'rovlarni amalga oshirish uchun 2 xil usul mavjud
1. Query class'dan foydalanish
2. O'zingizning Modelingizni e'lon qilish

- Query class'dan foydalanish:
   - Query class orqali ishlashda `Query::setTable()` metodidan foydalanishimiz kerak bo'ladi, bu bizga so'rovlar qaysi table ga tegishli ekanligini belgilaydi
   ```php
  <?php
  require 'vendor/autoload.php';
    
  use Core\database\Query;
    
  Query::setTable('users');
    
  ```
  - Biror methodni qo'llab ko'ramiz, masalan create, quyidagi kodlar orqali users table'ga yangi ma'lumot kiritamiz:
  ```php
  <?php

  use Core\database\Query;

  Query::setTable('users');
  Query::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
   ```
- Model orqali
  - `Core/Models` ichida biror model uchun fayl yarating, namespace'larga e'tibor bering
  - `Core/Models/User.php`:
  ```php
  <?php

  namespace Core\Models;

  use Core\database\Model;

  class User extends Model {
      protected static $table_name = 'users';
  }      
  ```
  - Yuqoridagi `$table_name` ushbu Model so'rovlarni qaysi table'ga yuborishligini belgilaydi
  - `index.php` faylida User modelni ishlatamiz, quyidagi kod users table'ga yangi ma'lumot kiritadi:
  ```php
    <?php
    
    use Model\Models\User;
  
    User::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
  ```
### Metodlar:
1. `create()` metodi - ma'lumotlar bazasiga biror yangi ma'lumot kiritish:
```php
User::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
Query::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
```
2. `where() orwhere()` metodi - ma'lumotlar bazasidan ma'lumot olish:
```php
$data = User::where('name', 'Komiljonov')->get();
$data = Query::where('name', 'Komiljonov')->get();

$data = User::where('name', 'Komiljonov')->orWhere('id', '=', 37)->get();
$data = Query::where('name', 'Komiljonov')->orWhere('id', '=', 37)->get();
```
3. `update()` metodi - ma'lumotlar bazisidan ma'lumotni yangilash:
```php
User::update(['name'=>'Obidjon Komiljonov','email'=>'komiljonovdev@gmail.com']);

User::where('id','46')->orWhere('id', '45')->update(['name'=>'Obidjon Komiljonov','email'=>'komiljonovdev@gmail.com']);
```
4. `getQuery()` metodi - sql query'ni olish uchun:
```php
echo User::getQuery();
echo Query::getQuery();
```