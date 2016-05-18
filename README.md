# Ciclo de Amostras

### Plugin criado para a empresa [König Brasil](http://konigbrasil.com.br/) para realizar a gestão do promotores associados.

#### Plugins Requeridos

- [Advanced Custom Fields](http://advancedcustomfields.com/)
- [Advanced Custom Fields - Repeater](https://www.advancedcustomfields.com/add-ons/repeater-field/)
 
#### Informações Básicas

1. Primeiro faça o do plugin [Ciclo de Amostras](https://github.com/chrdesigner/ciclo-amostras/archive/master.zip).
2. Na área administrativa do seu WordPress realize o upload do plugin por (Plugins -> Adicionar Novo).
3. Depois de ativo ele automaticamente vai "Populate" o seu banco de dados com os Estados e Cidades do Brasil. **Se não aplicar a tabela Cidades é só desativar e ativar novamente o plugin :wink: **
4. Você terá que criar somente o cadastro básico do **Promotor** pela aba (Promotores -> Adicionar Novo).
5. O mais importante no registro do Promotor é o e-mail o mesmo não poderá ser alterado depois, por causa de segurança e também pela vinculação das Clínicas.
6. Após de cadastrar o Promotor ele receberá automaticamente um alerta de registro, mas por segurança você terá que enviar a senha para o mesmo.
7. Por fim todos o processo de gerenciamento será realizado via **front-end** "Área Restrita" aonde somente é aceito o e-mail como forma te autenticação assim evitando que outros Promotores tenham acesso as clínicas e relatórios.

#### Outras Informações

Somente o Administrador terá acesso ao **WP-ADMIN** se o promotor tentar acessar ele automaticamente será redirecionado para a Página Principal do site.