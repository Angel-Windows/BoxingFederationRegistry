<?php

namespace App\Traits;

use App\Models\Category\CategoryTrainer;
use App\Models\Linking\LinkingMembers;
use Faker\Factory;

trait CategoryUITrait
{
    public static function getButtons(array $arr): array
    {
        $data_phones = [];

        foreach ($arr as $key => $item_category) {
            if (isJson($item_category)) {
                try {
                    $items = json_decode($item_category, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                }
            } else {
                $items = [$item_category];
            }

            foreach ($items as $item) {
                switch ($key) {
                    case 'phones':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/phone.svg',
                            'text' => formatPhone($item),
                        ];
                        break;
                    case 'emails':
                        $data_phones[] = [
                            'link' => '',
                            'logo' => 'img/mail.svg',
                            'text' => $item,
                        ];
                        break;
                }
            }
        }
        return $data_phones;
    }

    public function getDefaultArrayData($name_type = ''): array
    {
        $return = [];
        $return = array_merge($return, [
            'address' => [
                'name' => 'address',
                'tag' => 'input',
                'placeholder' => 'Адреса проживання',
                'autocomplete' => 'street-address',
                'size' => 'fool',

            ],
            'city' => [
                'name' => 'city',
                'tag' => 'custom-select',
                'placeholder' => 'Місто',
                'size' => 'fool',
                'option' => [
                    1 => "Київ",
                    2 => "Харків",
                    3 => "Одеса",
                    4 => "Дніпро",
                    5 => "Донецьк",
                    6 => "Запоріжжя",
                    7 => "Львів",
                    8 => "Кривий Ріг",
                    9 => "Миколаїв",
                    10 => "Маріуполь",
                    11 => "Вінниця",
                    12 => "Полтава",
                    13 => "Чернігів",
                    14 => "Черкаси",
                    15 => "Житомир",
                    16 => "Суми",
                    17 => "Рівне",
                    18 => "Кам'янець-Подільський",
                    19 => "Луцьк",
                    20 => "Кременчук",
                ],
            ],
            'street' => [
                'name' => 'street',
                'tag' => 'input',
                'placeholder' => 'Вулиця/провулок/проспект',

            ],
            'house_number' => [
                'name' => 'house_number',
                'tag' => 'input',
                'placeholder' => 'Номер будинку',

            ],
            'apartment_number' => [
                'name' => 'apartment_number',
                'tag' => 'input',
                'placeholder' => 'Номер квартири',
            ],
        ]);
        if ($name_type === 'fool') {
            $return = array_merge($return, [
                'last_name' => [
                    'name' => 'last_name',
                    'tag' => 'input',
                    'placeholder' => 'Прізвище',
                ],
                'first_name' => [
                    'name' => 'first_name',
                    'tag' => 'input',
                    'placeholder' => 'Імя',
                ],
                'surname' => [
                    'name' => 'surname',
                    'tag' => 'input',
                    'placeholder' => 'По батькові',
                ],
                'phone' => [
                    'name' => 'phone',
                    'tag' => 'input',
                    'placeholder' => 'Номер телефону',
                    'logo' => 'img/phone.svg'
                ],
                'email' => [
                    'name' => 'email',
                    'tag' => 'input',
                    'placeholder' => 'E-mail',
                    'logo' => 'img/mail.svg'
                ],
            ]);
        } else {
            $return = array_merge($return, [
                'name' => [
                    'name' => 'name',
                    'tag' => 'input',
                    'placeholder' => 'Назва закладу',
                ],
                'phone' => [
                    'name' => 'phone',
                    'tag' => 'input',
                    'placeholder' => 'Номер телефону',
                    'logo' => 'img/phone.svg'
                ],
                'email' => [
                    'name' => 'email',
                    'tag' => 'input',
                    'placeholder' => 'E-mail',
                    'logo' => 'img/mail.svg'
                ],
            ]);

        }

        return $return;
    }

    public function getDefaultValue(&$new_data, $category_data, $name_type = ''): void
    {
        $new_data['phone']['value'] = $category_data->phone ?? "";
        $new_data['email']['value'] = $category_data->email ?? "";

        if ($name_type === 'fool') {
            $name = explode(' ', $category_data->name ?? '');
            $new_data['first_name']['value'] = $name[0] ?? '';
            $new_data['last_name']['value'] = $name[1] ?? '';
            $new_data['surname']['value'] = $name[2] ?? '';
        } else {
            $new_data['name']['value'] = $category_data->name ?? '';
        }

        $address = json_decode($category_data->address ?? "");
        $fool_address = '';
        if (isset($address->city)) {
            $fool_address .= 'м. ' . $address->city;
            $new_data['city']['value'] = $address->city;
        }
        if (isset($address->street)) {
            $fool_address .= ', ' . $address->street;
            $new_data['street']['value'] = $address->street;
        }
        if (isset($address->house_number)) {
            $fool_address .= ' ' . $address->house_number;
            $new_data['house_number']['value'] = $address->house_number;
        }
        if (isset($address->apartment_number)) {
            $fool_address .= ', кв. ' . $address->apartment_number;
            $new_data['apartment_number']['value'] = $address->apartment_number;
        }
        $new_data['address']['value'] = $fool_address;

    }

    public array $monthsUkrainian = [
        'Січень',
        'Лютий',
        'Березень',
        'Квітень',
        'Травень',
        'Червень',
        'Липень',
        'Серпень',
        'Вересень',
        'Жовтень',
        'Листопад',
        'Грудень'
    ];

    public function set_month($date): string
    {
        $date_split = explode('-', $date);
        $month_index = (int)$date_split[1] - 1;
        $year = $date_split[0];

        return $this->monthsUkrainian[$month_index] . ' ' . $year;
    }

    public static function validate_category($request, $table_model, $type, $id): mixed
    {
        if ($type === 'edit') {
            $category = $table_model::find($id);
        } else {
            $category = new $table_model();
        }

        $error = [];

        if (array_key_exists('logo', $category->getAttributes())){
            $img_patch = self::upload_img($request);
            if ($img_patch['errors']) {
                $error['logo'][] = $img_patch['errors'];
            }
            $category->logo = $img_patch['patch'];
        }

        if ($request->has('name')){
            $category->name = $request->input('name');
        }else{
            $category->name = $request->input('first_name') . ' ' . $request->input('last_name') . ' ' . $request->input('surname');
        }

        $category->address =
            json_encode([
                'city' => $request->input('city'),
                'street' => $request->input('street'),
                'house_number' => $request->input('house_number'),
                'apartment_number' => $request->input('apartment_number'),
            ]);
        $category->phone = $request->input('phone') ?? '';
        $category->email = $request->input('email');

        return $category;
    }

    public static function upload_img($request): array
    {
        $photo = $request->file('photo');

        if (!$photo) {
            return [
                'errors' => false,
                'patch' => null,
            ];
        }

        $validator = \Validator::make(['photo' => $photo], [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
        ]);

        if ($validator->fails()) {
            return [
                'errors' => $validator->errors()->all(),
                'patch' => "",
            ];
        }

        return [
            'errors' => false,
            'patch' => $photo->store('photos'),
        ];
    }

    public static function convertAddressToJSON($city, $street, $house_number, $apartment_number): bool|string
    {
        return json_encode([
            'city' => $city,
            'street' => $street,
            'house_number' => $house_number,
            'apartment_number' => $apartment_number,

        ]);
    }

    public static function convertAddressRequest($request): bool|string
    {
        return self::convertAddressToJSON(
            $request->input('city') ?? '',
            $request->input('street') ?? '',
            $request->input('house_number') ?? '',
            $request->input('apartment_number') ?? '',

        );
    }

    public static function DismissMembers($request, $category_id, $category_type): void
    {
        $now = now()->toDateString();
        $members = LinkingMembers::whereNull('date_end_at')
            ->where('category_id', $category_id)
            ->where('category_type', $category_type)
            ->pluck('member_id')
            ->toArray();

        $dismissedMembers = $request ? array_diff($members, $request) : $members;

        if (!empty($dismissedMembers)) {
            LinkingMembers::whereIn('member_id', $dismissedMembers)
                ->update(['date_end_at' => $now]);
        }

        if ($request) {
            $newMembers = array_diff($request, $members);
            $newMembersArr = [];

            foreach ($newMembers as $member) {
                $newMembersArr[] = [
                    'category_id' => $category_id,
                    'category_type' => $category_type,
                    'member_id' => $member,
                    'member_type' => 1,
                    'type' => 1,
                    'role' => Factory::create()->jobTitle,
                    'date_start_at' => $now,
                    'date_end_at' => null,
                ];
            }

            LinkingMembers::insert($newMembersArr);
        }

        dump($members, $request, $newMembers ?? '', $dismissedMembers, $newMembersArr ?? '');
    }

}
