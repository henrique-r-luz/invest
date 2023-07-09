

<p align="center">
  <img src="https://user-images.githubusercontent.com/12544898/174111505-79690883-5889-48f8-aba3-22e193daba76.png">
</p>
<h1 align="center"!>Sistema Invest </h1>
<p align="center">
<img src="http://img.shields.io/static/v1?label=STATUS&message=EM%20DESENVOLVIMENTO&color=GREEN&style=for-the-badge"/>
</p>
O Invest é um sistema de controle de investimentos pessoal que possibilita a centralização de todos os seus ativos em um só lugar. Ele permite o controle de aplicações de renda variável e fixa. A seguir é listado alguns dos recursos do sistema:

 - Cadastro de ativos.
 - Cadastro de Operações dos ativos(Venda e compra).
 - Cadastro de Investidores
 - Sincronização de preços do ativos.
 - Cadastro proventos para renda Variável
 - Importação de operações de renda variável das corretoras Clear e Avenue.
 - Atualização de ativos de renda fixa da Corretora NuInvest.
 - Atualização de CDB do banco inter.
 - Importação de proventos e rendimentos da B3. 
 - Gráficos Descritivos informativos. 
 - Auditoria 
 
 ## Arquitetura de Containers 
 A imagem abaixo revela a arquitetura de containers do sistema Invest.
 
![Diagrama invest](https://github.com/henrique-r-luz/invest/assets/12544898/fb6bf662-d6ca-42d5-8c17-8981637900de)

 
 Descrições dos containers:
   - <b>apache</b>: Servidor web, utilizando o sistema apache.
   - <b>app</b>: PHP 8 com os códigos do sistema
   - <b>db_invest</b>: Banco de dados do sistema com o Postgresql instalado
   - <b>db_teste</b>: Banco de dados para testes automatizados.
   
 ## Pré-requisito
   - Git
   - Docker
   - Docker-compose

## Tecnologias utilizadas

- ``PHP 8``
- ``Yii2``
- ``Python3``
- ``PostgresSql``
- ``JavaScript``

    
 ## Instalação
 Baixar o projeto no github.
 ~~~
 git clone https://github.com/henrique-r-luz/invest.git
 ~~~ 
 Após a conclusão do download entre na pasta invest e execute o comando abaixo.
 Esse processo pode levar alguns minutos porque o docker irá criar e configurar
 cada container. 
 ~~~
 sudo docker-compose up
 ~~~ 
 Com os contêineres ligados, acesse o app com o seguinte comando:
 ~~~
 docker exec -it invest_app_1 bash
 ~~~
 Execute o compose para instalar as dependências
 ~~~
 composer install
 ~~~
 Depois execute os migrates 
 ~~~
 php yii migrate
 ~~~
 Com os migrates executados os sistema está pronto para uso, acesse:
 ~~~
 http://localhost
 ~~~
 Aparecerá a tela de login
 ~~~
 login:admin
 senha:admin
 ~~~
 
 ![login](https://user-images.githubusercontent.com/12544898/174130185-cb875c32-7f8c-4ddd-974c-29a611f77ef5.png)
 
 Realizando o login o sistema já pode ser utilizado, segui a tela inicial do invest
 
 ![telaInicial](https://user-images.githubusercontent.com/12544898/174131132-31e9e679-23db-4a6b-a565-c83c432e4d56.png)

 O Sistema possui alguns testes automatizados, para executá-los acesse o container do app:

 ~~~
 docker exec -it invest_app_1 bash
 ~~~

 Dentro do terminal do app execute o seguinte comando:

 ~~~
./vendor/bin/codecept run
 ~~~
 
 O manual do usuário se encontra na wiki do projeto.
 
 ## Autor

 [<img src="https://user-images.githubusercontent.com/12544898/174133076-fc3467c3-3908-436f-af3d-2635e4312180.png" width=115><br><sub>Henrique Rodrigues Luz</sub>](https://github.com/henrique-r-luz) 

 
 
