<form id="modal_write_phone" action="{{route('auth.login')}}" method="post" >
    @csrf
    <h2>Авторизація</h2>
    <label>
        <input type="text" name="phone" placeholder="Номер телефону">
    </label>

</form>
<button class="button" onclick="functionsArray['ajax_postFormFind']('modal_write_phone', 'modal_write_phone')">Отримати код з смс</button>
