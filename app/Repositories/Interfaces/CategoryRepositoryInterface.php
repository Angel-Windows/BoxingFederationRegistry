<?php
namespace App\Repositories\Interfaces;
interface CategoryRepositoryInterface
{

    public function index($id);
    public function edit_page($id);
    public function edit($id, $request);


}
