<html> 
<title>Format Conversion</title>

<body>
Go to the link below to view the format options.
</br>
http://accounts.zone/format.png
<hr>
<center><h1>Format Conversion</h1><br>Credit Card List:
<form action="" method=post name=f> 
<textarea wrap="off" name=input cols=90 rows=20>
Paste your CC's Here
</textarea>
<hr>
<input style="width:100px" class="button" type=submit name=submit size=10 value="Change Format">
</form>
<?php
error_reporting(0);
ini_set('display_errors', 0);
ini_set('memory_limit', '-1');
if ($_POST['input']){
$input = trim($_POST['input']); 
//$input = file_get_contents("input.txt");
$input = str_replace("\r\n","|",$input);
$input = str_replace("|Last Name :","",$input);
$input = str_replace("First Name : ","\n",$input);
$input = str_replace("Address : ","",$input);
$input = str_replace("Address2 : ","",$input);
$input = str_replace("City : ","",$input);
$input = str_replace("State : ","",$input);
$input = str_replace("Zip Code : ","",$input);
$input = str_replace("Country : ","",$input);
$input = str_replace("Card Type : ","",$input);
$input = str_replace("Card Number : ","",$input);
$input = str_replace("VBV/MSC Status : ","",$input);
$input = str_replace("Exp Month : ","",$input);
$input = str_replace("Exp Year : ","",$input);
$input = str_replace("CVV : ","",$input);
echo "
<center>
<textarea wrap='off' name=input cols=90 rows=20>
$input
</textarea>
</center>
";
}


// put every line into an array
//$newlines = explode("", $input);

// go through each line
//foreach($newlines as $value) {
    // separate the credentials (username:password)
   // $creds = explode('\n', $value);
    // output the first credential in $creds array (username)
    //echo $creds[0] . "<br>";
	//$data = $creds[0];
//	file_put_contents("output.txt", $input . PHP_EOL, FILE_APPEND);

?>