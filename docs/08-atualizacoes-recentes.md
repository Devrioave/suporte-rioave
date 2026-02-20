# Atualizações Recentes

## 1) Modo escuro (dark mode)

- Adicionado toggle de tema (claro/escuro) nas layouts:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/layouts/guest.blade.php`
- Preferência persistida em `localStorage` (`theme`).
- Dark mode habilitado no Tailwind com `darkMode: 'class'` em `tailwind.config.js`.
- Estilos globais de suporte ao tema escuro incluídos em `resources/css/app.css`.

## 2) Atualização de logo sem cache antigo

- Ajustado carregamento da logo com versionamento por `filemtime`:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/components/application-logo.blade.php`
- Resultado: ao trocar `public/images/logo.png`, o navegador atualiza a imagem sem manter versão antiga em cache.

## 3) Docker para desenvolvimento sem rebuild constante

- Criado `docker-compose.override.yml` com bind mount do projeto:
  - `./:/var/www/html`
- Volumes dedicados adicionados para evitar conflito de dependências:
  - `app_vendor` -> `/var/www/html/vendor`
  - `app_node_modules` -> `/var/www/html/node_modules`
  - `app_public_build` -> `/var/www/html/public/build`
- Fluxo atualizado no `README.md`:
  - primeira vez: `docker compose up -d --build`
  - dia a dia (mudanças de código/assets): `docker compose up -d`

## 4) PT-BR e codificação

- Correções de textos com acentuação quebrada no fluxo de solicitação/protocolo em:
  - `app/Http/Controllers/SolicitacaoController.php`
- Arquivo com BOM removido para evitar erro no fluxo de sessão/CSRF:
  - `routes/web.php`
