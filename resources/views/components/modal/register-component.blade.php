<form id="modal_write_phone" action="{{route('auth.login')}}" method="post" onsubmit="submit_form(event, 'modal_write_phone')">
    @csrf
    <h2>Авторизація</h2>
    <p class="err no-display">Потрібно ввести номер телефона повністю</p>
    <label>
        <input minlength="20" type="text" required name="phone" inputmode="text" placeholder="Номер телефону">
    </label>
    <button type="submit" class="button">Отримати код з смс</button>

</form>

