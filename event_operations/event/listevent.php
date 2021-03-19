<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$count = 0;
include('check_connection.php');
$events = get_list();

function get_list() {
    $conn = check_db();
    $query = 'SELECT * FROM event';
    $result = mysqli_query($conn, $query);
    $count = 0;
    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $count = 1;
        $events = [];
        $data = [];
        foreach ($rows as $row) {
            $data['id'] = $row['ID'];
            $data['event_title'] = $row['TITLE'];
            $data['dates'] = date('Y-m-d',strtotime($row['START_DATE'])) . ' to ' .  date('Y-m-d',strtotime($row['END_DATE']));
            $data['occurence'] = $row['OCCURENCE_1'] . ' ' . $row['OCCURENCE_2'];
            $data['actions'] = '<a href="viewevent.php/?id=' . $row['ID'] . '">View</a>';
            array_push($events, $data);
        }
    }
    return $events;
}
?>

<?php if ( $count != 0) { ?>
    <h1> No Data to display</h1>
<?php } 
else {?>
    <h1>Event List</h1>
    <table style='width:50%; text-align:center; margin-left:25%; max-width:50%'>
        <tr>
            <th>#</th>
            <th>Event Title </th>
            <th>Dates </th>
            <th>Occurence </th>
            <th>Actions </th>
        </tr>
        <?php foreach ($events as $event) { ?>
            <tr>
                <?php foreach ($event as $val) { ?>
                    <td> <?php echo $val ?></td>
                <?php }?>
            </tr>
        <?php } ?>

    </table>
<?php }?>