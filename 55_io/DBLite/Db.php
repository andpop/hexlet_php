<?php
namespace Db;

class NotFoundException extends \Exception
{

}

class Db
{
    private const KEY_LENGTH = 8;
    private const VALUE_LENGTH = 100;

    private $file;

    public function __construct($filePath)
    {
        $this->file = $filePath;
        if (!file_exists($filePath)) {
            $handle = fopen($filePath, 'ab');
            fclose($handle);
        }
    }

    private function fitStringToSize($s, $size)
    {
        if (strlen($s) > $size) {
            return substr($s, 0, $size);
        } else {
            return str_pad($s, $size);
        }
    }

    private function setRecord($key, $value)
    {
        return $this->fitStringToSize($key, self::KEY_LENGTH) . $this->fitStringToSize($value, self::VALUE_LENGTH);
    }

    private function append($key, $value)
    {
        $handle = fopen($this->file, 'a+b');
        fwrite($handle, $this->setRecord($key, $value));
        fclose($handle);
    }

    private function update($recordNumber, $key, $value)
    {
        $handle = fopen($this->file, 'cb');
        $recordSize = self::KEY_LENGTH + self::VALUE_LENGTH;
        fseek($handle, ($recordNumber - 1) * $recordSize);
        fwrite($handle, $this->setRecord($key, $value));
        fclose($handle);
    }

    private function find($key)
    {
        $handle = fopen($this->file, 'rb');
        try {
            $recordNumber = 0;
            $recordSize = self::KEY_LENGTH + self::VALUE_LENGTH;
            while (!feof($handle)) {
                $record = fread($handle, $recordSize);
                if (strlen($record) !== $recordSize) {
                    break;
                }

                $recordNumber++;
                $currentKey = rtrim(substr($record, 0, self::KEY_LENGTH));
                $value = rtrim(substr($record, self::KEY_LENGTH));
                if ($currentKey === $key) {
                    return [
                        'recordNumber' => $recordNumber,
                        'key' => $key,
                        'value' => $value
                    ];
                }
            }
        } finally {
            fclose($handle);
        }

        return [
            'recordNumber' => -1,
            'key' => $key,
            'value' => null
        ];
    }

    public function set($key, $value)
    {
        $recordInfo = $this->find($key);
        if ($recordInfo['recordNumber'] < 0) {
            $this->append($key, $value);
        } else {
            $this->update($recordInfo['recordNumber'], $key, $value);
        }
    }
    
    public function get($key)
    {
        $recordInfo = $this->find($key);
        if ($recordInfo['recordNumber'] > 0) {
            return $recordInfo['value'];
        } else {
            throw new NotFoundException("{$key} not found");
        }
    }
}

$db = new Db('klop.db');
$db->set('popov', 'super new value');
try {
    echo $db->get('popov1');
} catch (\Db\NotFoundException $e) {
    echo $e->getMessage() . PHP_EOL;
}
