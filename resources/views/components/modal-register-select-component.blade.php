    <div class="text">
        <h2>Реєстрація</h2>
        <p>Шановні колеги! Повідомляємо, що технічна та адміністративна підтримка однієї зареєстрованої особи в системі
            становить 100 гривень за один календарний рік.</p>
        @foreach($buttons as $key=>$button)
            <div
                onclick="functionsArray['open_modal']('category-register', {'category': '{{$key}}'})"
                class="button"
            >{{$button}}
            </div>
        @endforeach
    </div>
