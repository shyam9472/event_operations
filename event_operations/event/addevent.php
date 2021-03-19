<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$event_title = '';
$event_title_error = '';
$start_date = '';
$start_date_error = '';
$end_date = '';
$end_date_error = '';
$occurence_1 = '';
$occurence_1_error = '';
$occurence_2 = '';
$occurence_2_error = '';
$recurrence_error = '';
if (isset($_SESSION['error'])) {
    if (isset($_SESSION['error']['event_title'])) {
    $event_title_error = $_SESSION['error']['event_title']['message'];
    }
    if (isset($_SESSION['error']['start_date'])) {
    $start_date_error = $_SESSION['error']['start_date']['message'];
    }
    if (isset($_SESSION['error']['end_date'])) {
    $end_date_error = $_SESSION['error']['end_date']['message'];
    }
    if (isset($_SESSION['error']['occurence_1'])) {
    $occurence_1_error = $_SESSION['error']['occurence_1']['message'];
    }
    if (isset($_SESSION['error']['occurence_2'])) {
    $occurence_2_error = $_SESSION['error']['occurence_2']['message'];
    }
    $event_title = $_SESSION['form_data']['event_title'];
    $start_date = $_SESSION['form_data']['start_date'];
    $end_date = $_SESSION['form_data']['end_date'];
    $occurence_1 = $_SESSION['form_data']['occurence_1'];
    $occurence_2 = $_SESSION['form_data']['occurence_2'];
    if (!empty($occurence_1_error) or !empty($occurence_2_error)) {
        $recurrence_error = !empty($occurence_1_error) ? $occurence_1_error : $occurence_2_error;
    }
    unset($_SESSION['error']);
    unset($_SESSION['form_data']);
}

?>

<form action='addevent_submit.php' method='post'>
<label for='event_title'>Event Title:</label> <input type="text" name='event_title' required='true' value='<?php echo $event_title; ?>'>
<p class='error'><?php echo $event_title_error ?></p>
</br>
<label for='start_date'>Start Date:</label><input type='date' name='start_date' value=<?php echo $start_date; ?>>
<p class='error'><?php echo $start_date_error ?></p>
</br>
<label for='end_date'>End Date:</label><input type='date' name='end_date' value=<?php echo $end_date; ?>>
<p class='error'><?php echo $end_date_error ?></p>
</br>
<label for='occurence_1'>Recurrence: </label>
<select name='occurence_1' <?php echo $occurence_1; ?>>
<option value=''>-Select-</option>
<option value='Every'>Every</option>
<option value='Every Other'>Every Other</option>
<option value='Every Third'>Every Third</option>
<option value='Every Forth'>Every Forth</option>
</select>
<select name='occurence_2' value= <?php echo $occurence_2; ?>>
<option value=''>-Select-</option>
<option value='Day'>Day</option>
<option value='Week'>Week</option>
<option value='Month'>Month</option>
<option value='Year'>Year</option>
</select>
<p class='error'><?php echo $recurrence_error?></p>
</br>
<input type='submit'>
</form>