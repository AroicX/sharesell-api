<?php

namespace App\Repositories;

interface ProfileRepositoryInterface
{
    public function show();

    public  function update($id,$data);

    public  function destroy($id);
}
