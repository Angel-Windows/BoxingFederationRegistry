<form id="modal_write_phone_code" action="{{route('auth.send_code')}}" method="post">
    @csrf
    <h2>Код з смс</h2>
    @if($code)
        <p class="test_code hidden">Ваш код: <span>{{$code}}</span></p>
    @endif
    <label>
        <input type="text" name="code" placeholder="Введіть код">
    </label>
</form>
<button class="button"
        onclick="functionsArray['ajax_postFormFind']('modal_write_phone_code', 'modal_write_phone_code')">Вхід
</button>
