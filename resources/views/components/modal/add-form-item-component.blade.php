<?php use App\Traits\DataTypeTrait; ?>
@php
@endphp

@switch($request->input('type_action'))
    @case('add_history')
        <form action="{{route('ajax.add_history_work')}}" style="max-width: 779px " method="post"
              class="modal_form modal-search-form"
                id="history_work_form"
            >
            @csrf
            <input required type="hidden" name="class_types" value="{{$request->input('class_types')}}">
            <input required type="hidden" name="id" value="{{$request->input('id')}}">
            <h3 class=" d-flex space-between">
                <p>Додати місце роботи</p>
                <button type="button" class="button m-0" onclick="addHistoryWork()">
                    <img src="{{asset('img/icon/save.svg')}}" alt="">
                    <span type="submit">Зберегти</span>
{{--                    <span type="submit">Зберегти</span>--}}
                </button>
            </h3>
            <div class="table">
{{--                @dd($data['employees_sports_institutions']['position'])--}}
{{--                @include('components.forms.select-box',--}}
{{--                                                [--}}
{{--                                                    'is_required' => true,--}}
{{--                                                    'class_name'=> 'fool',--}}
{{--                                                    'placeholder'=>'Посада',--}}
{{--                                                    'value'=>1,--}}
{{--                                                    'text'=>'',--}}
{{--                                                    'name'=>'position',--}}
{{--                                                    'option'=>$data['employees_sports_institutions']['position']--}}
{{--                                                ])--}}
                @include('components.forms.custom-select',
                                                [
                                                    'is_required' => true,
                                                    'class_name'=> '',
                                                    'placeholder'=>'Спортивні заклади',
                                                    'value'=>null,
                                                    'text'=>null,
                                                    'name'=>'sport_institute',
                                                    'option'=>\App\Models\Category\CategorySportsInstitutions::pluck('name', 'id')
                                                ])

                <label class="label hovered type__text act">
                    <span class="unselectable">Дата початку</span>
                    <input required name='date_start' type="date" class="input" placeholder="ПІП">
                </label>
            </div>
        </form>
        @break



    @default
        <form action="{{route('ajax.search-in-class')}}" style="max-width: 779px " method="post"
              class="modal_form modal-search-form">
            <input  type="hidden" name="class_types" value="3">
            <h3 class=" d-flex space-between">
                <p>Додати сім'ю</p>
                <div class="button m-0" onclick="functionsArray['add_family'](this)">
                    <img src="{{asset('img/icon/save.svg')}}" alt="">
                    <span>Зберегти</span>
                </div>
            </h3>
            <div class="table">
                <label class="label fool type__text act">
                    <span class="unselectable">ПІП</span>
                    <input required name="name" class="input" placeholder="ПІП">
                </label>
                @include('components.forms.select-box',
                                                 [
                                                     'class_name'=> 'status',
                                                     'placeholder'=>'Статус',
                                                     'value'=>'f',
                                                     'name'=>'status',
                                                     'option'=>['Тато', 'Мама', 'Брат', 'Сестра', 'Дідусь', 'Син', 'Дочка', 'Друг', 'Інше']
                                                 ])
                <label class="label hovered type__text act">
                    <span class="unselectable">Телефон</span>
                    <input required name="phone" class="input">
                </label>
            </div>
        </form>

@endswitch


