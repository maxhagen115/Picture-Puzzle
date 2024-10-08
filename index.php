<?php
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

  <div class="bg-white shadow-lg rounded-lg p-8 ">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Maak een Puzzel</h2>

    <p class="mb-4 text-gray-600">Upload een foto en kies hoeveel stukjes je wilt dat de puzzel heeft.</p>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
      <div>
        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Selecteer een foto:</label>
        <input type="file" name="file" id="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
      </div>

      <div>
        <label for="dropdown" class="block text-sm font-medium text-gray-700 mb-1">Puzzelstukjes:</label>
        <select name="dropdown" id="dropdown" required class="block w-full mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          <option value="" disabled selected>Selecteer aantal stukjes</option>
          <option value="4">4</option>
          <option value="9">9</option>
          <option value="16">16</option>
          <option value="36">36</option>
        </select>
      </div>

      <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" type="submit" name="submit">Maak Puzzel</button>
    </form>
  </div>
</body>
</html>