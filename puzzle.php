<?php
session_start();
$picture = $_SESSION['picture'];
$tegels = $_GET['tegels'];
$wortelTegels = sqrt($tegels);
$image = imagecreatefromjpeg($picture);
$height = imagesy($image);
$width = imagesx($image);
$heightTile = ($height / $wortelTegels);
$widthTile = ($width / $wortelTegels) - 10;

$a = 0;
while ($a <= $height) {
  $slice[] = $a;
  $a += 20;
}
if ($a > $height && end($slice) !== $height) {
  $slice[] = $a + ($height - $a);
}
$y = 0;
$tegelTeller = 0;
for ($i = 0; $i < $wortelTegels; $i++) {
  $x = 0;
  if ($i > 0) {
    $y = $y + $heightTile;
  } else {
    $y = $y;
  }
  for ($k = 0; $k < $wortelTegels; $k++) {
    if ($k > 0) {
      $x = $x + $widthTile;
    } else {
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
<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Puzzelmaker</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>


<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">

  <nav class="w-full bg-white shadow-md py-2 px-4">
    <div class="flex justify-between items-center">
      <a href="#" class="text-xl font-bold text-indigo-600">Puzzel</a>
      <a href="http://localhost/picturepuzzle/index.php" class="text-indigo-600 hover:text-indigo-800">
        Start Pagina
      </a>
    </div>
  </nav>

  <div class="container mx-auto flex-grow py-2">
    <div class="flex justify-between mb-4">
      <div class="flex justify-center mb-6">
        <button class="bg-indigo-600 text-white px-3 py-1.5 rounded shadow hover:bg-indigo-700 transition"
          onclick="window.location.href='http://localhost/picturepuzzle/puzzle.php?tegels=<?php echo $tegels ?>'">
          Reset
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-0">
      <div class="bg-white p-2 rounded-lg shadow-lg h-full flex flex-col">
        <table class="table-auto w-full text-center flex-grow">
          <tbody>
            <?php
            $imageTeller = 0;
            for ($i = 0; $i < $wortelTegels; $i++) { ?>
              <tr>
                <?php for ($k = 0; $k < $wortelTegels; $k++) {
                  $imageTeller++; ?>
                  <td id="tdd<?php echo $imageTeller ?>" class="border" style="width:<?php echo ($widthTile * 0.9); ?>px; height:<?php echo ($heightTile * 0.9); ?>px; padding: 0; margin: 0;" onclick="checker2(<?php echo $imageTeller ?>)">
                    <img id="<?php echo $imageTeller ?>" class="puzzle" src="" alt="" style="display: block; margin: auto;">
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="bg-white p-2 rounded-lg shadow-lg h-full flex flex-col">
        <table class="table-auto w-full text-center flex-grow">
          <tbody>
            <?php
            $imageTeller = 0;
            $random_array = range(1, $wortelTegels * $wortelTegels);
            shuffle($random_array);
            for ($i = 0; $i < $wortelTegels; $i++) { ?>
              <tr>
                <?php for ($k = 0; $k < $wortelTegels; $k++) {
                  $imageTeller++; ?>
                  <td id="td<?php echo $random_array[$imageTeller - 1] ?>" class="border p-0" onclick="checker1(<?php echo $random_array[$imageTeller - 1] ?>)">
                    <img id="id<?php echo $random_array[$imageTeller - 1] ?>" class="puzzle" src="./test/<?php echo $random_array[$imageTeller - 1] ?>.jpg" alt="" style="display: block; margin: auto;">
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

<script>
  var teller = 0;
  var id1;
  var id2;
  var fail = 0;
  var totalTegels = parseInt("<?php echo $tegels; ?>");

  function checker1(id) {
    id1 = id;
  }

  function checker2(id) {
    if (id1 > 0) {
      id2 = id;
      if (id1 != id2) {
        alertify.error('Foute plek');
        fail++;
      } else {
        document.getElementById(id2).src = "./test/" + id1 + ".jpg";
        document.getElementById("id" + id1).src = "";
        document.getElementById("td" + id1).onclick = "";
        alertify.success('Goede plek');
        teller++;
        if (teller === totalTegels) {
          alertify.success('Gefeliciteerd! Je hebt de puzzel voltooid!');
          document.getElementById("check").disabled = false;
        }
      }
    }
    id1 = 0;
    id2 = 0;
  }
</script>