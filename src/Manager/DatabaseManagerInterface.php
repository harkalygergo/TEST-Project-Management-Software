<?php

namespace App\Manager;

interface DatabaseManagerInterface
{
    public function insert(string $table, array $data);

    public function update(string $table, array $data, string $where);
}
