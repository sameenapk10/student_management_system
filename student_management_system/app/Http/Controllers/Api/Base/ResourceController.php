<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ResourceController
 * @package App\Http\Controllers\Api\Base
 *
 * @property string type
 */
class ResourceController extends Controller
{
    protected $className;

    protected $modelName;

    protected $builder;

    protected $request;

    protected $with;

    protected $load;

    public function __construct(Request $request){
        $this->request = $request;
        $this->className = $this->getModelsClass();
        $this->builder = $this->getBuilder();
    }

    public function index(Request $request) {
        if ($request->hasHeader('Type'))
            $this->builder->where('type', $this->request->header('Type'));
        $this->indexFilter($request);
        $this->onIndexing();
        if ($this->with) $this->builder->with($this->with);
        return $this->indexResponse();
    }
    protected function indexFilter(Request $request){ }
    protected function onIndexing(){ }
    protected function indexResponse(){ return $this->builder->get(); }

    public function getInitData(Request $request){
        return ['ResourceController'];
    }

    public function store(Request $request) {
        if ($request->hasHeader('Type'))
            $this->request->merge(['type' => $request->header('Type')]);
        $this->storing();
        $this->validateRequest($this->request);
        $object = $this->query()->findOrNew($this->request->id);
        $object->fill($this->request->all());
        if ($this->request->hasHeader('Type')) $object->type = $this->request->header('Type');
        $object->save();
        return $this->storeResponse($object);
    }
    protected function storeResponse($object){ return $object; }
    protected function storing(){}
    protected function validateRequest(Request $request){ }

    public function show($id) {
        $class = $this->className;
        $object = $class::findOrNew($id);
        if ($this->load) $object->load($this->load);
        return $object;
    }

    public function destroy(Request $request, $id) {
        $this->query()->find($id)->delete();
    }
    protected function getModelsClass(){
        if ($this->className) return $this->className;
        $this->modelName = $this->getModelName($this->request);
        return 'App\\Models\\'.$this->modelName;
    }
    protected function getModelName(Request $request){
        if ($this->modelName) return $this->modelName;
        if ($request->hasHeader('Model')) return $request->header('Model');
        $name = $request->segment(2);
        $name = \Str::singular($name);
        $name = \Str::camel($name);
        $name = ucfirst($name);
        return $name;
    }
    protected function query():Builder{
        $class = $this->className;
        return $class::query();
    }

    /**
     * @return Builder
     */
    protected function getBuilder(){
        return $this->query();
    }
}
