<h2>Реєстрація федерації</h2>
<x-forms-category-register-form-component :class="$class_name"  :get="$get">
    <div class="upload_img" id="imageButton">
        <div class="drop">Відпустити тут</div>
        <div class="img">
            <input type="image" src="" alt="" name="image">
        </div>

        <div class="buttons">
            <button class="button one white">Зробити фото</button>
            <button type="button" class="button one button_open_file">Загрузити фотографію</button>
            <input type="file" name="photo" style="display:none;">
        </div>
    </div>
</x-forms-category-register-form-component>

