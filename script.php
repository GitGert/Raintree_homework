<?php

include("database.php");

$conn = connect_to_database();
use_current_db($conn);


echo   PHP_EOL . "solution to: 3.2 A):". PHP_EOL .PHP_EOL ;

$sql = "SELECT  LPAD(CAST(p.pn AS CHAR), 11, '0') AS formatted_pn,  p.last,  p.first, p._id, DATE_FORMAT(i.from_date, '%m-%d-%y') AS from_date, DATE_FORMAT(i.to_date, '%m-%d-%y') AS to_date  FROM patient as p
INNER JOIN insurance as i on i.patient_id = p._id
ORDER BY to_date, last";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo  $row["formatted_pn"] . ", ".$row["last"] . ", ". $row["first"] . ", ".  $row["from_date"] . "," .  $row["to_date"] . PHP_EOL;
    }
  } else {
    echo "0 results";
  }


echo PHP_EOL . PHP_EOL . "solution to: 3.2 B):" . PHP_EOL . PHP_EOL;



$sql = "SELECT  p.last,  p.first FROM patient as p;";
$result = $conn->query($sql);

$letter_map = [];
$total = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        $firstname_characters = str_split(strtoupper($row["first"])) ;
        $lastname_characters = str_split(strtoupper($row["last"]));
        
        foreach($firstname_characters as $char){
            if (array_key_exists($char, $letter_map)){
                $letter_map[$char] ++;
            }else{
                $letter_map[$char] = 1;
            };
            $total++;
        };

        foreach($lastname_characters as $char){
            if (array_key_exists($char, $letter_map)){
                $letter_map[$char] ++;
            }else{
                $letter_map[$char] = 1;
            };
            $total++;
        };

    }
  } else {
    echo "0 results";
  }

  ksort($letter_map);

  foreach ($letter_map as $key => $value) {
    $precentage = round($value/$total *100, 2);
    echo "$key\t$value\t$precentage" . "%" . PHP_EOL;
}

mysqli_close($conn);

?>