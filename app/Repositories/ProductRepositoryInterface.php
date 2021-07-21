<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index();
    public function create(Request $request);
    public function update(Request $request);
    public function delete($id);
}
