Start aplikacji:

```bash
  git clone https://github.com/mateuszpob/cqrs_laravel.git
```
```bash
  cd cqrs_laravel
```
```bash
  composer install
```
```bash
  cp .env.example .e
```
```bash
  php artisan sail:install
```
```bash
  sail up
```

Uruchomienie testów:
    
```bash
  sail artisan test
```
Generowanie dokumentacji:
```bash
    php artisan l5-swagger:generate
```

Dokumentacja pod adresem:
```http
    /api/documentation
```

Każde zapytanie do API (z wyjątkiem /api/login i /api/register) musi mieć dodany nagłówek "Authorization" o wartośći "Bearer xxxxxxxxxxxxxxxxxxxx" gdzie "xxxxxxxxxxxxxxxxxxxx" jest tokenem uzyskanym podczas logowania.

Każde zapytanie do API powinno być wysyłane z nagłówkiem "Accept: application/json"
