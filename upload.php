<?php
session_start();

// Check if GD extension is enabled
if (!extension_loaded('gd')) {
    die('Error: GD extension is not enabled. Please enable it in your php.ini file.');
}

$uploads_dir = 'C:\xampp\htdocs\picturepuzzle\IMG\img';
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];

$width = 800;
$height = 800;

if (isset($name)) {
    if (!empty($name)) {
        if (move_uploaded_file($tmp_name,  "$uploads_dir/$name")) {
            // Get image info
            $imagePath = "$uploads_dir/$name";
            $data = getimagesize($imagePath);
            
            if ($data === false) {
                die('Error: Invalid image file.');
            }
            
            $width_org = $data[0];
            $height_org = $data[1];
            $mimeType = $data['mime'];
            
            // Create image resource based on file type
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $original = imagecreatefromjpeg($imagePath);
                    break;
                case 'image/png':
                    $original = imagecreatefrompng($imagePath);
                    break;
                case 'image/gif':
                    $original = imagecreatefromgif($imagePath);
                    break;
                case 'image/webp':
                    $original = imagecreatefromwebp($imagePath);
                    break;
                default:
                    die('Error: Unsupported image type. Please use JPEG, PNG, GIF, or WebP.');
            }
            
            if ($original === false) {
                die('Error: Could not create image resource.');
            }
            
            // Create resized image
            $resized = imagecreatetruecolor($width, $height);
            
            // Preserve transparency for PNG and GIF
            if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $width, $height, $transparent);
            }
            
            imagecopyresampled($resized, $original, 0, 0, 0, 0, $width, $height, $width_org, $height_org);
            
            // Save as JPEG
            $outputPath = "./IMG/img/$name";
            if (!imagejpeg($resized, $outputPath, 90)) {
                die('Error: Could not save resized image.');
            }
            
            // Clean up memory
            imagedestroy($original);
            imagedestroy($resized);
            
            $_SESSION['picture'] = $outputPath;
            $tegels = $_POST['dropdown'];
            header("Location: http://localhost/picturepuzzle/puzzle.php?tegels=$tegels");
            exit;
        } else {
            die('Error: Failed to upload file.');
        }
    } else {
        die('Error: No file selected.');
    }
} else {
    die('Error: No file uploaded.');
}
