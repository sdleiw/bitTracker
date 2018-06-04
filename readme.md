bitracker demo
===

demo repo for package [bitracker](https://github.com/sdleiw/bitracker)

how to use
---

### install

```bash
git clone https://github.com/sdleiw/bitracker-demo
cd bitracker-demo
composer install
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=public
# config .env api keys
```

### config

add api credentials in the `.env` file, supported platforms are

- binance
- bitfinex
- hitbtc

### start server

```
php artisan serve
goto http://127.0.0.1:8000
```

### cache

results from all calls will be cached for 5 minutes
