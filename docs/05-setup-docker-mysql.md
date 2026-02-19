# Setup Docker Compose com MySQL

## Arquivos envolvidos

- `docker-compose.yml`
- `dockerfile`
- `docker/nginx.conf`

## Serviços

- `app`: Laravel + PHP-FPM + Nginx (porta host `8080`)
- `db`: MySQL 8.4 (porta host `3307`, container `3306`)

## Comandos

```powershell
docker compose up -d --build
docker compose exec app php artisan migrate --seed --force
```

## Acesso

- Aplicação: `http://127.0.0.1:8080`
- MySQL host: `127.0.0.1:3307`

## Variáveis principais usadas no compose

- `DB_CONNECTION=mysql`
- `DB_HOST=db`
- `DB_PORT=3306`
- `DB_DATABASE=suporte_rioave`
- `DB_USERNAME=rioave`
- `DB_PASSWORD=rioave123`

