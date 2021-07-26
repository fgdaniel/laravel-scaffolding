# Information

Dont clone this project, just copy files content in their location or make folder structure like this project.

## Commands

You can install the package via composer:

```bash
php artisan dash:component <Name>
```

This command will do new blade file in directory `resources/dashboard/views/components` and component controller in `app/View/Components/Dashboard`

```bash
php artisan front:component <Name>
```

This command will do new blade file in directory `resources/frontend/views/components` and component controller in `app/View/Components/Frontend`

## Alias

To point for dashboard view/blade you can do this in routes or blade

Exemple for routes/web.php

```bash
Route::get('/', function () {
    return view('dashboard::pages.home');
}); // This load blade file from resources/dashboard/pages/home.blade.php
```

Exemple for blade

```bash
@include('dashboard::includes.head')
```

To point for frontend view/blade you can do this in routes or blade

Exemple for routes/web.php

```bash
Route::get('/', function () {
    return view('pages.home');
}); // This load blade file from resources/frontend/pages/home.blade.php
```

Exemple for blade

```bash
@include('includes.head')
```