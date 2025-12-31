<?php
session_start();

// Include configuration
require_once 'config.php';

$_SESSION['tegelkeuze']  =  "dropdown";
$tegelskeuze4 = 4;
$tegelskeuze9 = 9;
$tegelskeuze16 = 16;
?>

<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Puzzelmaker</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-lg rounded-lg p-10 max-w-md w-full">
    <h2 class="text-2xl font-bold text-gray-700 mb-8">Maak een Puzzel</h2>

    <p class="mb-8 text-gray-600 leading-relaxed">Upload een foto en kies hoeveel stukjes je wilt dat de puzzel heeft.</p>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-8">
      <div class="space-y-3">
        <div class="mt-2">
          <input type="file" name="file" id="file" required class="hidden">
          <label for="file" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 font-semibold cursor-pointer inline-block text-center">
            Foto voor puzzel
          </label>
          <div id="file-preview" class="mt-4 hidden flex justify-center">
            <img id="preview-image" src="" alt="Preview" class="max-w-xs h-auto rounded-lg shadow-md max-h-32 object-contain">
          </div>
        </div>
      </div>

      <div class="space-y-3 pt-2">
        <label for="dropdown" class="block text-sm font-medium text-gray-700 mb-2">Puzzelstukjes:</label>
        <select name="dropdown" id="dropdown" required class="block w-full py-3 px-4 border-2 border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-200">
          <option value="" disabled selected>Selecteer aantal stukjes</option>
          <option value="4">4</option>
          <option value="9">9</option>
          <option value="16">16</option>
          <option value="36">36</option>
        </select>
      </div>

      <div class="pt-4">
        <button class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 font-semibold" type="submit" name="submit">Maak Puzzel</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('file').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const previewContainer = document.getElementById('file-preview');
      const previewImage = document.getElementById('preview-image');
      
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          previewImage.src = e.target.result;
          previewContainer.classList.remove('hidden');
        };
        
        reader.readAsDataURL(file);
      } else {
        previewContainer.classList.add('hidden');
        previewImage.src = '';
      }
    });
  </script>
</body>
</html>