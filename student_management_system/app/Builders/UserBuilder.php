<?php


namespace App\Builders;


use App\Builders\Base\EloquentBuilder;
use App\Collections\UserCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserBuilder
 * @package App\Builders
 *
 * @method User[]|UserCollection get($columns = ['*'])
 * @method User first($columns = ['*'])
 */
class UserBuilder extends EloquentBuilder
{
    protected $toDropDownColumns = ['users.id','name'];

    protected function onRetrievingForDropDown(){
        return $this;
    }
//    public function toDropDown(array $attributes = null): array {
//        $this->onRetrievingForDropDown();
//        $this->orderBy($this->dropDownOrderBy);
//        $columns = isset($attributes) ? array_merge($this->toDropDownColumns, $attributes) : $this->toDropDownColumns;
////        $models = $this->getModels($columns);
////        return $this->getModel()->newCollection($models)->toArray();
//        return $this->get($columns)->toArray();
//    }
}
