<?php 
define("ENV",parse_ini_file('.env') );
define("SERVER_NAME",ENV['DB_SERVER']);
define("USERNAME",ENV['DB_USERNAME']);
define("PASSWORD",ENV['DB_PASSWORD']);
define("DB_NAME", "insurance_db");


function connect_to_database(){
    $conn = mysqli_connect(SERVER_NAME, USERNAME, PASSWORD);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . PHP_EOL);
    }
    // echo "DB Connected successfully" . PHP_EOL;
    return $conn;
}

function use_current_db($conn){
    $sql = "USE " . DB_NAME;
    if (mysqli_query($conn, $sql)) {
        // echo "Query: $sql - SUCCESS" . PHP_EOL;
    } else {
        echo "Error with DB: " . mysqli_error($conn)  . PHP_EOL;
    }

}


function get_patient_data($conn, $pn){
    $patient_values = array();
    
    //TODO: change this query to the safer format, this is a unsafe DB query
    $sql = "SELECT * FROM patient where pn =$pn";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patient_values["_id"] = $row["_id"];
            $patient_values["pn"] = $row["pn"];
            $patient_values["first"] = $row["first"];
            $patient_values["last"] = $row["last"];
            $patient_values["dob"] = $row["dob"];
        }
    } else {
        echo "ERROR: no patient found with Patient Number: $pn\n";
    }
    
    return $patient_values;
}


function get_insurance_data($conn, $insurance_ID){
    $result_array = [];
    //TODO: change this query to the safer format, this is a unsafe DB query
    $sql = "SELECT _id, patient_id, iname, DATE_FORMAT(from_date, '%m-%d-%y') AS from_date, DATE_FORMAT(to_date, '%m-%d-%y') AS to_date FROM insurance where _id =$insurance_ID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $result_array["_id"] = $row["_id"];
            $result_array["patient_id"] = $row["patient_id"];
            $result_array["iname"] = $row["iname"];
            $result_array["from_date"] = $row["from_date"];
            $result_array["to_date"] = $row["to_date"];
        }
    } else {
        echo "ERROR: no insurance found with id: $insurance_ID\n";
        return;
    }

    return $result_array;
}


function get_insurance_IDs($conn, $patient_number){
    // $conn = connect_to_database();
    // use_current_db($conn);

    $list_of_insurance_IDs = [];

    $sql = "SELECT * FROM insurance where patient_id =$patient_number";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        array_push($list_of_insurance_IDs,$row["_id"]);
        }
    } else {
        echo "ERROR: no patient found with Patient Number: $patient_number\n";
        return;
    }

    return $list_of_insurance_IDs;

}

function get_all_patient_IDs(){
    $conn = connect_to_database();
    use_current_db($conn);

    $list_of_patient_IDs = [];

    $sql = "SELECT _id FROM patient";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        array_push($list_of_patient_IDs,$row["_id"]);
        }
    } else {
        echo "ERROR: no patients found\n";
        mysqli_close($conn);
        return;
    }
    mysqli_close($conn);
    return $list_of_patient_IDs;
}



// $stmt = $connection->prepare("INSERT INTO table (column) VALUES (?)");
// $stmt->bind_param("s", $variable); // "s" indicates the variable type is string
// $stmt->execute();


// function get_patient_data($conn, $pn){
//      //TODO: change this query to the safer format, this is a unsafe DB query
//         $sql = "SELECT * FROM patient where pn =$pn";

//         $result = $conn->query($sql);

//         if ($result->num_rows > 0) {
//             while($row = $result->fetch_assoc()) {
//             echo  $row["dob"] . ", ".$row["last"] . ", ". $row["first"] . ", ".   PHP_EOL;
//             $this -> _id = $row["_id"];
//             $this -> pn = $row["pn"];
//             $this -> first = $row["first"];
//             $this -> last = $row["last"];
//             $this -> dob = $row["dob"];
//             }
//         } else {
//             echo "ERROR: no patient found with Patient Number: $pn\n";
//         }

// }







?>