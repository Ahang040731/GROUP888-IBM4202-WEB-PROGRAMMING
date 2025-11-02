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
### PHP 8.4.13
If you download `PHP` from officel website, ensure you had add these code to your `php.ini`.
```
extension_dir = "ext"

extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=zip
```

### Node.js 24.11.0

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
- Laravel 12.x



## Pre-Launch Setup
1. duplicate `.env.example` file and rename asn `.env`
2. remove `#` of `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in line `24 - 28`

## How To Launch
Before launch the web, ensure you are under the path of the project then run:
> php artisan serve

the web will be launch at port:

http://127.0.0.1:8000


## How to develop
### Database  
`..\app\Models\..`  
This folder store all of the data of table as model. All of the data should use this method to store and call.  

`..\database\factories\..`  
This folder store all the method use to generate random data for database. Itself cannot write data into database, must use with seeders.  

`..\database\migrations\..`  
This folder store all file that use to create database table that needed for this application.  

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
