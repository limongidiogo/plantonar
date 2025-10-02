Documentação Oficial: Plantonar v1.0
Versão: 1.0
Data: 02 de Outubro de 2025
Autor Principal: Diogo Reis (com assistência de Manus)
Tecnologias: Laravel 12, PHP 8.3, SQLite, Tailwind CSS, Vite
1. Visão Geral do Projeto
O Plantonar v1.0 é um MVP (Minimum Viable Product) de uma plataforma web que conecta Médicos a Hospitais para o preenchimento de vagas de plantão. O sistema possui dois fluxos de usuário distintos e um ciclo de vida completo para uma vaga de plantão, desde sua criação até o preenchimento.
2. Estrutura de Arquivos e Lógica Principal
A seguir, um guia das partes mais importantes do sistema e onde encontrá-las.
2.1. Autenticação e Perfis de Usuário
O sistema diferencia dois tipos de usuário: medico e hospital.
Models:
app/Models/User.php: O model de usuário padrão do Laravel. Contém os dados de login (nome, e-mail, senha). Possui a relação hasOne(Profile::class).
app/Models/Profile.php: O model customizado que armazena os dados específicos de cada tipo de usuário (CRM, Especialidade, CNPJ, etc.). É o "coração" da diferenciação de perfis. Possui a relação belongsTo(User::class).
Fluxo de Registro:
O usuário acessa /register/select para escolher seu tipo.
A rota aponta para RegisteredUserController@selectUserType, que renderiza a view auth.register-select.
Ao clicar, o usuário é direcionado para /register?type=medico ou /register?type=hospital.
O formulário auth.register.blade.php usa JavaScript (Alpine.js) para exibir os campos condicionais (CRM/CNPJ) com base no parâmetro type da URL.
O RegisteredUserController@store valida os dados base e os dados específicos e cria o User e o Profile associado dentro de uma transação de banco de dados para garantir consistência.
2.2. O Ciclo de Vida de um Plantão
Esta é a funcionalidade central da plataforma.
Estrutura no Banco de Dados:
Tabela plantoes: Armazena todas as informações de uma vaga (especialidade, data, valor, etc.). Crucialmente, possui a coluna profile_id (chave estrangeira para o hospital que criou a vaga) e approved_profile_id (chave estrangeira para o médico que foi aprovado).
Tabela plantao_profile (Tabela Pivot): Tabela de ligação para a relação "Muitos para Muitos" entre plantoes e profiles. Armazena todas as candidaturas. Cada linha significa "o médico X se candidatou à vaga Y".
Models Envolvidos:
app/Models/Plantao.php: Representa uma vaga de plantão.
protected $table = 'plantoes'; (Importante para corrigir a convenção de nomenclatura do Laravel).
Relações: belongsTo(Profile::class) para saber qual hospital publicou; belongsToMany(Profile::class, 'plantao_profile') para acessar todos os médicos candidatos.
app/Models/Profile.php:
Relações: hasMany(Plantao::class) para um hospital ver todos os plantões que publicou; belongsToMany(Plantao::class, 'plantao_profile') para um médico ver todas as suas candidaturas.
Controllers e Rotas:
app/Http/Controllers/PlantaoController.php: Orquestra todas as ações relacionadas a plantões.
index(): Lista os plantões disponíveis para os médicos. (View: plantoes.index)
create(): Exibe o formulário para o hospital criar uma nova vaga. (View: plantoes.create)
store(): Valida e salva o novo plantão no banco de dados.
apply(): Registra a candidatura de um médico a um plantão, criando uma entrada na tabela pivot plantao_profile.
approve(): Ação mais complexa. Define o approved_profile_id no plantão, muda o status da vaga para "Preenchido" e dispara a notificação para o médico aprovado.
app/Http/Controllers/ProfileController.php:
myPlantoes(): Permite que um hospital veja e gerencie os plantões que publicou. (View: profile.my-plantoes)
showCandidates(): Mostra a lista de médicos que se candidataram a um plantão específico. (View: profile.show-candidates)
myCandidacies(): Permite que um médico veja o status de todas as vagas para as quais se candidatou. (View: profile.candidacies)
2.3. Notificações
O sistema notifica o médico quando ele é aprovado para uma vaga.
Estrutura:
app/Notifications/MedicoAprovadoNotification.php: Define o conteúdo da notificação (mensagem, URL) e especifica que ela deve ser salva no banco de dados (via('database')).
app/Models/User.php: Utiliza o trait Notifiable, que adiciona toda a funcionalidade de notificações ao model.
Tabela notifications: Tabela padrão do Laravel que armazena todas as notificações geradas.
Disparo: A notificação é disparada dentro do método approve() no PlantaoController.php usando a linha $medicoAprovado->user->notify(new MedicoAprovadoNotification($plantao));.
2.4. Edição de Perfil
Funcionalidade final da v1.0, permitindo aos usuários editar seus dados.
Controller: app/Http/Controllers/ProfileController.php
edit(): Busca os dados do User e do Profile e os envia para a view de edição.
update(): Valida e salva as alterações tanto na tabela users quanto na tabela profiles.
View: resources/views/profile/partials/update-profile-information-form.blade.php
Contém a lógica @if para exibir os campos corretos (CRM/CNPJ) com base no user_type do perfil do usuário logado.
3. Como Rodar o Projeto Localmente
Para executar o ambiente de desenvolvimento do Plantonar, siga estes passos:
Abra dois terminais na pasta raiz do projeto (/plantonar).
Terminal 1 (Servidor PHP): Execute o comando:
Bash
php artisan serve
Isso iniciará o servidor principal, geralmente acessível em http://127.0.0.1:8000.
Terminal 2 (Compilador de Assets ): Execute o comando:
Bash
npm run dev
Isso iniciará o Vite, que compila o CSS e o JavaScript em tempo real.
Acesse http://127.0.0.1:8000 no seu navegador.
4. Comandos Úteis do Artisan
Zerar e Repovoar o Banco de Dados: Para um teste limpo.
Bash
php artisan migrate:fresh --seed
Interagir com o Projeto (Tinker ): Para testar lógicas e consultar dados.
Bash
php artisan tinker
Esta documentação é o seu mapa. Com ela, você pode navegar pelo código com confiança, entender as decisões que tomamos e ter uma base sólida para qualquer manutenção ou nova funcionalidade que queira implementar.