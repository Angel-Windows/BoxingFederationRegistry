<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка изображения в Laravel</title>

</head>
<body>
<div class="container">
    <input type="file" id="fileInput" accept="image/*">
    <input type="image" id="imageButton" src="#" alt="Выбрать изображение">
    <div id="dragText">Перетащите сюда</div>
</div>


<style>
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        position: relative;
    }

    #dragText {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 18px;
        color: #000;
    }


</style>
<script>
    const imageButton = document.getElementById('imageButton');
    const dragText = document.getElementById('dragText');

    imageButton.addEventListener('dragover', function(event) {
        event.preventDefault();
        dragText.style.display = 'block';
    });

    imageButton.addEventListener('dragleave', function(event) {
        event.preventDefault();
        dragText.style.display = 'none';
    });

    imageButton.addEventListener('drop', function(event) {
        event.preventDefault();
        dragText.style.display = 'none';

        const file = event.dataTransfer.files[0];

        if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imageButton.src = event.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            alert('Пожалуйста, перетащите изображение');
        }
    });

</script>
{{--<script>--}}
{{--    // Обработчик отправки формы через AJAX--}}
{{--    document.getElementById('uploadForm').addEventListener('submit', function(event) {--}}
{{--        event.preventDefault(); // Предотвращаем стандартное поведение формы--}}

{{--        const formData = new FormData(this);--}}

{{--        // Отправляем данные через AJAX--}}
{{--        fetch('{{route('ajax.upload-img')}}', {--}}
{{--            method: 'POST',--}}
{{--            body: formData--}}
{{--        })--}}
{{--            // .then(response => response.json())--}}
{{--            .then(data => {--}}
{{--                document.getElementById('message').innerText = data.message; // Выводим сообщение об успешной загрузке--}}
{{--            })--}}
{{--            .catch(error => {--}}
{{--                console.error('Ошибка:', error);--}}
{{--            });--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>
