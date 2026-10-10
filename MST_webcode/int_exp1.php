<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Instructions</title>
<style>
   #ex2_container { 
      text-align:center; 
      text-justify: inter-word;
      font-size:110%;
      }
</style>
</head>
 
<body>

<?php

// form parametres
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

$dir = "att-test";
$UID =  "";
$ip=$_SERVER['REMOTE_ADDR'];
$date = date('d/F/Y h:i:s'); 
$browser = $_SERVER['HTTP_USER_AGENT'];
$browser = str_replace(' ', '_', $browser);
$validrequest = 0;
$quiz = "";
$firsttrial = 0;

if (!is_writable($dir)) {
    echo 'The directory is not writable ' . $dir . '<br>';
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $UID = "dodgyuser";
        $s = $dir . "/" . $UID . ".txt";
        $f = fopen($s, "a") or die("Unable to open file!" . $s);
        fwrite($f, $ip . " ". $date . " " . $browser . "Err: GET request \n");
        fclose($f);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $validrequest = 1;
   if (!empty($_POST["UID"])) {
      $UID = test_input($_POST["UID"]);
      if ( !strcmp($UID, "dodgyuser") ) {
        $validrequest = 0;
      }
   } else {
      $validrequest = 0;
      $UID = "dodgyuser";
   }


   if (!empty($_POST["quizAnswer"])) {
      $quiz1 = test_input($_POST["quizAnswer"]);
      $s = $dir . "/" . $UID . ".txt";
      $f = fopen($s, "a") or die("101 Unable to open file!" . $s);
      $txt = $ip . " " . $date . " " . $browser .  " " . $UID .  " solvingquiz: " . $quiz1 .  "\n";
      fwrite($f, $txt);
      fclose($f);
      //echo $quiz1;
   }

   
   if (!empty($_POST["decision"]) ) {
        $s = $dir . "/" . $UID . ".txt";
        $f = fopen($s, "a") or die("101 Unable to open file!" . $s);
        $decision = test_input($_POST["decision"]);
  //      echo $decision . "<br>";
        fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " decision2 " . $decision . "\n");
        fclose($f);
   }

   if (!empty($_POST["comment"]) ) {
        $s = $dir . "/" . $UID . ".txt";
        $f = fopen($s, "a") or die("101 Unable to open file!" . $s);
        $decision = test_input($_POST["comment"]);
        fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " comment2 " . $decision . "\n");
        fclose($f);
   }


   if (!empty($_POST["firsttrial"])) {
      $firsttrial = test_input($_POST["firsttrial"]);      
   }  
}

?>

<div id="ex2_container">
<font style="font-family: Optima">
   <br><b>INSTRUCTIONS (PLEASE READ CAREFULLY)</b><br><br>
   Your task is to exit the maze by reaching the red square, which is initially hidden. <br><br>
   Use the arrow keys on your keyboard to move through the maze. <br><br>
   You cannot see through the walls. The squares you cannot see yet are black.<br><br>
   <mark> The exit could be behind any of the black squares. </mark> <br><br> 
   A maze looks like this: <br><br>
   <img src='webfile/exampleplanning_keyboard.png' width='500' height='270' >
   
   <br><b> <font size="+4">💰</font> YOU COULD GET A BONUS! <font size="+4">💰</font> </b><br><br>
   <mark>Planning your path wisely will pay off.</mark> <br><br> 
   The better you plan your path, the fewer steps you'll take and the more bonus you can earn. <br><br>
   <!-- At the end, you will see how well you did compared to other participants. <br><br> -->
   <!-- When all participants' total steps are ranked from fewest to most: <br><br> -->
   <b>A bonus of $3</b> will be awarded if you're in the top 20%, OR <br><br>
   <b>A bonus of $2</b> will be awarded if you're better than average, OR <br><br>
   <b>A bonus of $1</b> will be awarded if you're better than the bottom 30%. <br><br>
</font>

<form name="frm" action="test.php" method="post" onsubmit="return validateForm()">
  <input type="text" name="UID" hidden>
  <input type="text" name="firsttrial" hidden>
  <input style="padding:10px 20px; background:#ccff00; border:0 none; cursor:pointer; box-shadow: 2px 2px #888888;"  type="submit" value="Let&#39;s practice!"/>
</form>
<br><br><br><br><br><br>

</div>
</body>

<script>
var quiz = "<?php global  $quiz; echo  $quiz; ?>";

function validateForm() {
    var u_id = "<?php global  $UID; echo  $UID; ?>";
    document.forms["frm"]["UID"].value = u_id;
    document.forms["frm"]["firsttrial"].value = "true";
    return true;  
}

</script>
</html>
