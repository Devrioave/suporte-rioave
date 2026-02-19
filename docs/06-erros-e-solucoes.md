# Erros Encontrados e Soluções

## 1) `vendor/autoload.php` ausente

- Causa: dependências PHP não instaladas.
- Solução: `composer install` (com `php -d extension=zip ...` quando necessário).

## 2) Falha Composer por git/cache/permissão

- Causa: fallback para clone git e permissões no cache.
- Solução: habilitar `zip`/usar cache local de projeto.

## 3) `No application encryption key has been specified`

- Causa: `.env` sem `APP_KEY`.
- Solução: `php artisan key:generate --force`.

## 4) SQLite: `could not find driver`

- Causa: `pdo_sqlite`/`sqlite3` desabilitados no PHP local.
- Solução: habilitar extensões no `php.ini`.

## 5) Dashboard: `TIMESTAMPDIFF` em SQLite

- Causa: SQL específico de MySQL.
- Solução: fallback por driver no controller:
  - SQLite: `julianday(...)`
  - MySQL: `TIMESTAMPDIFF(...)`

## 6) Docker: conflito da porta 3306

- Causa: serviço local já usando 3306.
- Solução: mapear MySQL Docker em `3307:3306`.

## 7) Docker MySQL não inicia (`unknown variable default-authentication-plugin`)

- Causa: parâmetro incompatível com MySQL 8.4.
- Solução: remover `command: --default-authentication-plugin=...`.

## 8) App container cai com `CollisionServiceProvider not found`

- Causa: cache antigo em `bootstrap/cache` referenciando pacote dev.
- Solução: limpar `bootstrap/cache/*.php` no build/start do container.

## 9) Seed falhando com `fake()` em produção

- Causa: imagem `--no-dev` sem faker.
- Solução: `DatabaseSeeder` sem factory, usando `updateOrCreate` direto.

