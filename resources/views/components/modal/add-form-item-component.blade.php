<form action="{{route('ajax.search-in-class')}}" method="post" class="modal_form modal-search-form">
    <input type="hidden" name="class_types" value="3">
    <h3 class=" d-flex space-between">
        <p>Додати тренера</p>
        <div class="button m-0">
            <img src="{{asset('img/icon/save.svg')}}" alt="">
            <span>Зберегти</span>
        </div>
    </h3>
    <div class="table">
        @include('components.forms.custom-select',
                                         [
                                             'class_name'=> 'ff',
                                             'placeholder'=>'fasdf',
                                             'value'=>'f',
                                             'name'=>'adfasdf',
                                             'option'=>[1=>'fsfdafasdfasfgvsflkcbmnsnfopiq']
                                         ])
        <label class="label type__text act">
            <span class="unselectable">Роль</span>
            <input class="input" placeholder="ПІП">
        </label>
    </div>
</form>
