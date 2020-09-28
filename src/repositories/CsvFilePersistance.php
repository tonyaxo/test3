<?php declare(strict_types=1);

namespace Bogatyrev\repositories;

use SplFileObject;

class CsvFilePersistance implements PersistanceInterface
{
    protected $filePath;

    protected $data;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function persist(array $data)
    {
        $file = new SplFileObject($this->filePath);
        $fields = [];
        $fields[] = $data['text'];
        $fields[] = $data['createdAt'];

        foreach ($data['choices'] as $choice) {
            $fields[] = $data['text'];
        }
        
        $file->fputcsv($fields);
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
        $file = new SplFileObject($this->filePath);
        $file->setFlags(SplFileObject::READ_CSV);
        foreach ($file as $row) {
            $result = [];
            $result['text'] = $row[0];
            $result['createdAt'] = $row[1];
            unset($row[0], $row[1]);
            $result['choices'] = [];

            foreach ($row as $choice) {
                $result['choices'] = ['text' => $choice];
            }

            $this->data = $result;
        }
    }
}
