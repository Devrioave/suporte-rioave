# Resumo Geral das Mudanças

## Objetivo solicitado

Converter o sistema para identidade Rio Ave, corrigir idioma PT-BR e deixar a aplicação funcionando (local e Docker/MySQL).

## Entregas realizadas

1. Rebranding completo para Rio Ave.
2. Correção de textos com acentuação quebrada (mojibake).
3. Ajustes de execução local (dependências, APP_KEY, SQLite quando necessário).
4. Migração para Docker Compose com MySQL.
5. Correção de incompatibilidade SQL (MySQL x SQLite) no dashboard.
6. Ambiente Docker validado com app e banco em funcionamento.

## Estado final

- Aplicação em Docker: `http://127.0.0.1:8080`
- Banco MySQL em Docker (host): `127.0.0.1:3307`
- Usuário admin seeded e validado no banco.

