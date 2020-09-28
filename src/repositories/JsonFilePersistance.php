<?php declare(strict_types=1);

namespace Bogatyrev\repositories;

class JsonFilePersistance implements PersistanceInterface
{
    protected $filePath;

    protected $data;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function persist(array $data)
    {
        if ($this->data === null) {
            $this->parseFile();
        }

        $this->data[] = $data;
        \file_put_contents($this->filePath, $this->data);
    }

    public function find()
    {
        if ($this->data === null) {
            $this->parseFile();
        }

        return $this->data;
    }

    protected function parseFile()
    {
        $this->data = \json_decode(\file_get_contents($this->filePath), true);
    }
}
