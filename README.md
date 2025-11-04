# GROUP 888 ONLINE LIBRARY MANAGEMENT
This is __GROUP 888__, our title is __Online Library Management__

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
```
class Example extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'example_table';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'account_id',
        'quantity',
        'price',
        'title',
        'description',
        'is_active',
        'settings',
        'publish_date',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'publish_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Each example belongs to one account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Example of a one-to-many relationship (if needed)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Example of an accessor
    public function getFormattedPriceAttribute()
    {
        return 'RM ' . number_format($this->price, 2);
    }
}
```

`..\database\factories\..`  
This folder store all the method use to generate random data for database. Itself cannot write data into database, must use with seeders.  

`..\database\migrations\..`  
This folder store all file that use to create database table that needed for this application. If you want to create a table run this code:
```
php artisan make:migration create_example_table
```
```
Schema::create('example_table', function (Blueprint $table) {
    /** 🔑 Primary keys & Foreign keys */
    $table->id(); // Auto-incrementing BIGINT (primary key)
    $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete(); // Foreign key reference

    /** 🧩 Integer & Numeric types */
    $table->tinyInteger('tiny_number')->default(0);      // 1-byte integer (-128 to 127)
    $table->smallInteger('small_number')->unsigned();    // 2-byte integer (0–65535)
    $table->integer('quantity')->default(1);             // 4-byte integer (-2B to 2B)
    $table->bigInteger('views')->unsigned();             // 8-byte integer (0–18 quintillion)
    $table->decimal('price', 8, 2)->default(0.00);       // Decimal with precision (8 digits total, 2 after decimal)
    $table->float('rating', 3, 2)->nullable();           // Float (less precise than decimal)
    $table->double('balance', 10, 2)->nullable();        // Double precision float

    /** 🔤 String & Text types */
    $table->string('title', 255);                        // VARCHAR(255)
    $table->char('code', 10);                            // Fixed-length CHAR(10)
    $table->text('description')->nullable();             // TEXT (up to 65,535 chars)
    $table->mediumText('summary')->nullable();           // MEDIUMTEXT (up to 16 million chars)
    $table->longText('content')->nullable();             // LONGTEXT (up to 4 billion chars)
    $table->json('settings')->nullable();                // JSON column for structured data

    /** 🗓️ Date & Time types */
    $table->date('publish_date')->nullable();            // YYYY-MM-DD
    $table->datetime('publish_datetime')->nullable();    // YYYY-MM-DD HH:MM:SS
    $table->time('publish_time')->nullable();            // HH:MM:SS
    $table->timestamp('approved_at')->nullable();        // DATETIME with timezone support
    $table->year('published_year')->nullable();          // 4-digit year

    /** ⚙️ Boolean & Enum types */
    $table->boolean('is_active')->default(true);         // Boolean (tinyint 0 or 1)
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // ENUM constraint

    /** 🧭 Other useful column types */
    $table->uuid('uuid')->unique();                      // UUID (36-character unique ID)
    $table->binary('file_data')->nullable();             // BLOB (binary data)
    $table->ipAddress('last_login_ip')->nullable();      // Stores IP addresses (IPv4/IPv6)
    $table->macAddress('device_mac')->nullable();        // MAC address (e.g., 00:1B:44:11:3A:B7)
    $table->rememberToken();                             // Adds nullable VARCHAR(100) for “remember me” login

    /** 🕒 Auto timestamps & soft deletes */
    $table->timestamps();                                // created_at & updated_at
    $table->softDeletes();                               // deleted_at (for soft delete feature)
});
```

`..\database\seeders\..`  
This folder store all file that use to insert pre-defined data into database. It can insert multiple row of data to different table in one time to make the process automatic.  

If you want to add multiple test data you need to use the Model that use for that table for example:
```
use App\Models\Example;
```
```
// ✅ Option 1: Insert using Eloquent model
    Example::create([
        'account_id' => 1,
        'quantity' => 10,
        'price' => 49.99,
        'title' => 'Sample Example Record',
        'description' => 'This is a sample record created using a seeder.',
        'is_active' => true,
        'settings' => json_encode(['theme' => 'dark', 'mode' => 'auto']),
        'publish_date' => Carbon::now()->subDays(5),
        'approved_at' => Carbon::now(),
    ]);

// ✅ Option 2: Insert multiple records using DB facade
    DB::table('example_table')->insert([
        [
            'account_id' => 1,
            'quantity' => 5,
            'price' => 25.00,
            'title' => 'Another Record',
            'description' => 'Inserted using DB::table',
            'is_active' => true,
            'settings' => json_encode(['mode' => 'manual']),
            'publish_date' => Carbon::now(),
            'approved_at' => Carbon::now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'account_id' => 2,
            'quantity' => 5,
            'price' => 25.00,
            'title' => 'Another Record',
            'description' => 'Inserted using DB::table',
            'is_active' => true,
            'settings' => json_encode(['mode' => 'manual']),
            'publish_date' => Carbon::now(),
            'approved_at' => Carbon::now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
```

If you have modify database's table or data you need to clear current database and recreate by running this code:
```
php artisan migrate:fresh
php artisan migrate:fresh --seed
```

### Frontend  
`..\resources\css\..`  
This folder store all of the custom css for website.  

`..\resources\js\..`  
This folder store all of the custom js for website.

`..\resources\view\..`  

__File Naming Rule__
> [!CAUTION]
> Please follow this for consistent file naming and structure

Laravel itself doesn’t require `index.blade.php`.
It’s just a convention that matches RESTful controller methods:

| Controller Method | Typical View | Use When |
| ----------------- | ------------ | -------- |
| index() | index.blade.php | For a list or main section page |
| show($id) | show.blade.php | For detail pages (e.g., book details) |
| create() | create.blade.php | For add new record form |
| edit($id) | edit.blade.php | For edit record form |
| profile() or custom | profile.blade.php | For specific functions like user profile |


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

### How to Redirect to other page
To use redirect function you will need to add it in `../routes/web.php`.

> [!IMPORTANT]
> all of the path will start from `../resources/views/..`.

#### Basic `GET` Route
If `example_page` is target page to redirect and is under same path:
```
Route::get('/example_page', function () {
    return view('example_page');
});
```

If `example_page` is target page to redirect and is under `../resources/views/layout/..`:
```
Route::get('/example_page', function () {
    return view('layout.example_page');
});
```

> [!CAUTION]
> If you having two `example_page` file with same name but under different path, you need to avoid using same url. It shoulde be `Route::get('/example_page', function () {..})` and `Route::get('/example_page1', function () {..})`.

`GET` Route sending data to other page
```
Route::get('/example_page', function () {
    $user = session('user');
    return view('example_page', compact('user'));
});
```

Example way using `GET` route:
```
<a href="{{ route('example') ?? url('/example_page') }}"
    class="">Example</a>
```

#### Basic `POST` Route
`POST` is normally used for submitting forms (login, register, update data).
```
Route::post('/example_function', function () {
    // handle calculation etc code
    return redirect('/example_page2');  // redirect to specific page or original page
})->name('example_function');

```
Example form using `POST` route:
```
<form action="{{ route('example_function') }}" method="POST">
    @csrf
    <input type="text" name="email">
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>
```

### Session
Store data to session :
```
session([
    'account_id' => 1,
    'username' => "example"
    ]);
```

Call data from session :
```
Welcome, {{ session('username', 'Guest') }}
```

Clear session :
```
session()->flush();
```