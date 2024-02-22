<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="./CSS/mystyle.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<?php
session_start();
$picture = $_SESSION['picture'];
$tegels = $_GET['tegels'];
$wortelTegels = sqrt($tegels);
$image = imagecreatefromjpeg($picture);
$height = imagesy($image);
$width = imagesx($image);
$heightTile = ($height / $wortelTegels);
$widthTile = ($width / $wortelTegels);

$a = 0;
while($a<=$height){
    $slice[] = $a;
    $a+=20;
}
if($a>$height && end($slice) !== $height){
    $slice[] = $a+($height-$a);
}
$y= 0;
$tegelTeller = 0;
for($i=0;$i < $wortelTegels ;$i++){
    $x = 0;
    if ($i > 0){
        $y = $y + $heightTile;
    } else{
      $y = $y;
    }
    for($k=0;$k < $wortelTegels ;$k++){
      if ( $k > 0){
        $x = $x + $widthTile;
      } else{
        $x = $x;
      }

    $im2 = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $widthTile, 'height' => $heightTile]);
    if ($im2 !== FALSE) {
      $tegelTeller++;
        imagejpeg($im2, "./test/$tegelTeller.jpg");
        imagedestroy($im2);
      }
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Puzzel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="http://localhost/picturepuzzle/index.php">Start Pagina<span
            class="sr-only">(current)</span></a>
        <input type="hidden" value="<?php echo $tegels ?>" id="tegels">
      </li>
    </ul>

  </div>
</nav>

<div class="container-fluid" style='width: 100%; margin-right: auto; margin-left: auto;'>
  <div class="row justify-content-center">
    <div style="width:20px;"></div>
    <? $tegels = $_POST['dropdown']; ?>
    <a class="btn btn-primary" href="http://localhost/picturepuzzle/puzzle.php?tegels=<?php echo $tegels?>"
      style="margin-bottom: 20px; width: 200px;">Reset</a>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <table class="table-left table-bordered ">
        <tbody>
          <?php
            $imageTeller = 0;
            for ($i=0; $i <$wortelTegels ; $i++) { ?>
          <tr>
            <?php  for ($k=0; $k <$wortelTegels ; $k++) {
                  $col = floor(12 / $wortelTegels);
                  $imageTeller++;
                  ?>
            <td name="test" id="tdd<?php echo $imageTeller?>"
              style="width:<?php echo $widthTile;?>px; height:<?php echo $heightTile;?>px;"
              onclick="checker2(<?php echo $imageTeller ?>)"> <img id="<?php echo $imageTeller ?>" class="puzzle" src="" alt=""></td>
            <?php } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="tabel-right">
        <tbody>
          <?php
            $imageTeller = 0;
            $idteller = 1;
            $random = 0;
            $random_array = array();
            for ($l=0; $l <$wortelTegels ; $l++) {
              for ($m=0; $m < $wortelTegels; $m++) { 
                $random++;
                $random_array[$random] = $random;

              }
             
            }
            shuffle($random_array);
            for ($i=0; $i <$wortelTegels ; $i++) { ?>
          <tr>
            <?php 
                for ($k=0; $k <$wortelTegels ; $k++) {
                  $col = floor(12 / $wortelTegels);
                  ?>
            <td name="test" id="td<?php echo $random_array[$imageTeller]?>"
              onclick="checker1(<?php echo $random_array[$imageTeller] ?>)"> <img
                id="id<?php echo $random_array[$imageTeller] ?>" class="puzzle"
                src="./test/<?php echo $random_array[$imageTeller] ?>.jpg" alt=""></td>

            <?php $idteller++; $imageTeller++; } ?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  var teller = 0;
  var id1;
  var id2;
  var id3;
  var fail = 0;

  function checker1(id) {
    id1 = id;
  }
  function checker2(id) {
    if (id1 > 0) {
      teller++;
      id2 = id;

      if (id1 != id2) {
        alertify.error('Foute plek');
        fail++;
      } else {
        document.getElementById(id2).src = "./test/" + id1 + ".jpg";
        document.getElementById("id" + id1).src = "";
        document.getElementById("td" + id1).onclick = "";
        tegels = document.getElementById("tegels").value;
        alertify.success('Goede plek');
      }

      if (teller == tegels) {
        document.getElementById("check").disabled = false;
      }

    } else {
      if (id3 > 0) {} else {
        var id3 = id;
      }

    }
    id1 = 0;
    id2 = 0;
  }
</script>