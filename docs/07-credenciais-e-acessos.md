# Credenciais e Acessos

## Admin do sistema

- E-mail: `admin@rioave.com.br`
- Senha: `rioave@2026`

## Docker Compose

- URL app: `http://127.0.0.1:8080`
- MySQL host: `127.0.0.1`
- MySQL porta host: `3307`
- MySQL database: `suporte_rioave`
- MySQL user: `rioave`
- MySQL password: `rioave123`
- MySQL root password: `root`

## Comandos úteis

Subir:

```powershell
docker compose up -d --build
```

Migrar/seed:

```powershell
docker compose exec app php artisan migrate --seed --force
```

Ver status:

```powershell
docker compose ps
```

Parar:

```powershell
docker compose down
```

