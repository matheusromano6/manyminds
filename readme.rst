# Documentação do Projeto Manyminds

## Introdução
O projeto Manyminds é um sistema desenvolvido em PHP utilizando o framework CodeIgniter. O sistema gerencia colaboradores e seus respectivos endereços, além de manter um histórico de logs para auditoria. Há também uma API para listagem de colaboradores, protegida por autenticação via token.

---

## Tecnologias Utilizadas
- **PHP 7.x**
- **CodeIgniter 3.x**
- **MySQL**
- **HTML5/CSS3**
- **JavaScript (jQuery)**
- **Bootstrap 4.6**
- **Postman (para testes da API)**

---

## Funcionalidades
- CRUD de Colaboradores
- Gestão de Endereços com Endereço Principal
- Listagem de Colaboradores com Filtros e Paginação
- Controle de Acesso e Autenticação de Usuários
- Geração de Tokens para Consumo da API
- Histórico de Logs de Ações no Sistema
- API para Listagem de Colaboradores em JSON

---

## Arquitetura do Projeto
- **MVC (Model-View-Controller)**: Estrutura utilizada no CodeIgniter.
- **Controllers**: `Colaboradores`, `Login`, `Dashboard`, `Logs`, `API`
- **Models**: `ColaboradoresModel`, `UserModel`, `LogsModel`
- **Views**: Formulários de cadastro/edição, listagem de colaboradores, logs, telas de login e dashboard.
- **Assets**: Imagens e arquivos CSS/JS externos.

---

## Banco de Dados
O banco de dados MySQL foi estruturado com as seguintes tabelas principais:
- **usuarios_colaboradores**: Dados pessoais e profissionais dos colaboradores.
- **enderecos_colaboradores**: Endereços vinculados aos colaboradores.
- **users**: Gerenciamento de usuários do sistema com token de acesso.
- **sistema_logs**: Registro de ações realizadas no sistema para auditoria.

### Relacionamentos e Cardinalidades
- **1 Colaborador** → **N Endereços** (Um colaborador pode ter múltiplos endereços, sendo apenas um o principal)
- **1 Usuário** → **N Logs** (Um usuário pode gerar múltiplos registros de log)

### Diagrama ER (Entidade-Relacionamento)
![Diagrama ER](er_diagram.png)

### Diagrama UML dos Models
![Diagrama UML](uml_diagram.png)

---

## API de Colaboradores
A API permite listar colaboradores em formato JSON, protegida por token de autenticação.
### Endpoint
```
GET /api/colaboradores
```
### Header de Autenticação
```
Authorization: <api_token>
```
### Exemplo de Retorno
```json
[
  {
    "id": 1,
    "nome": "JOÃO DA SILVA",
    "email": "joao@example.com",
    "telefone": "(11)91234-5678",
    "cargo": "Desenvolvedor"
  }
]
```

---

## Regras de Negócio
- **Endereço Principal**: Um colaborador pode ter apenas um endereço principal.
- **Status de Colaborador**: `active` (ativo) ou `inactive` (inativo).
- **CPF**: Validado para quantidade de caracteres e formato correto.
- **Data de Nascimento**: Permitido apenas de 1925 em diante.
- **Data de Admissão**: Permitido apenas de 1925 em diante.
- **Telefone**: Formato com máscara (XX)XXXXX-XXXX.
- **Salário**: Exibido como valor monetário.

---

## Como Instalar e Executar
1. Clone o repositório:
```
git clone https://github.com/seuusuario/projetomanyminds.git
```
2. Configure o banco de dados em `application/config/database.php`
3. Importe o arquivo SQL disponível na pasta `database`
4. Configure o `base_url` em `application/config/config.php`
5. Acesse o projeto via navegador em `http://localhost/projetomanyminds`

---

## Testando a API com Postman
1. Abra o Postman e crie uma nova requisição.
2. Selecione o método `GET` e use a URL: `http://localhost/projetomanyminds/api/colaboradores`
3. No cabeçalho, adicione:
```
Authorization: <api_token>
```
4. Clique em `Send` para visualizar o retorno da API.

---

## Considerações Finais
O projeto Manyminds foi desenvolvido seguindo as melhores práticas do CodeIgniter e com foco em Clean Code. É altamente escalável e permite fácil manutenção e expansão de funcionalidades.

---

## Autor
- **Nome**: Desenvolvedor Manyminds
- **GitHub**: [github.com/seuusuario](https://github.com/seuusuario)


---

## Licença
Este projeto é licenciado sob a MIT License - consulte o arquivo `LICENSE.md` para detalhes.

