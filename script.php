<?php
$env = parse_ini_file('.env');

$server_name = $env['DB_SERVER'];
$username = $env['DB_USERNAME'];
$password = $env['DB_PASSWORD'];

$DB_NAME = "insurance_db";
$use_current_DB= "USE $DB_NAME";


$conn = mysqli_connect($server_name, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . PHP_EOL);
}
echo "DB Connected successfully" . PHP_EOL;


$sql = "$use_current_DB";
if (mysqli_query($conn, $sql)) {
} else {
    echo "Error with DB: " . mysqli_error($conn)  . PHP_EOL;
}


echo "\n" . "solution to: 3.2 A):\n\n";

$sql = "SELECT  LPAD(CAST(p.pn AS CHAR), 10, '0') AS formatted_pn,  p.last,  p.first, p._id, i.from_date, i.to_date  FROM patient as p
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


echo "\n\n" . "solution to: 3.2 B):\n\n";

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
    echo "$key\t$value\t$precentage" . "%\n";
}

mysqli_close($conn);

?>