<h2>{{$get['more_data']['register_name'] ?? ''}}</h2>
<x-forms-category-register-form-component :class="$class_name" :get="$get" :typesubmit="$type_submit">
    <div class="upload_img" id="imageButton">
        <div class="drop">Відпустити тут</div>
        <div class="img">
            <input type="image" src="" alt="" name="image">
        </div>

        <div class="buttons">
            <div class="selfie_upload_buttons no-display">
                <button type="button" id="selfie_image_button" class="button one white">Сфотографувати</button>
                <button type="button" id="selfie_image_button_change" class="button one white">Змінити камеру</button>
                <button type="button" id="selfie_image_button_cancel" class="button one white">Відмінити</button>
            </div>
            <div class="default_upload_buttons">
                <button type="button" onclick="selfie_image()" class="button one white">Зробити фото</button>
                <button type="button" class="button one button_open_file">Загрузити фотографію</button>
            </div>

            <input type="file" name="photo" style="display:none;" id="file-input">
        </div>
    </div>
</x-forms-category-register-form-component>

