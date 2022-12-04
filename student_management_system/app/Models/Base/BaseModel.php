<?php

namespace App\Models\Base;

use App\Builders\Base\EloquentBuilder;
use App\Collections\Base\EloquentCollection;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @method static EloquentBuilder query()
 * @method static EloquentBuilder updateOrCreate(array $fillable)
 * @method static EloquentBuilder firstOrCreate(array $search, array $fillable)
 */
abstract class BaseModel extends Model
{
    protected function serializeDate(DateTimeInterface $date): string {
        return $date->format('Y-m-d H:i:s');
    }

    public function newCollection(array $models = []) {
        $collectionClass = str_replace('Models','Collections',get_called_class()).'Collection';
        if (class_exists($collectionClass)) return new $collectionClass($models);
        return new EloquentCollection($models);
    }

    public function newEloquentBuilder($query) {
        $buildersClass = str_replace('Models','Builders',get_called_class()).'Builder';
        if (class_exists($buildersClass)) return new $buildersClass($query);
        return new EloquentBuilder($query);
    }
    public function log(){
        loggerWithContext(
            (debug_backtrace()[1]['class'] ?? 'UnKnownClass')
            .'::'.(debug_backtrace()[1]['function'] ?? 'function')
            .':'.(debug_backtrace()[0]['line'] ?? 'unknown').' '.
            ltrim(get_class($this), 'App\Models\\')
            .'::'.$this->id, $this->toArray());
    }
    public function clone() {
        return clone $this;
    }
}
