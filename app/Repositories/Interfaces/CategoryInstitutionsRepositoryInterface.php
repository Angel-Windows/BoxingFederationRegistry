<?php
namespace App\Repositories\Interfaces;
interface CategoryInstitutionsRepositoryInterface
{


    public function edit($id, $request, $type);

    public function get_data($data, $db_name);
}
