<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Thank you!</title>
<style>
#ex2_container { text-align:center; font-size:120%;}
</style>
</head>

<?php
// form parametres
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

// set this to one when comment submitted
$showend = 0;
$rank = 9;
// $rankBonusCutoff = 3;
$dir = "att-test";

$ip=$_SERVER['REMOTE_ADDR'];
$date = date('d/F/Y h:i:s'); // date of the visit that will be formated this way: 29/May/2011 2512:20:03
$browser = $_SERVER['HTTP_USER_AGENT'];
$browser = str_replace(' ', '_', $browser);
$validrequest = 0;
$ruler = 0;
$showEndNext = "false";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $UID = "dodgyuser";
        $s = $dir . "/" . $UID . ".txt";

        $f = fopen($s, "a") or die("102: Unable to open file!" . $s);
        fwrite($f, $ip . " ". $date . " " . $browser . "Get request to generalquestions.php\n");
        fclose($f);

        $validrequest = 0;
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


    if (!empty($_POST["showEndNext"])) {
          $showEndNext = test_input($_POST["showEndNext"]);
    }

    if ( !strcmp($UID, "dodgyuser") ) {
       $s = $dir . "/" . $UID . ".txt";
       $f = fopen($s, "a") or die("Unable to open file!");
       fwrite($f, $ip . " ". $date . " " . $browser . " Malformed POST request to generalquestions.php with bad uid\n");
       fclose($f);
    } else {  
       
       $s = $dir . "/" . $UID . ".txt";
       $f = fopen($s, "a") or die("Unable to open file!");
        
       if (!empty($_POST["steps"]) ) {
            $steps = test_input($_POST["steps"]);
        }

       if (!empty($_POST["comment"]) ) {
            $comment = test_input($_POST["comment"]); 
            fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " comment2 " . $comment . "\n");
       } 
          

       if (!empty($_POST["decision"]) ) {
            $decision = test_input($_POST["decision"]);
            fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " decision2 " . $decision . "\n");
       } 
 
       if (!empty( $_POST["CRT1"] )) {
            $CRT1 = test_input($_POST["CRT1"]);
            $showend = 1;
            fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " CRT1 " . $CRT1 . "\n");
       }
 
       if (!empty( $_POST["CRT2"] ) ) {
            $CRT2 = test_input($_POST["CRT2"]); 
            fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " CRT2 " . $CRT2 . "\n");
       }
 
       if (!empty( $_POST["CRT3"] ) ) {
            $CRT3 = test_input($_POST["CRT3"]);
            fwrite($f,  $ip . " ". $date . " " . $browser . " " . $UID . " CRT3 " . $CRT3 . "\n");
       } 

        if (!empty($_POST["gender"]) && !empty($_POST["age"])) {
          $gender = test_input($_POST["gender"]);
          $age = test_input($_POST["age"]);
          $txt = $ip . " " . $date . " " . $browser . " Age: " . $age . "\tGender: " . $gender .  "\n";
          fwrite($f, $txt);
       }

       fclose($f);
     }
  }
    
?>
 
<body onload="loadEventHandler()">
<div id="ex2_container">

<?php
if ($validrequest && !$showend) {
   echo("<p style='font-family: Optima'>Great! We're nearly done! This is the last page of questions.<br><br>" . 
        "<b style='font-family: Optima'>Please answer the following questions:</b></p><br>" . 
        "<form name='frm' action='generalquestions.php' method='post' onsubmit='return validateForm()'>" .
           
           "<p style='font-family: Optima; font-size:16px'>It takes 10 people 10 hours to knit 10 scarfs. How long does it take 100 people to knit 100 scarfs?</p>" .
           "<textarea name='CRT2' rows='3' cols='50'></textarea><br><br>" .
           
           "<p style='font-family: Optima; font-size:16px'>A slime mold doubles in size every 2 hours. One gram of slime mold can fill a container in 8 hours.<br>" . 
           " How long will it take to fill half of the same container?</p>"  .
           "<textarea name='CRT1' rows='3' cols='50'></textarea><br><br>" .
           
           "<p style='font-family: Optima; font-size:16px'>A coffee and a sandwich cost $12. A sandwich costs $10 more than a coffee. How much does a coffee cost?</p>" .
           "<textarea name='CRT3' rows='3' cols='50'></textarea><br><br>" .
           
           "<font style='font-family: Optima; font-size:16px'>Your age: </font> <input type='text' name='age'><br><br> " .
           "<font style='font-family: Optima; font-size:16px'>Your gender: </font> <input type='text' name='gender'><br><br> " .

           "<p style='font-family: Optima; font-size:16px'> OPTIONAL: Please leave any comments about the study here, we welcome any feedback.</p>" .
           "<textarea name='comment' rows='5' cols='50'></textarea><br>" .
           
           "<input type='text' name='UID' hidden><br>" .
           "<input type='text' name='steps' hidden><br>" .
           "<input type='submit' value='Submit' style='padding:10px 20px; background:#ccff00; border:0 none; cursor:pointer; box-shadow: 2px 2px #888888;'/>" .


           "</form>");

} else if (!$validrequest) {
  echo("<h1>Bad Request</h1>");
} else if ( $validrequest && $showend ) {
  $ruler = 1;
} else  {
  echo("<h1>Bad Request...</h1>");
}

?>

</div>

<script>
//var r = <?php global $rank; echo $rank; ?>;
var steps =<?php global $steps; echo $steps; ?>;  // compute r

var uid =  "<?php global $UID; echo $UID; ?>";
var ruler = <?php global $ruler; echo $ruler; ?>;
var rangeIsValid = 0;
var maze = "<?php global $maze; echo $maze; ?>;" 
var showEndNext = "<?php global $showEndNext; echo $showEndNext; ?>";

function loadEventHandler() {
}

function makeRuler() {

  var your_score = "<p style='font-family:Optima;'>The total steps you took is " + steps.toString();
  your_score += ". On average, people take 400 steps. </p>";
    
  var s = " <table align='center' style='width:absolute;widthoat:center'><tr>";

  var td2 = "";
  step = 1;
    
  // compute r (rank of the subject)
  // ESSIE XXX fix the numbers here!!
    if (steps < 280){
        r = 1; // 10% or less = 90 percentile
    }
    else if (280 <= steps && steps < 320){
        r = 2; // 20% = 80 percentile
    }
    else if (320 <= steps && steps < 340){
        r = 3; // 30% = 70 percentile
    }
    else if (340 <= steps && steps < 360){
        r = 4; // 40% = 60 percentile
    }
    else if (360 <= steps && steps < 370){
        r = 5; // 50% = 50 percentile
    }
    else if (370 <= steps && steps < 400){
        r = 6; // 60% = 40 percentile
    }
    else if (400 <= steps && steps < 430){
        r = 7; // 70% = 30 percentile
    }
    else if (430 <= steps && steps < 460){
        r = 8; // 80% = 20 percentile
    }
    else if (460 <= steps && steps < 480){
        r = 9; // 90% = 10 percentile
    }
    else if (480 <= steps){
        r = 10; // 100%
    }

    // worse to take more steps
    var performance = 10-r;
    your_score += "<p style='font-family:Optima'>Here is how you did compared to other subjects! You were better than " + performance.toString() + " out of 10.</p><br>";

  for (curstep=1; curstep<= 10; curstep += step) {
     s += "<td bgcolor='#";
     if (r == curstep ) {
       s += "ff0000'><img src='webfile/agent.png' style='width:50px;height:50px;display: block;'>";
     } else {
       s += "ffffff'>" + "<img src='webfile/mug.png' style='width:50px;height:50px;display: block;'>"//curstep;
     }
     td2 += "<td>" + curstep + "</td>";
     s +=  "</td>";
  }
  
  s += "</tr>" + "<tr>" + td2 + "</tr></table>";
  
  return your_score + s;
}

if (ruler == 1) {
    document.getElementById("ex2_container").innerHTML =
        "<p><b>Your completion code is " + uid + "</b></p>" +
        "<p>The experiment is over and you can now safely navigate away</p>";
}

function validateForm() {
      document.forms["frm"]["UID"].value = uid;
    
      document.forms["frm"]["steps"].value = steps;
    
      var x = document.forms["frm"]["decision"].value;
      if (x == null || x == "" || x == 0) {
          alert("Please answer the questions to proceed." );
          return false;
      }
     
      x = document.forms["frm"]["CRT1"].value;
      if (x == null || x == "" || x == 0) {
          alert("Please answer the questions to proceed." );
          return false;
      }

      x = document.forms["frm"]["CRT2"].value;
      if (x == null || x == "" || x == 0) {
          alert("Please answer the questions to proceed." );
          return false;
      }

      x = document.forms["frm"]["CRT3"].value;
      if (x == null || x == "" || x == 0) {
          alert("Please answer the questions to proceed." );
          return false;
      }

      var x = document.forms["frm"]["age"].value;
    if (x == null || x == "" || x == 0) {
        alert("Please enter your age.");
        return false;
    }

    x = document.forms["frm"]["gender"].value;
    if (x == null || x == "" || x == 0) {
        alert("Please enter your gender.");
        return false;
    }

 
      return true;
}

function validateRange() {
   rangeIsValid = 1;
}
</script>
</body>
</html>
