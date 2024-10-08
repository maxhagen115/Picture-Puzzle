<?php
session_start();
$uploads_dir = 'C:\xampp\htdocs\picturepuzzle\IMG\img';
$name = $_FILES['file']['name'];
echo $name;
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];

$width = 800;
$height = 800;

if (isset($name)) {
    if (!empty($name)) {
        if (move_uploaded_file($tmp_name,  "$uploads_dir/$name")) {
        }
    }
}

$original = imagecreatefromjpeg("IMG/img/$name");
$data = getimagesize("IMG/img/$name");
$width_org = $data[0];
$height_org = $data[1];
$resized = imagecreatetruecolor($width, $height);
imagecopyresampled($resized, $original, 0, 0, 0, 0, $width, $height, $width_org, $height_org);
imagejpeg($resized, "./IMG/img/$name");

$_SESSION['picture']  =  "./IMG/img/$name";
$tegels = $_POST['dropdown'];
header("Location: http://localhost/picturepuzzle/puzzle.php?tegels=$tegels");
