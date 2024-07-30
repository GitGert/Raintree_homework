<?php 

interface PatientRecord {
    public function get_patient_id();
    public function get_patient_number();
}

class Patient implements PatientRecord {
    public $_id = "";
    public $pn = "";
    public $first = "";
    public $last = "";
    public $dob = "";
    public $insurace_records = [];

    public function __construct($patient_number) {
        // TODO: this constructor should qurey the db and fill all of the date using thes PATIENT NUMBER (pn)
        $this->set_values_from_db($patient_number);
    }

    private function set_values_from_db($pn){
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

        //TODO: change this query to the safer format, this is a unsafe DB query
        $sql = "SELECT * FROM patient where pn =$pn";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            echo  $row["dob"] . ", ".$row["last"] . ", ". $row["first"] . ", ".   PHP_EOL;
            $this -> _id = $row["_id"];
            $this -> pn = $row["pn"];
            $this -> first = $row["first"];
            $this -> last = $row["last"];
            $this -> dob = $row["dob"];
            }
        } else {
            echo "ERROR: no patient found with Patient Number: $pn\n";
        }

        //TODO: change this query to the safer format, this is a unsafe DB query
        $sql = "SELECT * FROM insurance where patient_id =$pn";

        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            $temp_array= [];
            array_push($temp_array,$row["_id"]);
            array_push($temp_array,$row["patient_id"]);
            array_push($temp_array,$row["iname"]);
            array_push($temp_array,$row["from_date"]);
            array_push($temp_array,$row["to_date"]);

            array_push($this -> insurace_records, $temp_array);
            }
        } else {
            echo "ERROR: no patient found with Patient Number: $pn\n";
        }

    }

    public function get_patient_name(){
        return $first . " " . $last;
    }

    public function get_patient_id() {
        return $_id;
    }
    
    public function get_patient_number() {
        return $pn;
    }
}

$temp_pn = "1";
$patient1 = new Patient($temp_pn);
echo $patient1 ->_id;
echo $patient1 ->first;
echo $patient1 ->last;
echo $patient1 ->dob;
echo "\n\n";
$tempARR = $patient1 -> insurace_records;
for ($i = 0; $i < count($tempARR) ; $i++) {
    echo "[ ";
    for ($j = 0; $j < count($tempARR[$i]) ; $j++) {
        echo $tempARR[$i][$j]. "  ";
        
    }
    echo "]\n";
}
?>