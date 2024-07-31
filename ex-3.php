<?php

include "database.php";


interface PatientRecord {
    public function get_id();
    public function get_patient_number();
}

class Patient implements PatientRecord {
    private $_id ;
    private $pn;
    private $first ;
    private $last ;
    private $dob ;
    //TODO, perhaps convert this into a object/class like thing?s
    private $insurace_records = [];

    public function __construct($patient_number) {
        // TODO: this constructor should qurey the db and fill all of the date using thes PATIENT NUMBER (pn)
        $conn = connect_to_database();
        use_current_db($conn);
        $patinet_values = get_patient_data($conn, $patient_number);

        $this -> _id = $patinet_values["_id"];
        $this -> pn = $patinet_values["pn"];
        $this -> first = $patinet_values["first"];
        $this -> last = $patinet_values["last"];
        $this -> dob = $patinet_values["dob"];
        
        
        $patient_insurance_IDs = get_insurance_IDs($conn, $patient_number);

        for ($i = 0; $i < count($patient_insurance_IDs); $i++ ){
            $temp_val = new Insurance($patient_insurance_IDs[$i]);
            array_push( $this -> insurace_records, $temp_val);
        }

        // $this ->insurace_records = get_patients_insurance_data($conn, $patient_number);
        mysqli_close($conn);
    }


    public function get_patient_name(){
        return $this -> first . " " . $this -> last;
    }
    
    public function get_patient_insurance_records(){
        return $this -> insurace_records;
    }


    public function get_id() {
        return $this -> _id;
    }
    
    public function get_patient_number() {
        return $this->pn;
    }

    public function show_patient_insurance_isValid($input_date){
        for ($i = 0; $i < count($this -> insurace_records); $i++ ){
            $insurance_object = $this -> insurace_records[$i];
            $start_date = $insurance_object ->get_insurance_from_date();
            $end_date = $insurance_object->get_insurance_to_date();
            

            $format = "d-m-y";
            $start_date  = \DateTime::createFromFormat($format, $start_date);
            $end_date  = \DateTime::createFromFormat($format, $end_date);
            $new_date  = \DateTime::createFromFormat($format, $input_date);

            $isValid = "No";
            if ($new_date < $end_date){
                $isValid = "Yes";
            }

            echo $this -> pn . ", ". $this -> get_patient_name() . ", " . $insurance_object -> get_insurance_name() . ", " . $isValid . PHP_EOL;

        }
    }
}


class Insurance implements PatientRecord {
    private $_id ;
    private $patient_id;
    private $iname ;
    private $from_date ;
    private $to_date ;

    // public function __toString(){
    //     return "\n\nInsurance class currently only has its own id: " . $this -> insurance_id;
    // }

    public function __construct($insurance_id) {
        // make db query with the given insurance_id...?

        $conn = connect_to_database();
        use_current_db($conn);
        $insurace_data = get_insurance_data($conn, $insurance_id);

        $this -> _id = $insurance_id;
        $this -> patient_id = $insurace_data["patient_id"];
        $this -> iname = $insurace_data["iname"];
        $this -> from_date = $insurace_data["from_date"];
        $this -> to_date = $insurace_data["to_date"];

        mysqli_close($conn);
    }
    // public function get_id();
    // public function get_patient_number();

    public function is_insurance_valid($date){
        $infinite = False;
        if (!$this -> to_date){
            $infinite = True;
        }
        $format = "d-m-y";
        
        $start_date  = \DateTime::createFromFormat($format, $this -> from_date);
        $end_date  = \DateTime::createFromFormat($format, $this -> to_date);
        $new_date  = \DateTime::createFromFormat($format, $date);
        
        echo $start_date -> Format("d-m-y\n");
        echo $end_date -> Format("d-m-y\n");
        echo $new_date -> Format("d-m-y\n");

        // echo $new_date >= $start_date
        // echo $new_date = $start_date

        if ($new_date >= $start_date && $new_date <=$end_date || $infinite == True && $new_date >= $start_date){
            return True;
        }
        return False;
    }

    public function get_id() {
        return $this -> _id;
    }
    public function get_patient_number() {
        return $this->patient_id;
    }
    public function get_insurance_name() {
        return $this->iname;
    }
    public function get_insurance_from_date() {
        return $this->from_date;
    }
    public function get_insurance_to_date() {
        return $this->to_date;
    }
}

// $temp_pn = "1";
// $patient1 = new Patient($temp_pn);
// echo $patient1->get_patient_number() . PHP_EOL;
// $patient1->show_patient_insurance_isValid("03-10-20");
// echo $patient1->get_patient_insurance_records()[1];
// $insurace_1 = new Insurance("1");
// $bool_val=  $insurace_1 -> is_insurance_valid("06-01-23");
// echo $bool_val ? 'true' : 'false';
// echo "\n"

?>