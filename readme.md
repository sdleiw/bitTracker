bitracker demo
===

demo repo for package [bitracker](https://github.com/sdleiw/bitracker)

how to use
---

### install

```bash
composer create-project sdleiw/bitracker-demo
# config .env api keys
php artisan serve
goto http://127.0.0.1:8000
```

### config

add api credentials in the `.env` file, supported platforms are

- binance
- bitfinex
- hitbtc

### cache

results from all calls will be cached for 5 minutes
