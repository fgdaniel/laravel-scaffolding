# Information

Dont clone this project, just copy files content in their location or make folder structure like this project.

## Commands

This command will do new blade file in directory `resources/dashboard/views/components` and component controller in `app/View/Components/Dashboard`

```bash
php artisan dash:component <Name>
```

---

This command will do new blade file in directory `resources/frontend/views/components` and component controller in `app/View/Components/Frontend`

```bash
php artisan front:component <Name>
```

---

This command will do new livewire component in `app/Http/LiveWire/Dashboard` and their blade file in `resources/dashboard/views/livewire`

```bash
php artisan dash:wire <Name>
```

---

This command will do new livewire component in `app/Http/LiveWire/Frontend` and their blade file in `resources/frontend/views/livewire`

```bash
php artisan front:wire <Name>
```

## Alias

To point for dashboard view/blade you can do this in routes or blade
Note: For the frontend automatically load blade file from `resources/frontend/views`

Exemple for `routes/web.php`

```php
Route::get('/', function () {
    return view('dashboard::pages.home');
}); // This load blade file from resources/dashboard/pages/home.blade.php
```

Exemple for blade

```php
@include('dashboard::includes.head')
```

To point for frontend view/blade you can do this in routes or blade

Exemple for `routes/web.php`

```php
Route::get('/', function () {
    return view('pages.home');
}); // This load blade file from resources/frontend/pages/home.blade.php
```

Exemple for blade

```php
@include('includes.head')
```

# Why this structure ?

Considering that during the development of a project many files will be made for both dashboard and frontend parts, so with this structure you can keep the files under control, it is more intuitive from my point of view.

# Extra information

Feel free to make pull-request to improve this structure.

I'm not the most skilled, so I did this structure as I knew it at the moment, but I'm convinced that there is someone in this world who is more skilled who can come up with suggestions and improvements.

### Road map

- [ ] Auth system in dashboard side
- [ ] Form components like `inputs/textarea/radio/checkbox` in dashboard side
- [ ] Form components like `inputs/textarea/radio/checkbox` in frontend side
- [ ] CRUD Generator/management for `dashboard` and `frontend` with generating required files like `blade files, controllers, models`, etc.