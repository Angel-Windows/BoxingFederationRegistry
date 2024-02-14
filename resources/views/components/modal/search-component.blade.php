<form action="{{route('ajax.search-in-class')}}" method="post" class="modal_form modal-search-form">
    @csrf
    <input type="hidden" name="class_types" value="{{$class_types->id}}">
    <h2>Пошук {{$class_types->genitive}}</h2>
    <label>
        <input type="text" name="search_value" placeholder="ПІБ" id="search_input">
    </label>
    <ul id="search_result_list" class="result-list">

    </ul>
</form>

