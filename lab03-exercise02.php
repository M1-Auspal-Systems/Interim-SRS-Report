<?php
//set default value of variables for initial page load
if (!isset($investment)) {
	$investment = '';
}
if (!isset($interest_rate)) {
	$interest_rate = '';
}
if (!isset($years)) {
	$years = '';
}

?>

<html>
<head>
<title>Exercise 3-2</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<h1>Future Value Calculator</h1>
<form name='mainForm' id='mainForm' method='post'>
	<div id="data">
		<label>Investment Amount:</label>
		<input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>"> </br>
		<label>Yearly Interest Rate:</label>
		<input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>"> </br>
		<label>Number of Years:</label>
		<input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>"> </br>
	</div>
	<div id="buttons">
		<label>&nbsp;</label>
		<input type="submit" value="Calculate"> </br>
	</div>
</form>

<?php
//check if the form has been posted
if ($_SERVER["REQUEST_METHOD"] == "POST") { // yes the form posted
    // get the data from the form
    $investment = filter_input(INPUT_POST, 'investment',
        FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate',
        FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years',
        FILTER_VALIDATE_INT);
    
    // validate investment
    if ($investment === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    } else if ( $investment <= 0 ) {
        $error_message = 'Investment must be greater than zero.'; 
    // validate interest rate
    } else if ( $interest_rate === FALSE )  {
        $error_message = 'Interest rate must be a valid number.'; 
    } else if ( $interest_rate <= 0 ) {
        $error_message = 'Interest rate must be greater than zero.'; 
    // validate years
    } else if ( $years === FALSE ) {
        $error_message = 'Years must be a valid whole number.';
    } else if ( $years <= 0 ) {
        $error_message = 'Years must be greater than zero.';
    } else if ( $years > 30 ) {
        $error_message = 'Years must be less than 31.';
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
    }

    // if an error message exists, go to the index page
    if ($error_message != '') {
		echo $error_message;
		exit(); 
   }

    // calculate the future value
    $future_value = $investment;
    for ($i = 1; $i <= $years; $i++) {
        $future_value += $future_value * $interest_rate * .01; 
    }
	
    // apply currency and percent formatting
    $investment_f = '$'.number_format($investment, 2);
    $yearly_rate_f = $interest_rate.'%';
    $future_value_f = '$'.number_format($future_value, 2);
	
	showResults($investment_f, $yearly_rate_f, $future_value_f, $years);

}

function showResults($investment_f, $yearly_rate_f, $future_value_f, $years) {
	echo '<label>Investment Amount:</label>';
	echo '<span>' . $investment_f . '</span></br>';
	echo '<label>Yearly Interest Rate:</label>';
	echo '<span>' . $yearly_rate_f . '</span></br>';
	echo '<label>Number of Years:</label>';
	echo '<span>' . $years . '</span></br>';
	echo '<label>Future Value:</label>';
	echo '<span>' . $future_value_f . '</span></br>';

}
?>

</body>
</html>
