<?php
$host = getenv('IP');
$username = 'lab7_user';
$password = 'd1A2-A3m4';
$dbname = 'world';

try{ 
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD']==='GET'){
      if (!(empty($_GET["country"])) &&  isset($_GET["country"])) {
        $country = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
        $result=getResult("SELECT * FROM countries WHERE name LIKE '%$country%';",$conn);
        displayResult($result);
      }
      elseif (empty($_GET["country"])){ 
      displayResult(getResult("SELECT * FROM countries;",$conn));
    }}
}catch(PDOException $e) { 
    echo "Connection failed: " . $e->getMessage(); 
}


function getResult($querysql,$pdo){
    $stmt = $pdo->query($querysql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};


function displayResult($list){
    if (empty($list)){
        ?> <p><?= "0 results";?> </p> <?php
    }else{
    ?>
    <h2><?="Results";?></h2>
    <table>
      <tr>
        <td><?= "Country Name";?></td>
        <td><?= "Continent";?></td>
        <td><?= "Independence Year";?></td>
        <td><?= "Head of State";?></td>
      </tr>
        <?php foreach ($list as $row):?>
        <tr>
          <td><?= $row["name"];?></td>
          <td><?= $row["continent"];?></td>
          <td><?= $row["independence_year"];?></td>
          <td><?= $row["head_of_state"];?></td>
        </tr>
        <?php endforeach; ?>
    </tablel><?php
}};
