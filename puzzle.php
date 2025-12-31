<?php
session_start();
$picture = $_SESSION['picture'];
$tegels = $_GET['tegels'];
$wortelTegels = sqrt($tegels);

// Create puzzle_slices directory if it doesn't exist
$testDir = './puzzle_slices';
if (!file_exists($testDir)) {
    mkdir($testDir, 0777, true);
}

// Determine image type and load accordingly
$imageInfo = getimagesize($picture);
if ($imageInfo === false) {
    die('Error: Invalid image file.');
}

$mimeType = $imageInfo['mime'];
switch ($mimeType) {
    case 'image/jpeg':
    case 'image/jpg':
        $image = imagecreatefromjpeg($picture);
        break;
    case 'image/png':
        $image = imagecreatefrompng($picture);
        break;
    case 'image/gif':
        $image = imagecreatefromgif($picture);
        break;
    case 'image/webp':
        $image = imagecreatefromwebp($picture);
        break;
    default:
        die('Error: Unsupported image type.');
}

if ($image === false) {
    die('Error: Could not load image.');
}

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
  }
  for ($k = 0; $k < $wortelTegels; $k++) {
    if ($k > 0) {
      $x = $x + $widthTile;
    }

    $im2 = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $widthTile, 'height' => $heightTile]);
    if ($im2 !== FALSE) {
      $tegelTeller++;
      $outputPath = "$testDir/$tegelTeller.jpg";
      imagejpeg($im2, $outputPath, 90);
      imagedestroy($im2);
    }
  }
}
imagedestroy($image);
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
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>


<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">

  <nav class="w-full bg-white shadow-md py-6">
    <div class="container mx-auto flex justify-between items-center">
      <a href="#" id="confirmMainScreen" class="text-xl font-bold text-indigo-600">Puzzel</a>
      <a href="#" id="confirmStartPagina" class="text-indigo-600 hover:text-indigo-800 text-lg font-medium">
        Start Pagina
      </a>
    </div>
  </nav>

  <div class="container mx-auto flex-grow py-2">
    <div class="flex justify-center mb-4 pt-4">
      <button class="bg-indigo-600 text-white px-3 py-1.5 rounded shadow hover:bg-indigo-700 transition"
        onclick="window.location.href='http://localhost/picturepuzzle/puzzle.php?tegels=<?php echo $tegels ?>'">
        Reset
      </button>
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
                    <img id="id<?php echo $random_array[$imageTeller - 1] ?>" class="puzzle" src="./puzzle_slices/<?php echo $random_array[$imageTeller - 1] ?>.jpg" alt="" style="display: block; margin: auto;">
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bevestigingsmodal -->
  <div id="confirmationModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden justify-center items-center">
    <div class="bg-white p-6 rounded shadow-lg">
      <p class="text-lg mb-4">Weet je zeker dat je terug wilt naar het hoofdscherm?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelBtn" class="px-4 py-2 rounded bg-gray-300">Annuleren</button>
        <button id="confirmBtn" class="px-4 py-2 rounded bg-indigo-600 text-white">Bevestigen</button>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const confirmLink = document.getElementById('confirmMainScreen');
      const confirmStartPagina = document.getElementById('confirmStartPagina');
      const modal = document.getElementById('confirmationModal');
      const confirmBtn = document.getElementById('confirmBtn');
      const cancelBtn = document.getElementById('cancelBtn');

      // Open modal function
      const openModal = (e) => {
        e.preventDefault(); // voorkom standaard gedrag
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      };

      // Open modal for both links
      confirmLink.addEventListener('click', openModal);
      confirmStartPagina.addEventListener('click', openModal);

      // Bevestiging knop event
      confirmBtn.addEventListener('click', () => {
        window.location.href = 'index.php';
      });

      // Annuleren knop event
      cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      });

      // Sluit modal bij klikken buiten de modal
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }
      });
    });
  </script>
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
        document.getElementById(id2).src = "./puzzle_slices/" + id1 + ".jpg";
        document.getElementById("id" + id1).src = "";
        document.getElementById("td" + id1).onclick = "";
        alertify.success('Goede plek');
        teller++;
        if (teller === totalTegels) {
          alertify.success('Gefeliciteerd! Je hebt de puzzel voltooid!');
          
          // Trigger confetti celebration with delay to ensure it's visible
          setTimeout(function() {
            try {
              // Check if confetti is available (try both window.confetti and global confetti)
              var confettiFunc = window.confetti || (typeof confetti !== 'undefined' ? confetti : null);
              
              if (confettiFunc) {
                // Main confetti burst
                confettiFunc({
                  particleCount: 200,
                  spread: 100,
                  origin: { y: 0.5 },
                  colors: ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#3B82F6']
                });
                
                // Additional bursts from sides
                setTimeout(() => {
                  confettiFunc({ 
                    particleCount: 100, 
                    angle: 60, 
                    spread: 70, 
                    origin: { x: 0, y: 0.5 },
                    colors: ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981']
                  });
                }, 300);
                
                setTimeout(() => {
                  confettiFunc({ 
                    particleCount: 100, 
                    angle: 120, 
                    spread: 70, 
                    origin: { x: 1, y: 0.5 },
                    colors: ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981']
                  });
                }, 600);
              }
            } catch (e) {
              // Silently handle confetti errors
            }
          }, 500);
        }
      }
    }
    id1 = 0;
    id2 = 0;
  }
</script>