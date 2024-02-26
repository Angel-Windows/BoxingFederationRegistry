@php
    $placeholder = '';
    switch ($class_types->link){
        case 'category_judges':
        case 'category_trainers':
        case 'category_sportsmen':
            $placeholder = 'Введіть ПІБ ' . $class_types->dative;
            break;
        default:
            $placeholder = 'Введіть назву ' . 'закладу';
//            $placeholder = 'Введіть назву ' . $class_types->dative;
    }
@endphp
<form action="{{route('ajax.search-in-class')}}" method="post" class="modal_form modal-search-form" onsubmit="return false">
    @csrf
    <input type="hidden" name="class_types" value="{{$class_types->id}}">
    <h2>Пошук {{$class_types->dative}}</h2>
    <label>
        <input type="text" name="search_value" placeholder="{{$placeholder}}" id="search_input">
    </label>
    <ul id="search_result_list" class="result-list">

    </ul>
</form>

