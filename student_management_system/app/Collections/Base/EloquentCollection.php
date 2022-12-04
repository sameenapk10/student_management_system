<?php

namespace App\Collections\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EloquentCollection extends Collection
{
    /**
     * @var bool
     */
    private $dotted = false;
    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var bool
     */
    private $formatted = false;


    public function format(): self {
        $this->items = $this->map(function ($item, $key){
            if ($item instanceof Model) $data = $item->toArray();

            // apply dot
            if ($this->dotted) $data = Arr::dot($data);
            if (empty($this->fields)) return $data;

            // prepare field names
            $fieldNames = [];
            $fieldsArray = [];
            foreach ($this->fields as $field) {
                $split = explode(' as ', $field);
                if (Str::of($split[0])->contains('extra.') && !isset($split[1])) $split[1] = ''.Str::of($split[0])->after('extra.')->toHtmlString();
                $fieldsArray[] = $split;
                $fieldNames[] = $split[0];
            }

            // format data
            $data =  Arr::only($data, $fieldNames);
            $tempData = [];
            foreach ($fieldsArray as $field)
                $tempData[$field[1] ?? $field[0]] = $data[$field[0]] ?? null;
            $data = $tempData;
            unset($tempData);

            return $data;
        })->all();
        $this->formatted = true;
        return $this;
    }
    public function formatted(): array {
        if (!$this->formatted) $this->format();
        return $this->all();
    }
}
