# Descrição da atividade

&emsp;Esta atividade nos ajuda a entender como funciona a conexão com o banco de dados MariaDB no RDS da AWS a partir de uma instância EC2. Todo o processo de configuração foi feito usando o tutorial disponível no link: [AWS User Guide](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/CHAP_Tutorials.WebServerDB.LaunchEC2.html).

## Descrição básica do processo

&emsp;O primeiro passo foi criar uma instância EC2 com algum sistema operacional, no meu caso escolhi o Ubuntu Server 24.04 LTS (No tutorial estão utilizando o Amazon Linux). Durante o processo de criação da instância, foi preciso liberar a porta 22 (SSH) e a porta 80 (HTTP) no grupo de segurança para permitir o acesso remoto e o tráfego web.

&emsp;Após a criação da instância EC2, foi a vez de criar o banco de dados MariaDB no RDS. A AWS facilita o processo de segurança ao permitir que você selecione a opção "Conectar-se a uma instância EC2". Isso automaticamente configura o grupo de segurança do banco de dados para permitir conexões da instância EC2 criada anteriormente. Aqui, idealmente, você deve anotar o endpoint, nome do banco de dados, nome de usuário e senha, pois serão necessários para a conexão.

&emsp;Após seguir o tutorial da AWS, consegui conectar a instância EC2 ao banco de dados MariaDB no RDS. Para criar a nova página web, utilizei o mesmo padrão fornecido pela AWS, que segue a seguinte ordem:

1. Conecta ao banco de dados.
2. Verifica se a tabela existe; se não, cria a tabela.
3. Realiza a leitura dos dados da tabela.
4. Declara a função para inserir dados na tabela.

[Código completo](cc.php)

Link do vídeo contendo a explicação do processo: [Google Drive](https://drive.google.com/file/d/1vKVxwiOnA9BozITs2aEsRbcJ07rHjA3E/view?usp=sharing)
