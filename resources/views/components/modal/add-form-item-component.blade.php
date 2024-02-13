<?php use App\Traits\DataTypeTrait; ?>
@php
@endphp

@switch($request->input('type_action'))
    @case('add_history')
        <form action="{{route('ajax.add_history_work')}}" style="min-width: 779px " method="post"
              class="modal_form modal-search-form">
            @csrf
            <input type="hidden" name="class_types" value="{{$request->input('class_types')}}">
            <input type="hidden" name="id" value="{{$request->input('id')}}">
            <h3 class=" d-flex space-between">
                <p>Додати місце роботи</p>
                <button class="button m-0">
                    <img src="{{asset('img/icon/save.svg')}}" alt="">
                    <span type="submit">Зберегти</span>
                </button>
            </h3>
            <div class="table">
                @include('components.forms.select-box',
                                                [
                                                    'class_name'=> 'fool',
                                                    'placeholder'=>'Посада',
                                                    'value'=>1,
                                                    'text'=>'',
                                                    'name'=>'position',
                                                    'option'=>$data['employees_sports_institutions']['position']
                                                ])
                @include('components.forms.custom-select',
                                                [
                                                    'class_name'=> '',
                                                    'placeholder'=>'Спортивні заклади',
                                                    'value'=>null,
                                                    'text'=>null,
                                                    'name'=>'sport_institute',
                                                    'option'=>\App\Models\Category\CategorySportsInstitutions::pluck('name', 'id')
                                                ])

                <label class="label type__text act">
                    <span class="unselectable">Дата початку</span>
                    <input name='date_start' type="date" class="input" placeholder="ПІП">
                </label>
            </div>
        </form>
        @break
    @default
        <form action="{{route('ajax.search-in-class')}}" style="min-width: 779px " method="post"
              class="modal_form modal-search-form">
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

@endswitch


