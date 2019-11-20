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
        if ($_GET['context']==="country"){
        $result=getResult("SELECT * FROM countries WHERE name LIKE '%$country%';",$conn);
        displayResultCountries($result);
        }else{
        $sql="SELECT c.name, c.district, c.population FROM cities c join countries cs on c.country_code = cs.code WHERE cs.name='$country'";
        $result=getResult($sql,$conn);  //need to fix
        displayResultCities($result);
        }
      }
      elseif (empty($_GET["country"])){ 
      displayResultCountries(getResult("SELECT * FROM countries;",$conn));
    }}
}catch(PDOException $e) { 
    echo "Connection failed: " . $e->getMessage(); 
}


function getResult($querysql,$pdo){
    $stmt = $pdo->query($querysql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};


function displayResultCountries($list){
    if (empty($list)){
        ?> <p><?= "0 results";?> </p> <?php
    }else{
    ?>
    <table>
      <tr>
        <th><?= "Country Name";?></th>
        <th><?= "Continent";?></th>
        <th><?= "Independence Year";?></th>
        <th><?= "Head of State";?></th>
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

function displayResultCities($list){
  ?>
    <table>
      <tr>
        <th><?= "City Name";?></th>
        <th><?= "District";?></th>
        <th><?= "Population";?></th>
      </tr>
        <?php foreach ($list as $row):?>
        <tr>
          <td><?= $row["name"];?></td>
          <td><?= $row["district"];?></td>
          <td><?= $row["population"];?></td>
        </tr>
        <?php endforeach; ?>
    </tablel><?php
};







