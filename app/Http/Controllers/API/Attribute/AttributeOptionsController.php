<?php

namespace App\Http\Controllers\API\Attribute;

# controllers.
use App\Http\Controllers\Controller;

# requests.
use App\Http\Requests\Request;
use App\Http\Requests\Attribute\AttributeOptionRequest;

# models.
use App\Models\EAV\Type\Common\Option;

# resources.
use App\Http\Resources\Attribute\AttributeOptionResource;
use App\Models\EAV\Attribute;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttributeOptionsController extends Controller
{
    /**
     * Ensure an option belongs to given attribute.
     *
     * @param \App\Models\EAV\Type\Common\Option $option
     * @param \App\Models\EAV\Attribute $attribute
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    private function ensureOptionBelongsToAttribute(Option $option, Attribute $attribute)
    {
        if ($option->attribute_id !== $attribute->id) {
            throw new NotFoundHttpException();
        }
    }

    #

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\EAV\Attribute $attribute
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Attribute $attribute, Request $request)
    {
        $query = Option::search($request->filter, $attribute->options());

        $options = $query->paginate($request->per_page);

        return AttributeOptionResource::collection($options);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\EAV\Attribute $attribute
     * @param Option $option
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \App\Http\Resources\Attribute\AttributeOptionResource
     */
    public function show(Attribute $attribute, Option $option)
    {
        $this->ensureOptionBelongsToAttribute($option, $attribute);

        $option->loadMissing('attribute');

        return AttributeOptionResource::make($option);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\EAV\Attribute $attribute
     * @param \App\Http\Requests\Attribute\AttributeOptionRequest $request
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \App\Http\Resources\Attribute\AttributeOptionResource
     */
    public function store(Attribute $attribute, AttributeOptionRequest $request)
    {
        $option = $attribute->options()->create($request->all());

        return $this->show($attribute, $option);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\EAV\Attribute $attribute
     * @param \App\Http\Requests\Attribute\AttributeOptionRequest $request
     * @param Option $model
     * @return \App\Http\Resources\Attribute\AttributeOptionResource
     */
    public function update(Attribute $attribute, AttributeOptionRequest $request, Option $option)
    {
        $this->ensureOptionBelongsToAttribute($option, $attribute);

        $option->update($request->all());

        return $this->show($attribute, $option);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\EAV\Attribute $attribute
     * @param Option $model
     * @return \App\Http\Resources\Attribute\AttributeOptionResource
     */
    public function destroy(Attribute $attribute, Option $option)
    {
        $option->delete();

        return response()->json(['data' => null, 'message' => 'Deleted successfully.']);
    }
}
