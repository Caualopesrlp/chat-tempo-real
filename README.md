# 💬 Chat em Tempo Real com WebSockets e Laravel Reverb

Este repositório contém uma aplicação de chat em tempo real desenvolvida para fins de estudo e prática dos conceitos fundamentais de comunicação bidirecional via **WebSockets**, utilizando **Laravel 11**, **Laravel Reverb** e **JavaScript nativo com Laravel Echo**.

O objetivo principal deste projeto foi entender na prática a transição do protocolo HTTP para WebSockets, o funcionamento do *handshake*, *broadcast* de eventos e o gerenciamento de canais privados de comunicação.

---

## 🚀 Tecnologias Utilizadas

* **Backend:** PHP 8.2+ / Laravel 11
* **WebSocket Server:** Laravel Reverb
* **Frontend:** Blade, TailwindCSS, JavaScript (ES6+)
* **WebSocket Client:** Laravel Echo + Pusher JS
* **Banco de Dados:** SQLite / MySQL

---

## 📌 Conceitos Praticados neste Estudo

* **Protocolo WebSocket (`ws://` / `wss://`):** Diferenças em relação ao modelo Request/Response do HTTP tradicional.
* **Aperto de Mão (*Handshake*):** Troca de protocolo via status HTTP `101 Switching Protocols`.
* **Servidor de WebSocket Dedicado:** Configuração e execução do Laravel Reverb em paralelo ao servidor HTTP.
* **Event Broadcasting:** Uso da interface `ShouldBroadcast` e disparos via `broadcast(new MessageSent($message))->toOthers()`.
* **Canais Privados (*Private Channels*):** Restrição e autorização de acesso a salas de chat específicas (`routes/channels.php`).
* **Tratamento de Duplicação no Cliente:** Gerenciamento de estado e controle de envio do `X-Socket-ID`.

---

## 🛠️ Como Executar o Projeto Localmente

### Pré-requisitos
* PHP 8.2 ou superior
* Composer
* Node.js (v20+) e NPM

### Passo a Passo

1. **Clonar o repositório:**
   ```bash
   git clone https://github.com/Caualopesrlp/chat-tempo-real.git
   cd chat-tempo-real
   ```

2. **Instalar as dependências do PHP:**
   ```bash
   composer install
   ```

3. **Instalar as dependências do Node.js:**
   ```bash
   npm install
   ```

4. **Configurar o Arquivo de Ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar o Banco de Dados e Migrations:**
   Certifique-se de configurar o banco de dados desejado no `.env` (SQLite é o padrão) e execute:
   ```bash
   php artisan migrate
   ```

6. **Executar a Aplicação:**
   Para o funcionamento correto em tempo real, execute os 3 comandos abaixo em **terminais separados**:

   * **Terminal 1 (Servidor HTTP):**
     ```bash
     php artisan serve
     ```

   * **Terminal 2 (Servidor WebSocket Reverb):**
     ```bash
     php artisan reverb:start
     ```

   * **Terminal 3 (Compilador de Assets Vite):**
     ```bash
     npm run dev
     ```

7. **Acessar o Chat:**
   Abra o navegador em `http://127.0.0.1:8000`, faça o registro/login de duas contas diferentes em abas/navegadores distintos e acesse a rota `/chat` para testar a troca de mensagens em tempo real.

---

## 📝 Licença

Este projeto é de código aberto e foi desenvolvido estritamente para fins educacionais e de aprendizado pessoal.
