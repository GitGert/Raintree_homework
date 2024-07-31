<?php 
include "ex-3.php";
// include "database.php";

function test_patient_class(){
    $patient_id_array = get_all_patient_IDs();

    for ($i = 0; $i < count($patient_id_array); $i++){
        $patient_id = $patient_id_array[$i];
        $patient = new Patient($patient_id);
        // 000000001, Doe, John, Medicaid, No 
        // echo $patient -> _id . ", " . $patient -> first . ", " . $patient -> last . ", ", $patient ->  ;
        // public function __construct($patient_number) {
    }
    //TODO: FIX DB QUERIES SO THE NUMBER WOULD LOOK LIKE: 00000000001
    //TODO: CHECK ON ALL THE OTHER TODOS AND MAKE SURE EVERYTHING IS DONE.
    //TODO: PATCH TOGETHER THE FINAL TEST LOOP SO IT WOULD SHOW ALL THE VALUES AS REQIRED
}


test_patient_class()

?>