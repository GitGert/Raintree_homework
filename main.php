<?php

// TODO: move these values to the ENV, these should not be here.
$server_name = "localhost";
$username = "gert";
$password = "";

$db_name = "insurance_db";
$use_current_DB= "USE $db_name";

// Create connection
$conn = mysqli_connect($server_name, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . PHP_EOL);
}
echo "Connected successfully" . PHP_EOL;


// create db
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully" . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn) . PHP_EOL;
}


// use current db
$sql = "$use_current_DB";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully"  . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn)  . PHP_EOL;
}

//  add table patient
$sql = "CREATE TABLE IF NOT EXISTS patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL
);
";
if (mysqli_query($conn, $sql)) {
    echo "Patient added successfully to $db_name"  . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn)  . PHP_EOL;
}

//  add table insurance
$sql = " CREATE TABLE IF NOT EXISTS insurance (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(10) UNSIGNED NOT NULL,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(_id)
);
";
if (mysqli_query($conn, $sql)) {
    echo "insurance table added to $db_name"  . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn)  . PHP_EOL;
}

// //  add tables
// $sql = "";
// if (mysqli_query($conn, $sql)) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . mysqli_error($conn);
// }

//  add mock data to patien table
$sql = "INSERT INTO patient (pn, first, last, dob) VALUES ('12345678901', 'John', 'Doe', '1980-01-01');
INSERT INTO patient (pn, first, last, dob) VALUES ('23456789012', 'Jane', 'Smith', '1985-02-02');
INSERT INTO patient (pn, first, last, dob) VALUES ('34567890123', 'Alice', 'Johnson', '1990-03-03');
INSERT INTO patient (pn, first, last, dob) VALUES ('45678901234', 'Bob', 'Williams', '1995-04-04');
INSERT INTO patient (pn, first, last, dob) VALUES ('56789012345', 'Charlie', 'Brown', '2000-05-05');
";
if (mysqli_query($conn, $sql)) {
    echo "mock data added to patient table sucessfully"  . PHP_EOL;
} else {
    echo "Error creating database: " . mysqli_error($conn)  . PHP_EOL;
}



mysqli_close($conn);


?>


