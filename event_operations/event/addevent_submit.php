<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('check_connection.php');
if(isset($_POST)){
    submit_event($_POST);
}


function submit_event($data) {
    if (validate_data($data)) {
        $conn = check_db();
        $query = 'INSERT INTO event (TITLE, START_DATE, END_DATE,  OCCURENCE_1, OCCURENCE_2) VALUES ("' . $data['event_title'] . '", "' . $data['start_date'] . '", "' . $data['end_date'] . '", "' . $data['occurence_1'] . '", "' . $data['occurence_2'] . '")';
        mysqli_query($conn, $query);
        mysqli_close($conn);
        header('Location:listevent.php');
    }
}

function validate_data($data) {
    // print_r($data);
    $error = [];
    $is_error = 0;
    if (empty($data['event_title'])) {
        $error['event_title']['message'] = 'Event Title field should not be empty';
    }

    if(!empty($data['start_date'])) {
        $date = strtotime(date('Y-m-d',strtotime($data['start_date'])));
        $today = strtotime(date('Y-m-d'));
        if (DateTime::createFromFormat('Y-m-d', $data['start_date']) != false) {
            if ($date < $today) {
                $error['start_date']['message'] = 'Start Date should be after or from today';        
            }
        }
        else {
            $error['start_date']['message'] = 'Start Date is not valid';    
        }
    }
    else {
        $error['start_date']['message'] = 'Start Date field shold not be empty.';
    }
    if(!empty($data['end_date'])) {
        $start_date = strtotime(date('Y-m-d',strtotime($data['start_date'])));
        $end_date = strtotime(date('Y-m-d',strtotime($data['end_date'])));
        $today = strtotime(date('Y-m-d'));
        if (DateTime::createFromFormat('Y-m-d', $data['end_date']) != false) {
            if ($end_date < $start_date) {
                $error['end_date']['message'] = 'End Date should be after or from Start Date';        
            }
        }
        else {
            $error['end_date']['message'] = 'Start Date is not valid';    
        }
    }
    else {
        $error['end_date']['message'] = 'Start Date field shold not be empty.';
    }
    if(!empty($data['occurence_1'])) {
        $val_arr = ['Every', 'Every other', 'Every third', 'Every Forth'];
        if (!in_array($data['occurence_1'], $val_arr)) {
            $error['occurence_1']['message'] = 'Recurrence value is invalid';
        }
    }
    else {
        $error['occurence_1']['message'] = 'Recurrence should not be empty';
    }
    if(!empty($data['occurence_2'])) {
        $val_arr = ['Day', 'Week', 'Month', 'Year'];
        if (!in_array($data['occurence_2'], $val_arr)) {
            $error['occurence_2']['message'] = 'Recurrence value is invalid';
        }
    }
    else {
        $error['occurence_2']['message'] = 'Recurrence should not be empty';
    }
    if (!empty($error)) {
        $_SESSION['error'] = $error;
        $_SESSION['form_data'] = $data;
        header('Location:addevent.php');
    }
    else {
        return 1;
    }

}