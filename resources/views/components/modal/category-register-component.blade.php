<x-forms.category-register-form-component :class="$category" :route="'register_category'" enctype="multipart/form-data" method="post">
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
    <div class="right">
        <button class="button">Перейти до оплати</button>
        <label style="display: block">
            <input style="display: inline-block" type="checkbox">
            <span>Приймаю всі <a href="">умови користування</a> і також <a href="">політику конфіденційності</a></span>
        </label>
    </div>

</x-forms.category-register-form-component>

