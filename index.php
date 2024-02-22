<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="./CSS/mystyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
$_SESSION['tegelkeuze']  =  "dropdown";
$tegelskeuze4 = 4;
$tegelskeuze9 = 9;
$tegelskeuze16 = 16;
?>

<a class="text-start"> Hier kunt u een foto uploaden en gebruiken om een puzzel mee te maken. </a>
<div class="text-start-uploaden">
<form action="upload.php" method="POST" enctype="multipart/form-data">Selecteer een foto:
  <input type="file" name="file" id="file" required> 
  <a class="tegels-number" id="tegels-number" name="tegels-number"> Puzzelstukjes:</a>
  <select class="tegels-number" name="dropdown" id="dropdown" required>
    <option value=""></option>
    <option value="4">4</option>
    <option value="9">9</option>
    <option value="16">16</option>
    <option value="36">36</option>
  </select>
  <button class="btn btn-primary" type="submit" value="submit" name="submit" id="submit">Gebruik</button>
</div>
  </div>
</form>


