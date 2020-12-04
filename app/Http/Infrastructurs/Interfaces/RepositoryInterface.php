<?php

namespace App\Http\Infrastructurs\Interfaces;

interface RepositoryInterface
{
    public function findAll($limit = null);

    public function findById($id);

    public function create($data);

    public function update($data,$id);

    public function delete($id);
}
