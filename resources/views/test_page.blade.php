<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Photo</title>
</head>
<body>
<h1>Сделайте фото с камеры</h1>
<button id="take-photo">Сделать фото</button>
<button id="switch-camera">Сменить камеру</button>
<form action="{{route('page.test')}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" id="file-input" name="photo" accept="image/*">
    <button type="submit">Simbit</button>
</form>

<div id="photo-container"></div>

<button onclick="selfie_image()">openSelfie</button>


@vite('resources/js/function_interface.js')
</body>
</html>
