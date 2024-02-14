@php
    $placeholder = '';
    switch ($class_types->link){
        case 'category_judges':
        case 'category_trainers':
        case 'category_sportsmen':
            $placeholder = 'Введіть ПІБ ' . $class_types->genitive;
            break;
        default:
            $placeholder = 'Введіть назву ' . $class_types->genitive;
    }
@endphp
<form action="{{route('ajax.search-in-class')}}" method="post" class="modal_form modal-search-form">
    @csrf
    <input type="hidden" name="class_types" value="{{$class_types->id}}">
    <h2>Пошук {{$class_types->genitive}}</h2>
    <label>
        <input type="text" name="search_value" placeholder="{{$placeholder}}" id="search_input">
    </label>
    <ul id="search_result_list" class="result-list">

    </ul>
</form>

