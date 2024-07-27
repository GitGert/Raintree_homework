<!-- 3.2 The script has to have the following functionality:

a) Display the following columns for each patient to the console:

Patient number (pn),
 Patient last name (last),
 Patient first name (first),
 Insurance name,
 Insurance - from date (from_date) in US short date format (MM-DD-YY) and Insurance to date (to_date) in US
short date format (MM-DD-YY)

, ordered by Insurance from date starting from earliest and then
patient last name. -->

<?php 
$server_name = "localhost";
$username = "gert";
$password = "";

$db_name = "insurance_db";
$use_current_DB= "USE $db_name";


$conn = mysqli_connect($server_name, $username, $password);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . PHP_EOL);
}
echo "Connected successfully" . PHP_EOL;


// use current db
$sql = "$use_current_DB";
if (mysqli_query($conn, $sql)) {
    echo "USE statment success"  . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn)  . PHP_EOL;
}

// SELECT LPAD(CAST(padded_value AS CHAR), 10, '0') AS formatted_value FROM example_table;

// 3.1 B)


// $sql = "SELECT _id, LPAD(CAST(pn AS CHAR), 10, '0') AS formatted_pn, first, last, dob FROM patient
$sql = "SELECT  LPAD(CAST(p.pn AS CHAR), 10, '0') AS formatted_pn,  p.last,  p.first, p._id, i.from_date, i.to_date  FROM patient as p
INNER JOIN insurance as i on i.patient_id = p._id

ORDER BY to_date, last";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // _id | pn          | first   | last     | dob        |
    //   echo "id: " . $row["_id"]. " - Patient number: " . $row["formatted_pn"]. " " . $row["first"]. $row["last"] . " " .  $row["dob"] . PHP_EOL;
      echo  $row["formatted_pn"] . ", ".$row["last"] . ", ". $row["first"] . ", ".  $row["from_date"] . "," .  $row["to_date"] . PHP_EOL;
    }
  } else {
    echo "0 results";
  }


// 3.2 B)
//  figure out how many letters in first an last names:

$sql = "SELECT  p.last,  p.first FROM patient as p;";
$result = $conn->query($sql);

$letter_map = [];
$total = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo  $row["first"] . $row["last"] . PHP_EOL;
        
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

// TODO: sort alphabetically
  foreach ($letter_map as $key => $value) {
    $precentage = round($value/$total *100, 2);
    echo "$key\t$value\t$precentage" . "%\n";

}
echo $total . "\n";

mysqli_close($conn);

?>