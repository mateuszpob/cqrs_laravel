Start aplikacji:
    git clone https://github.com/mateuszpob/cqrs_laravel.git
    cd cqrs_laravel
    composer install
    cp .env.example .env
    php artisan sail:install
    sail up

Uruchomienie testów:
    sail artisan test

Generowanie dokumentacji:
    php artisan l5-swagger:generate

Dokumentacja pod adresem:
    /api/documentation


Każde zapytanie do API (z wyjątkiem /api/login i /api/register) musi mieć dodany nagłówek "Authorization" o wartośći "Bearer xxxxxxxxxxxxxxxxxxxx" gdzie "xxxxxxxxxxxxxxxxxxxx" jest tokenem uzyskanym podczas logowania.

Każde zapytanie do API powinno być wysyłane z nagłówkiem "Accept: application/json"
