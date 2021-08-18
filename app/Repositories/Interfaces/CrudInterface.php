<?php


namespace App\Repositories\Interfaces;


interface CrudInterface
{
    public function create($request);

    public function find($id);

    public function update($id, $request);

    public function delete($id);
}
