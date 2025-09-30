# Sistema de Checklist Operacional (CRUD)

> Um sistema web simples, porém robusto, para digitalizar e gerenciar checklists de abertura e fechamento de estabelecimentos comerciais. O projeto foi desenvolvido de forma progressiva, culminando em uma aplicação CRUD completa com PHP e MySQL.

Este projeto substitui checklists manuais em papel por um formulário digital acessível em dispositivos móveis. Ele permite registrar informações cruciais, capturar a geolocalização do preenchimento e manter um histórico centralizado e de fácil consulta, edição e remoção.

---

## 🚀 Sobre o Projeto

O objetivo principal é fornecer uma ferramenta interna para garantir que todos os procedimentos operacionais de segurança e funcionamento sejam seguidos rigorosamente. A aplicação permite um controle gerencial mais eficaz, centralizando os dados que podem ser acessados e auditados a qualquer momento.

---

## ✨ Funcionalidades Principais (CRUD)

A aplicação implementa todas as operações essenciais de um sistema de gerenciamento de dados:

* **CREATE (Criar):**
    * Registrar novos checklists, com formulários específicos para **Abertura** e **Fechamento**.
    * Preenchimento automático da data atual.
    * (Funcionalidade anterior) Captura de coordenadas GPS para auditoria de local.

* **READ (Ler):**
    * Visualizar todos os registros em uma tabela limpa e organizada.
    * Distinção visual clara entre registros de Abertura (verde) e Fechamento (vermelho).
    * Acesso rápido às ações de edição e exclusão para cada registro.

* **UPDATE (Atualizar):**
    * Editar qualquer registro existente através de um formulário dinâmico e pré-preenchido.
    * Permite a correção de informações como nomes, checklists e observações.

* **DELETE (Excluir):**
    * Excluir registros de forma segura, utilizando um modal de confirmação para prevenir remoções acidentais.

---

## 🛠️ Tecnologias Utilizadas

Este projeto foi construído utilizando um stack de tecnologias padrão e amplamente conhecidas no desenvolvimento web:

* **Front-End:**
    * HTML5
    * CSS3
    * JavaScript (ES6) para interatividade e requisições AJAX (`fetch`).
* **Framework CSS:**
    * [Bootstrap 5](https://getbootstrap.com/) para criar uma interface responsiva e moderna rapidamente.
    * [Bootstrap Icons](https://icons.getbootstrap.com/) para a iconografia.
* **Back-End:**
    * PHP 8+
* **Banco de Dados:**
    * MySQL / MariaDB
* **Ambiente de Servidor Local:**
    * XAMPP (ou similar como WAMP, MAMP, Laragon).

---

## 📂 Estrutura de Arquivos

O projeto é organizado de forma modular para facilitar a manutenção e escalabilidade:

```
/checklist-operacional/
│
├── template/
│   ├── header.php          # Cabeçalho HTML reutilizável (inclui navbar)
│   └── footer.php          # Rodapé HTML reutilizável (inclui scripts JS)
│
├── db_connection.php       # Script central de conexão com o banco de dados
├── index.php               # Menu principal da aplicação
├── listar_registros.php    # Página de listagem dos checklists (Read)
├── form.php                # Formulário inteligente para criar e editar (Create/Update)
├── salvar.php              # Lógica back-end para salvar/atualizar registros
├── excluir.php             # Lógica back-end para excluir registros (Delete)
└── style.css               # Folha de estilos customizada
```

---

## 🏁 Como Executar o Projeto Localmente

Siga os passos abaixo para configurar e rodar a aplicação em seu computador.

### **1. Pré-requisitos**

* Ter um ambiente de servidor local como o **XAMPP** instalado.
* Certifique-se de que os módulos **Apache** e **MySQL** estejam em execução no painel de controle do XAMPP.

### **2. Instalação**

1.  **Clone o repositório** (ou baixe o ZIP) para a pasta `htdocs` do seu XAMPP:
    ```bash
    git clone [URL_DO_SEU_REPOSITORIO] C:/xampp/htdocs/checklist-operacional
    ```

2.  **Crie o Banco de Dados:**
    * Abra seu navegador e acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
    * Crie um novo banco de dados chamado `checklist_db`.
    * Selecione o banco `checklist_db` e vá para a aba "SQL".

3.  **Crie a Tabela:**
    * Copie e execute o código SQL abaixo para criar a tabela `registros_checklist`:
    ```sql
    CREATE TABLE `registros_checklist` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `tipo` ENUM('abertura', 'fechamento') NOT NULL,
      `nome_lider` VARCHAR(255) NOT NULL,
      `nome_fiscal` VARCHAR(255) NOT NULL,
      `data_checklist` DATE NOT NULL,
      `coordenadas` VARCHAR(255) DEFAULT NULL,
      `luzes_internas` BOOLEAN DEFAULT 0,
      `luzes_externas` BOOLEAN DEFAULT 0,
      `equipamentos_ok` BOOLEAN DEFAULT 0,
      `sistemas_ok` BOOLEAN DEFAULT 0,
      `risco_incendio_ok` BOOLEAN DEFAULT 0,
      `passagem_servico_ok` BOOLEAN DEFAULT 0,
      `numero_lacres` TEXT DEFAULT NULL,
      `observacoes` TEXT DEFAULT NULL,
      `data_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ```

### **3. Acesso à Aplicação**

* Abra seu navegador e acesse a URL:
    **[http://localhost/checklist-operacional/](http://localhost/checklist-operacional/)**

A aplicação estará pronta para uso!

---

## 🔮 Próximos Passos e Melhorias

Este projeto serve como uma base sólida. Algumas futuras implementações podem incluir:

* **Sistema de Autenticação:** Implementar um sistema de login e senha para controlar o acesso.
* **Níveis de Permissão:** Criar perfis de usuário (ex: Administrador, Funcionário) com diferentes permissões.
* **Geração de Relatórios:** Funcionalidade para exportar registros em PDF ou CSV.
* **Dashboard com Gráficos:** Uma página inicial com estatísticas visuais (ex: total de checklists por mês).
* **Deploy:** Publicar a aplicação em um servidor web online.
