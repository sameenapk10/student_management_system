<?php


namespace App\Builders\Base;


use App\Collections\Base\EloquentCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * @method EloquentCollection get($columns = ['*'])
 */
class EloquentBuilder extends Builder
{
    protected $toDropDownColumns = ['id','name'];

    protected $dropDownOrderBy = 'name';

    protected function onRetrievingForDropDown(){}

    public function toDropDown(array $attributes = null): array {
        $this->onRetrievingForDropDown();
        $this->orderBy($this->dropDownOrderBy);
        $columns = isset($attributes) ? array_merge($this->toDropDownColumns, $attributes) : $this->toDropDownColumns;
//        $models = $this->getModels($columns);
//        return $this->getModel()->newCollection($models)->toArray();
        return $this->get($columns)->toArray();
    }

    public function createdAt($date = null){
        return $this->whereDate('created_at', $date ?? now());
    }
    public function modelClass(): string {
        return get_class($this->getModel());
    }
}
