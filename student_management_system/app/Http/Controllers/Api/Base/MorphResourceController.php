<?php


namespace App\Http\Controllers\Api\Base;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class MorphResourceController extends ResourceController
{

    public function index(Request $request) {
        $this->builder = $this->getBuilderFromParent($this->getParentModel($request));
        $this->commonIndexFilter();
        return $this->builder->get();
    }

    protected function getParentModel(Request $request): Model{
        $class = 'App\\Models\\' . $request->parent_type;
        return $class::find($request->parent_id);
    }
    protected function commonIndexFilter(){
        if ($this->request->hasHeader('type'))
            $this->builder->where('type', $this->request->header('type'));
        if ($this->request->hasHeader('department'))
            $this->builder->where('department_id', $this->request->header('department'));
    }
    protected function mergeHeadersToRequest(){
        if ($this->request->hasHeader('type')) $this->request->merge(['type' => $this->request->header('type')]);
        if ($this->request->hasHeader('department')) $this->request->merge(['department_id' => $this->request->header('department')]);
    }
    protected $commonValidationRules = [
        'id' => 'nullable|numeric',
        'parent_id' => 'nullable|numeric',
        'parent_type' => 'nullable|string',
    ];

    public function store(Request $request) {
        $this->mergeHeadersToRequest();
        $request->validate(array_merge($this->commonValidationRules,$this->additionalValidationRules));
        $component = $this->getBuilder()->findOrNew($request->id);
        $component->fill($request->all());
        $this->onStoring($component);
        $component->save();
        $parent = $component->parent;
        $this->builder = $this->getBuilderFromParent($parent);
        $this->commonIndexFilter();
        $this->onStored($component);
        return $this->builder->get();
    }
    protected function onStored(?Model $component){ }
    protected function onStoring(?Model $component){ }
}
