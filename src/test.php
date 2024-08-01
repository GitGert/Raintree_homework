<?php 
include "task-3.php";

function test_task3_classes(){
    $patient_id_array = get_all_patient_IDs();

    for ($i = 0; $i < count($patient_id_array); $i++){
        $patient_id = $patient_id_array[$i];
        $patient = new Patient($patient_id);

        $insurance_list = $patient->get_patient_insurance_records();

        for ($j = 0; $j < count($insurance_list); $j++){
            $insurance_object = $insurance_list[$j];
            
            $is_valid = "No";
            if ($insurance_object -> is_insurance_valid(date("d-m-y"))){
                $is_valid = "Yes";
            };
            
            $final_output = $patient -> get_patient_number() .", ". $patient -> get_patient_name() . ", " . $insurance_object -> get_insurance_name() . ", ". $is_valid . PHP_EOL;

            echo $final_output;

        }
    }
}

function test_patient(){
    $test_pn = "1";
    $patient1 = new Patient($test_pn);

    echo $patient1 . PHP_EOL;
    #output should be:
    // _id: 1, pn: 00000000001, first: John, last: Doe, dob: 1980-01-01

    $patient1 -> show_patient_insurance_is_valid("01-05-24");
    # output should be:
    // 00000000001, John Doe, Policy A, No
    // 00000000001, John Doe, Policy B, Yes

    echo $patient1 -> get_patient_name() . PHP_EOL;
    # output should be:
    // John Doe

    $insurance_records = $patient1 -> get_patient_insurance_records();
    foreach ($insurance_records as $record) {
        echo $record . "\n";
    }
    # output should be:
    // _id: 1, patient_id: 1, insurance name: Policy A, from_date: 2020-06-01, to_date: 2023-06-01
    // _id: 2, patient_id: 1, insurance name: Policy B, from_date: 2021-06-01, to_date: 2024-06-01
}

function test_insurance(){
    $test_insurance_id = "1";
    $insurance1 = new Insurance($test_insurance_id);

    echo $insurance1 . PHP_EOL;
    #output should be:
    // _id: 1, patient_id: 1, insurance name: Policy A, from_date: 2020-06-01, to_date: 2023-06-01

    echo $insurance1 -> is_insurance_valid("01-01-22") ? "true" .PHP_EOL: "false" .PHP_EOL;
    # output should be:
    // true

    echo $insurance1 -> get_insurance_name() . PHP_EOL;
    # output should be:
    // Policy A

    echo $insurance1 -> get_insurance_from_date() ." to " . $insurance1 -> get_insurance_to_date() . PHP_EOL;
    # output should be:
    // 2020-06-01 to 2023-06-01
}


test_task3_classes();

// test_patient();
// test_insurance();
