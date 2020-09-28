<?php declare(strict_types=1);

namespace Bogatyrev\repositories;

interface PersistanceInterface
{
    public function persist(array $data);

    public function find();
}
