<?php

namespace App\Traits;

use App\Models\Category\CategorySchool;
use App\Models\Category\CategorySportsInstitutions;
use App\Models\Category\CategorySportsman;
use App\Models\Category\CategoryTrainer;
use App\Models\Class\BoxFederation;
use App\Models\Employees\EmployeesFederation;
use App\Models\Employees\EmployeesMedical;
use App\Models\Linking\LinkingMembers;
use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\CategoryFunZonesRepository;
use App\Repositories\Category\CategoryInstitutionsRepository;
use App\Repositories\Category\CategoryJudgeRepository;
use App\Repositories\Category\CategorySportsInstitutionsRepository;
use App\Repositories\Category\CategoryTrainerRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use App\Repositories\Employees\EmployeesFederationRepository;
use App\Repositories\Employees\EmployeesInsurancesRepository;
use App\Repositories\Employees\EmployeesMedicalRepository;
use App\Repositories\Employees\EmployeesSchoolRepository;
use App\Repositories\Employees\EmployeesSportsInstitutionsRepository;
use Faker\Factory;

trait CategoryUITrait
{
    use DataTypeTrait;

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


    public function getDefaultValue(&$new_data, $category_data, $name_type = ''): void
    {
        $this->GetValueInputs($category_data->phone, 'phone', $new_data, true);
        $this->GetValueInputs($category_data->email, 'email', $new_data, true);
        if ($name_type === 'fool') {
            $name = explode(' ', $category_data->name ?? '');
            $new_data['last_name']['value'] = $name[0] ?? '';
            $new_data['first_name']['value'] = $name[1] ?? '';
            $new_data['surname']['value'] = $name[2] ?? '';
        } else {
            $new_data['name']['value'] = $category_data->name ?? '';
        }

        $address = json_decode($category_data->address ?? "");
        $fool_address = '';
        if (isset($address->city)) {
            $fool_address .= 'м. ' . $this->city_arr[$address->city];
            $this->GetValueInputs($address->city, 'city', $new_data, true);
        }
        if (isset($address->street)) {
            $fool_address .= ', ' . $address->street;
//            $new_data['street']['value'] = $address->street;
            $this->GetValueInputs($address->street, 'street', $new_data, true);

        }
        if (isset($address->house_number)) {
            $fool_address .= ' ' . $address->house_number;
//            $new_data['house_number']['value'] = $address->house_number;
            $this->GetValueInputs($address->house_number, 'house_number', $new_data, true);
        }
        if (isset($address->apartment_number)) {
            $fool_address .= ', кв. ' . $address->apartment_number;
            $new_data['apartment_number']['value'] = $address->apartment_number;
        }
//        $new_data['address']['value'] = $fool_address;
//        $new_data['address']['value'] = $fool_address;
        $this->GetValueInputs($fool_address, 'address', $new_data, true);
    }


    public function set_month($date): string
    {
        $date_split = explode('-', $date);
        $month_index = (int)$date_split[1] - 1;
        $year = $date_split[0];

        return $this->monthsUkrainian[$month_index] . ' ' . $year;
    }

    public static function validate_category($request, $table_model, $id = null): mixed
    {

        if ($id) {
            $category = $table_model::find($id);
        } else {
            $category = new $table_model();
        }

        $error = [];

        if (array_key_exists('logo', $category->getAttributes())) {
            $img_patch = self::upload_img($request);
            if ($img_patch['errors']) {
                $error['logo'][] = $img_patch['errors'];

            } else {
                $category->logo = $img_patch['patch'];
            }

        }

        if ($request->has('name')) {
            $category->name = $request->input('name');
        } else {
            $category->name = $request->input('last_name') . ' ' . $request->input('first_name') . ' ' . $request->input('surname');
        }
        if ($request->has('street')){
            $category->address =
                json_encode([
                    'city' => $request->input('city'),
                    'street' => $request->input('street'),
                    'house_number' => $request->input('house_number'),
                    'apartment_number' => $request->input('apartment_number'),
                ]);
        }

        $category->phone = $request->input('phone') ?? '';
        $category->email = $request->input('email');

        return $category;
    }

    public static function upload_img($request): array
    {
        $photo = $request->file('photo');

        if (!$photo) {
            return [
                'errors' => true,
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


    public function get_data($class_name, $data = [], $request = null): \Illuminate\Http\Response|array
    {
        switch ($class_name) {
            case 'category_sportsmen':
                $data_info = (new SportsmanFederationRepository())->get_data($data, $request);
                break;


            case 'category_fun_zones':
                $data_info = (new CategoryFunZonesRepository())->get_data($data, $request);
                break;

            case 'category_insurances':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'insurance');
                break;
            case 'category_medicals':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'medical');
                break;
            case 'category_schools':
                $data_info = (new CategoryInstitutionsRepository())->get_data($data, 'school');
                break;
            case 'category_sports_institutions':
                $data_info = (new CategorySportsInstitutionsRepository())->get_data($data, $request);
                break;
            case 'category_judges':
                $data_info = (new CategoryJudgeRepository())->get_data($data, $request);
                break;
            case 'box_federations':
                $data_info = (new CategoryFederationRepository())->get_data($data, $request);
                break;
            case 'category_trainers':
                $data_info = (new CategoryTrainerRepository())->get_data($data, $request);
                break;




            case 'employees_school':
                $data_info = (new EmployeesSchoolRepository())->get_data($data, $request);
                break;
            case 'employees_medical':
                $data_info = (new EmployeesMedicalRepository())->get_data($data, $request);
                break;
            case 'employees_federation':
                $data_info = (new EmployeesFederationRepository())->get_data($data, $request);
                break;
            case 'employees_sports_institution':
                $data_info = (new EmployeesSportsInstitutionsRepository())->get_data($data, $request);
                break;
            case 'employees_insurances':
                $data_info = (new EmployeesInsurancesRepository())->get_data($data, $request);
                break;

            case 'category_stores':
                return response()->view('errors.404', [], 404);
            default :
                return response()->view('errors.404', [], 405);
        }
        return $data_info;
    }

    public function GetValueInputs($value, $key, &$data, $is_set = true): string
    {
        $dataKey = $data[$key] ?? null;
        if (!$dataKey) {
            return '';
        }

        switch ($key) {
            case "federation":
                $result = BoxFederation::find($value)->name ?? '';
                break;
            case "trainer":
                $result = CategoryTrainer::find($value)->name ?? '';
                break;
            case 'school':
                $result = CategorySchool::find($value)->name ?? '';
                break;
            case 'sports_institutions':
                $result = CategorySportsInstitutions::find($value)->name ?? '';
                break;


            default:
                switch ($dataKey['tag']) {
                    case 'select-box':
                        $result = $dataKey['option'][$value] ?? '';
                        break;
                    case 'input':
                    case 'foreign_passport':

                    case 'passport':
                    case 'custom-select':
                        $result = $value ?? '';
                        break;

                    default :
                        $result = '';
                }
        }

        if ($is_set) {

            switch ($dataKey['tag']) {
                case 'select-box':
                case 'custom-select':
                    $data[$key]['value'] = $value;
                    break;
                case 'input':
                    $data[$key]['value'] = $result;
                    break;
                case 'foreign_passport':
                case 'passport':
                    $pass = json_decode($result, true);
                    $data[$key]['text'] = strtoupper($pass['seria'] ?? '' ). ($pass['number'] ?? '');
                    $data[$key]['value'] = strtoupper($pass['seria'] ?? '' ). ($pass['number'] ?? '');
                    $data[$key]['name_seria'] = strtoupper($pass['seria'] ?? '');
                    $data[$key]['name_number'] = $pass['number'] ?? '';

                    break;
            }
            $data[$key]['text'] = $result;
        }

        return $result;
    }
}
