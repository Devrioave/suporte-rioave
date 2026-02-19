# Correção de Português do Brasil (PT-BR)

## Problema

Após alterações iniciais, vários textos ficaram com codificação quebrada (ex.: `TÃ©cnico`, `SoluÃ§Ãµes`, emojis ilegíveis).

## Ação realizada

- Conversão/correção de conteúdo textual em arquivos de view/controller/rotas.
- Revisão de textos com acentuação e caracteres especiais.
- Validação por busca de padrões de mojibake.

## Arquivos corrigidos

- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/acompanhar.blade.php`
- `resources/views/admin/index.blade.php`
- `resources/views/dashboard.blade.php`
- `resources/views/auth/register.blade.php`
- `app/Http/Controllers/ChatBotController.php`
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `routes/web.php`

## Observação técnica

Em alguns arquivos PHP houve ocorrência de BOM UTF-8, removida para evitar erro:

- `Namespace declaration statement has to be the very first statement`

