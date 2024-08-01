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
    private $insurance_records = [];

    public function __construct($patient_number) {
        $conn = connect_to_database();
        use_current_db($conn);
        $patient_values = get_patient_data($conn, $patient_number);

        $this -> _id = $patient_values["_id"];
        $this -> pn = $patient_values["pn"];
        $this -> first = $patient_values["first"];
        $this -> last = $patient_values["last"];
        $this -> dob = $patient_values["dob"];
        
        
        $patient_insurance_ids = get_insurance_ids($conn, $patient_number);

        for ($i = 0; $i < count($patient_insurance_ids); $i++ ){
            $temp_val = new Insurance($patient_insurance_ids[$i]);
            array_push( $this -> insurance_records, $temp_val);
        }
        mysqli_close($conn);
    }

    public function __tostring() {
        return "_id: " . $this -> _id .", pn: ". $this -> pn .", first: ". $this -> first .", last: ". $this -> last . ", dob: " . $this -> dob;
    }

    public function get_patient_name(){
        return $this -> first . " " . $this -> last;
    }
    
    public function get_patient_insurance_records(){
        return $this -> insurance_records;
    }

    public function get_id() {
        return $this -> _id;
    }
    
    public function get_patient_number() {
        return $this->pn;
    }

    public function show_patient_insurance_is_valid($input_date){
        for ($i = 0; $i < count($this -> insurance_records); $i++ ){
            $insurance_object = $this -> insurance_records[$i];
            $start_date = $insurance_object ->get_insurance_from_date();
            $end_date = $insurance_object->get_insurance_to_date();
            

            $format = "Y-m-d";
            $start_date  = \DateTime::createFromFormat($format, $start_date);
            $end_date  = \DateTime::createFromFormat($format, $end_date);

            $format = "d-m-y";
            $formatted_input_date  = \DateTime::createFromFormat($format, $input_date);

            $is_valid = "No";
            if ($formatted_input_date <= $end_date && $formatted_input_date >= $start_date){
                $is_valid = "Yes";
            }

            echo $this -> pn . ", ". $this -> get_patient_name() . ", " . $insurance_object -> get_insurance_name() . ", " . $is_valid . PHP_EOL;

        }
    }
}


class Insurance implements PatientRecord {
    private $_id ;
    private $patient_id;
    private $iname ;
    private $from_date ;
    private $to_date ;

    public function __construct($insurance_id) {

        $conn = connect_to_database();
        use_current_db($conn);
        $insurance_data = get_insurance_data($conn, $insurance_id);

        $this -> _id = $insurance_id;
        $this -> patient_id = $insurance_data["patient_id"];
        $this -> iname = $insurance_data["iname"];
        $this -> from_date = $insurance_data["from_date"];
        $this -> to_date = $insurance_data["to_date"];

        mysqli_close($conn);
    }

    public function __tostring() {
        return "_id: " . $this -> _id .", patient_id: ". $this -> patient_id .", insurance name: ". $this -> iname .", from_date: ". $this -> get_insurance_from_date() . ", to_date: " . $this -> to_date;
    }

    public function is_insurance_valid($date){
        $infinite = False;
        if (!$this -> to_date){
            $infinite = True;
        }
        
        $format = "Y-m-d";
        $start_date  = \DateTime::createFromFormat($format, $this -> from_date);
        $end_date  = \DateTime::createFromFormat($format, $this -> to_date);
        $format = "d-m-y";
        $new_date  = \DateTime::createFromFormat($format, $date);
        

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