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
- PHP 8.4.13
- Node.js 24.11.0

## Database
### SQL Server Management Studio (SSMS)
If you are decided to use __SQL Server Management Studio__ as the database, you will need to install two extension for `php 8.4`:
- [sqlsrv.dll 5.12](https://pecl.php.net/package/sqlsrv) and
- [pdo_sqlsrv.dll 5.12](https://pecl.php.net/package/pdo_sqlsrv)
These file should be place under `php/ext/..` path and add these code to your `php.ini`.
```
extension=php_pdo_sqlsrv.dll
extension=php_sqlsrv.dll
```

### MYSQL

## Installation
- Laravel 12.x



## Pre-Launch Setup
1. duplicate `.env.example` file and rename asn `.env`
2. remove `#` of `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in line `24 - 28`

## How To Launch
Before launch the web, ensure you are under the path of the project then run:
    > php artisan serve
the web will be launch at port http://127.0.0.1:8000
