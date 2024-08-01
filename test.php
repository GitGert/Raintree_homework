<?php 
include "ex-3.php";


function test_patient_class(){
    $patient_id_array = get_all_patient_IDs();

    for ($i = 0; $i < count($patient_id_array); $i++){
        $patient_id = $patient_id_array[$i];
        $patient = new Patient($patient_id);

        $insurace_list = $patient->get_patient_insurance_records();

        for ($j = 0; $j < count($insurace_list); $j++){
            $insurance_object = $insurace_list[$j];
            
            $isValid = "No";
            if ($insurance_object -> is_insurance_valid(date("d-m-y"))){
                $isValid = "Yes";
            };
            
            $final_output = $patient -> get_patient_number() .", ". $patient -> get_patient_name() . ", " . $insurance_object -> get_insurance_name() . ", ". $isValid . PHP_EOL;

            echo $final_output;

        }
    }
    //TODO: FIX DB QUERIES SO THE NUMBER WOULD LOOK LIKE: 00000000001 :DONE
    //TODO: PATCH TOGETHER THE FINAL TEST LOOP SO IT WOULD SHOW ALL THE VALUES AS REQIRED :DONE
    //TODO: CHECK ON ALL THE OTHER TODOS AND MAKE SURE EVERYTHING IS DONE.
    //TODO: ADD TO README
}


test_patient_class()

?>