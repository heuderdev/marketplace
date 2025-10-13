# 🚀 Marketplace Laravel 12 + Livewire 3 + Mercado Pago

Sistema completo de e-commerce e venda de eBooks utilizando Laravel 12, Livewire 3 e integração nativa com Mercado Pago para pagamento via Checkout Pro (cartão, boleto, saldo, PIX) e pagamento PIX direto.  
Foco em performance, modularidade e experiência do usuário.

---

## **Funcionalidades**
- Autenticação e painel seguro (Laravel Breeze + Livewire)
- Listagem dinâmica de produtos/ebooks (Livewire)
- Compra de ebooks: Checkout Pro Mercado Pago
- Pagamento exclusivo via PIX (QR e “copia e cola”)
- Criação automática de Order vinculada ao usuário e produto
- Rotas de retorno (success, failure, pending) e Webhook para atualização instantânea da ordem
- Systema responsivo e pronto para produção

---

## **Fluxo de Compra**

1. Usuário faz login.
2. Visualiza produtos disponíveis e seleciona para comprar.
3. Sistema salva a Order (`status=pending`) e inicia o pagamento.
4. Usuário escolhe Checkout Pro (todas opções) ou PIX direto.
5. Após finalizar o pagamento, retorna para sua loja (pending).
6. Sistema aguarda confirmação do Mercado Pago via webhook (notification_url).
7. Quando aprovado, libera o ebook automaticamente.

---

## **Integração Mercado Pago**

- Utiliza o SDK `"mercadopago/dx-php": "^3.7"` (PHP 8.2+)
- **Checkout Pro:** Redirecionamento para página Mercado Pago com todas opções (cartão, boleto, saldo, PIX)
- **PIX direto:** Gera QR Code, link e “copia e cola” para pagamento instantâneo.
- Utiliza o campo `external_reference` para vincular pagamentos à ordem e ao usuário.
- Webhook (notification_url) para atualização do status da order no backend.

---

## **Rotas principais**

| Método | Rota                 | Propósito                       |
|--------|----------------------|---------------------------------|
| GET    | /products            | Listagem de ebooks              |
| GET    | /pagamento/success   | Retorno pós-pagamento aprovado  |
| GET    | /pagamento/failure   | Retorno pós-pagamento falhado   |
| GET    | /pagamento/pending   | Retorno pendente do pagamento   |
| ANY    | /pagamento/webhook   | Recebe POST do Mercado Pago     |

---

## **Pré-requisitos**

- PHP >= 8.2
- PostgreSQL ≥ 13
- Composer
- Node/NPM

---

## **Instalação**

