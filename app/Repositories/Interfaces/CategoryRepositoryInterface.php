<?php
namespace App\Repositories\Interfaces;
interface CategoryRepositoryInterface
{
    public function edit($id, $request, $type);
    public function get_data(array $data);
}
