bitTracker
===

for those who want to track their own coin portfolio

how to use
---

### install

```bash
git clone git@github.com:sdleiw/bitTracker.git
cd bitTracker
composer install
cp .env.example .env
php artisan key:generate
```

### config

add api credentials in the `.env` file, supported platforms are

- binance
- bitfinex
- hitbtc

config database if authentication is needed 
and add auth middleware in the dashboard controller `app/Http/Controllers/DashboardController.php`

```php
public function __construct()
{
    $this->middleware('auth');
}
``` 

### start server

```
php artisan serve
goto http://127.0.0.1:8000
```

how to extend
---
adapters for other platforms consists of 3 parts: an api client, a transformer and config

- api client should implement `ApiClientInterface`
- transformer should implement `TransformerInterface` and registered in the config
- add the config in `config/api.php` and api credentials in `.env` 
