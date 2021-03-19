<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('check_connection.php');
$event = [];
if (isset($_GET['id'])) {
    $event = show_event($_GET['id']);
    print_r($event);
}

function show_event($id) {
    $conn = check_db();
    $query = 'SELECT * FROM event WHERE id = ' . $id;
    $result = mysqli_query($conn, $query);
    $count = 0;
    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows[0];
    } 
}
$event_title = $event['TITLE'];
$event_occurence = $event['OCCURENCE_1'] . ' ' . $event['OCCURENCE_2'];
print_r($event_occurence);
$now = strtotime('now');
$time_gap = '';
switch ($event_occurence) {
    case 'Every Day':
        $time_gap = strtotime('next day');
        break;
    case 'Every Other Day':
        $time_gap = strtotime('next day')*2;
        break;
    case 'Every Third Day':
        $time_gap = strtotime('next day')*3;
        break;
    case 'Every Forth Day':
        $time_gap = strtotime('next day')*4;
        break;
    case 'Every Week':
        $time_gap = strtotime('next week');
        break;
    case 'Every Other Week':
        $time_gap = strtotime('next week')*2;
        break;
    case 'Every Third Week':
        $time_gap = strtotime('next week')*3;
        break;
    case 'Every Forth Week':
        $time_gap = strtotime('next week')*4;
        break;
}
?>
