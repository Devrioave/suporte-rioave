# Setup Local (sem Docker)

## Pré-requisitos

- PHP 8.5+
- Composer
- Node.js + npm

## Passo a passo

```powershell
cd C:\Users\DaviBarbosa\Dev\suporte-rioave
php -d extension=zip C:\ProgramData\ComposerSetup\bin\composer.phar install --prefer-dist
npm.cmd install
copy .env.example .env
php artisan key:generate
npm.cmd run build
php artisan serve --host=127.0.0.1 --port=8000
```

## Banco local

Se usar SQLite local:

1. Habilitar no `C:\php\php.ini`:
   - `extension=pdo_sqlite`
   - `extension=sqlite3`
2. Criar `database/database.sqlite`.
3. Rodar:

```powershell
php artisan migrate --seed --force
```

