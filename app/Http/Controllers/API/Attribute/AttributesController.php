<?php

namespace App\Http\Controllers\API\Attribute;

# controllers.
use App\Http\Controllers\Controller;

# requests.
use App\Http\Requests\Request;
use App\Http\Requests\Attribute\AttributeRequest;

# models.
use App\Models\EAV\Attribute;

# resources.
use App\Http\Resources\Attribute\AttributeResource;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = app('rinvex.attributes.attribute')->search($request->filter);

        $attributes = $query->paginate($request->per_page);

        return AttributeResource::collection($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param Attribute $model
     * @return AttributeResource
     */
    public function show(Attribute $attribute)
    {
        return AttributeResource::make($attribute);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeRequest $request
     * @return AttributeResource
     */
    public function store(AttributeRequest $request)
    {
        $attribute = app('rinvex.attributes.attribute')->create($request->all());

        return $this->show($attribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeRequest $request
     * @param Attribute $model
     * @return AttributeResource
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->all());

        return $this->show($attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute $model
     * @return AttributeResource
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json(['data' => null, 'message' => 'Deleted successfully.']);
    }
}
