<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Cadastro de Alunos de Ciência da Computação</h1>
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Erro na conexão: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  VerifyAlunosTable($connection, DB_DATABASE);

  $nome      = htmlentities($_POST['NOME']);
  $idade     = htmlentities($_POST['IDADE']);
  $media     = htmlentities($_POST['MEDIA']);
  $approved  = isset($_POST['APPROVED']) ? 1 : 0;

  if (strlen($nome) && strlen($idade) && strlen($media)) {
    AddAluno($connection, $nome, $idade, $media, $approved);
  }
?>

<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Nome</td>
      <td><input type="text" name="NOME" maxlength="100" size="30" /></td>
    </tr>
    <tr>
      <td>Idade</td>
      <td><input type="number" name="IDADE" min="0" /></td>
    </tr>
    <tr>
      <td>Média</td>
      <td><input type="number" step="0.01" name="MEDIA" /></td>
    </tr>
    <tr>
      <td>Aprovado?</td>
      <td><input type="checkbox" name="APPROVED" value="1" /> Sim</td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Adicionar Aluno" /></td>
    </tr>
  </table>
</form>

<h2>Lista de Alunos</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Idade</th>
    <th>Média</th>
    <th>Aprovado</th>
    <th>Criado em</th>
  </tr>

<?php
$result = mysqli_query($connection, "SELECT * FROM AlunosCC");

while($query_data = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>", $query_data['ID'], "</td>",
       "<td>", $query_data['NOME'], "</td>",
       "<td>", $query_data['IDADE'], "</td>",
       "<td>", $query_data['MEDIA'], "</td>",
       "<td>", ($query_data['APPROVED'] ? 'Sim' : 'Não'), "</td>",
       "<td>", $query_data['CREATED_AT'], "</td>";
  echo "</tr>";
}
?>
</table>

<?php
  mysqli_free_result($result);
  mysqli_close($connection);
?>

</body>
</html>

<?php
function AddAluno($connection, $nome, $idade, $media, $approved) {
   $n = mysqli_real_escape_string($connection, $nome);
   $i = mysqli_real_escape_string($connection, $idade);
   $m = mysqli_real_escape_string($connection, $media);
   $a = mysqli_real_escape_string($connection, $approved);

   $query = "INSERT INTO AlunosCC (NOME, IDADE, MEDIA, APPROVED, CREATED_AT) 
             VALUES ('$n', '$i', '$m', '$a', NOW());";

   if(!mysqli_query($connection, $query)) echo("<p>Erro ao adicionar aluno.</p>");
}

function VerifyAlunosTable($connection, $dbName) {
  if(!TableExists("AlunosCC", $connection, $dbName))
  {
     $query = "CREATE TABLE AlunosCC (
         ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NOME VARCHAR(100) NOT NULL,
         IDADE INT NOT NULL,
         MEDIA DECIMAL(5,2) NOT NULL,
         APPROVED TINYINT(1) NOT NULL DEFAULT 0,
         CREATED_AT DATETIME NOT NULL
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Erro criando tabela AlunosCC.</p>");
  }
}

function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES 
       WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  return (mysqli_num_rows($checktable) > 0);
}
?>
