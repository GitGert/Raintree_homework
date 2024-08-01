<?php
define("ENV", parse_ini_file(__DIR__ . '/../.env'));
define("SERVER_NAME",ENV['DB_SERVER']);
define("USERNAME",ENV['DB_USERNAME']);
define("PASSWORD",ENV['DB_PASSWORD']);
define("DB_NAME", "insurance_db");


function connect_to_database(){
    $conn = mysqli_connect(SERVER_NAME, USERNAME, PASSWORD);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . PHP_EOL);
    }
    return $conn;
}

function use_current_db($conn){
    $sql = "USE " . DB_NAME;
    if (mysqli_query($conn, $sql)) {
    } else {
        echo "Error with DB: " . mysqli_error($conn)  . PHP_EOL;
    }
}


function get_patient_data($conn, $pn){
    $patient_values = array();
    
    $sql = "SELECT _id, LPAD(CAST(pn AS CHAR), 11, '0') AS formatted_pn, first, last, dob FROM patient where pn =$pn ORDER BY pn";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $patient_values["_id"] = $row["_id"];
            $patient_values["pn"] = $row["formatted_pn"];
            $patient_values["first"] = $row["first"];
            $patient_values["last"] = $row["last"];
            $patient_values["dob"] = $row["dob"];

        }
    } else {
        echo "ERROR: no patient found with Patient Number: $pn" . PHP_EOL;
    }
    
    return $patient_values;
}


function get_insurance_data($conn, $insurance_ID){
    $result_array = [];
    $sql = "SELECT _id, patient_id, iname, from_date, to_date FROM insurance where _id =$insurance_ID";
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
        echo "ERROR: no insurance found with id: $insurance_ID". PHP_EOL;
        return;
    }

    return $result_array;
}


function get_insurance_ids($conn, $patient_number){
    $list_of_insurance_ids = [];

    $sql = "SELECT * FROM insurance where patient_id =$patient_number";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        array_push($list_of_insurance_ids,$row["_id"]);
        }
    } else {
        echo "ERROR: no patient found with Patient Number: $patient_number" .  PHP_EOL;
        return;
    }
    return $list_of_insurance_ids;
}

function get_all_patient_ids(){
    $conn = connect_to_database();
    use_current_db($conn);

    $list_of_patient_ids = [];

    $sql = "SELECT _id FROM patient";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        array_push($list_of_patient_ids,$row["_id"]);
        }
    } else {
        echo "ERROR: no patients found". PHP_EOL;
        mysqli_close($conn);
        return;
    }
    mysqli_close($conn);
    return $list_of_patient_ids;
}
