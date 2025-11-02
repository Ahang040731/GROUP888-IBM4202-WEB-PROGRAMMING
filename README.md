# GROUP 888 ONLINE LIBRARRY MANAGEMENT

This is GROUP 888, our title is Online Library Management

## Table of Content
[Group Member](#group-member)  
[Require](#require)  
[Database](#database)  
[Installation](#installation)  
[Pre-Launch Setup](#pre-launch-setup)  
[How To Launch](#how-to-launch)

## Group Member
- [Boon Shi Ying](https://github.com/hazzelying0803)
- [Chiew Yong Jie](https://github.com/Jamie-chew)
- [Dwalton Voo Jia Leung](https://github.com/ShirA-99)
- [Lian Yi Heng](https://github.com/Ahang040731)
- [Ooi Xing Hong](https://github.com/Kagura5201314)

## Require
### php 8.4
After install [php](https://www.php.net/downloads.php), ensure you had add these code to your `php.ini`.
```
extension_dir = "ext"

extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=zip
```

### Node.js 24.11
[Node.js](https://nodejs.org/en) is require as it handle frontend asset bundler. Without it Tailwind CSS, React, Vue, or modern JavaScript cannot be use

## Database
### SQL Server Management Studio (SSMS)
If you are decided to use __SQL Server Management Studio__ as the database, you will need to install two extension for `php 8.4`:

- [sqlsrv.dll 5.12](https://pecl.php.net/package/sqlsrv)
- [pdo_sqlsrv.dll 5.12](https://pecl.php.net/package/pdo_sqlsrv)

These file should be place under `../php/ext/..` path and add these code to your `php.ini`:
```
extension=php_pdo_sqlsrv.dll
extension=php_sqlsrv.dll
```

### MySQL
For __MySQL__, you will need to add these code to your `php.ini`:
```
extension=pdo_mysql
extension=mysqli
```

### SQLite
For __SQLite__, you will need to add these code to your `php.ini`:
```
extension=pdo_sqlite
extension=sqlite3
```

## Installation
### Laravel 12.x
To install __Laravel__ you are rquire to install [Composer](https://getcomposer.org/download/) first.  
After installed [Composer](https://getcomposer.org/download/), you need to download this project, then go to the project path and run:
```
composer install
npm install
```


## .env Setup
ensure your under your project root path and run this code:
```
cp .env.example .env
php artisan key:generate
```

Then, depends on what database you want to use chose one from them:
1. SQL Server Management Studio (SSMS)
```
DB_CONNECTION=sqlsrv
DB_HOST=localhost\SQLEXPRESS
DB_PORT=1433
DB_DATABASE="example database"
DB_USERNAME=example
DB_PASSWORD=example
DB_ENCRYPT=yes
DB_TRUST_SERVER_CERTIFICATE=true
```
- `DB_HOST`: The server name should base on your SQL Express Server register name for example your server register as `SQLEXPRESSserver`, your `DB_HOST=` value should be `localhost\SQLEXPRESSserver`.  
- `DB_PORT`: You need to go SQL Server Manager(SQLServerManager16.msc) under your `C:\Windows\SysWOW64\..` to enable it.  

2. MYSQL
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="example database"
DB_USERNAME=example
DB_PASSWORD=example
```
3. SQLITE
```
DB_CONNECTION=sqlite
```

After finish all these config, run this in terminal under the project path:
```
php artisan migrate
```


## How To Launch
Before launch the web, ensure you are under the path of the project then run:
```
npm run dev
php artisan serve
```
the web will be launch at port:

> http://127.0.0.1:8000


## How to develop
### Database  
`..\app\Models\..`  
This folder store all of the data of table as model. All of the data should use this method to store and call.  

`..\database\factories\..`  
This folder store all the method use to generate random data for database. Itself cannot write data into database, must use with seeders.  

`..\database\migrations\..`  
This folder store all file that use to create database table that needed for this application. If you want to create a table run this code:
```
php artisan make:migration create_example_table
```

`..\database\seeders\..`  
This folder store all file that use to insert pre-defined data into database. It can insert multiple row of data to different table in one time to make the process automatic.  

### Frontend  
`..\resources\css\..`  
This folder store all of the custom css for website.  

`..\resources\js\..`  
This folder store all of the custom js for website.

`..\resources\view\..`  
This folder store all web page. Ensure all of the page is using `example.blade.php` format.

`..\resources\view\layouts\app.blade.php`  
This file is the one storing the header and sidemenu. For those page require header and side menu ensure you call it before your own coding. Example:   
```
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- YOUR OWN CONTENT -->

@endsection
```  
### Backend  
`..\app\Http\Controllers\..`  
This folder store all of the backend file. The file name should follow the frontend file name with `Controller` at the back for example `DashboardController.php`.  
