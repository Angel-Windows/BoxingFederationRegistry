<form action="{{route('ajax.search-in-class')}}" style="min-width: 779px " method="post" class="modal_form modal-search-form">
    <input type="hidden" name="class_types" value="3">
    <h3 class=" d-flex space-between">
        <p>Сім`я</p>
        <div class="button m-0">
            <img src="{{asset('img/icon/save.svg')}}" alt="">
            <span>Зберегти</span>
        </div>
    </h3>
    <div class="table">
        <label class="label fool type__text act">
            <span class="unselectable">ПІП</span>
            <input class="input" placeholder="ПІП">
        </label>
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
