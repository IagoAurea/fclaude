<?php

namespace Modules\Package\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubpackageRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *
     *  @return array
     * 
     *  @OA\Schema(
     *      schema="SubpackageRequest",
     *      type="object",
     *      required={
     *          "info",
     *          "attributes",
     *          "image",
     *          "second_step"
     *      },
     *      @OA\Property(
     *          property="info", 
     *          description="Name and description of new plan",
     *          type="object",
     *          @OA\Property(property="es", type="object", 
     *              @OA\Property(property="name", type="string"), 
     *              @OA\Property(property="description", type="string")
     *          ),
     *          @OA\Property(property="en", type="object", 
     *              @OA\Property(property="name", type="string"), 
     *              @OA\Property(property="description", type="string")
     *          ),
     *          @OA\Property(property="code", type="string"),
     *          @OA\Property(property="package_id", type="integer"),
     *          @OA\Property(property="custom", type="integer"),
     *          @OA\Property(property="status", type="integer"),
     *      ),
     *      @OA\Property(
     *          property="attributes",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="attribute_id", type="integer", example=1),
     *              @OA\Property(property="monthlyquantity", type="integer", example=1),
     *              @OA\Property(property="annualquantity", type="integer", example=1),
     *              @OA\Property(property="available", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Property(property="image", type="string", example="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/4gxYSUNDX1BST0ZJTEUA..."),
     *      @OA\Property(
     *          property="second_step",
     *          type="object",
     *          @OA\Property(property="educational_center", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="inter", example="1")
     *          ),
     *          @OA\Property(property="classes", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="students", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="exercise_design", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="training_sessions", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="available_scenarios", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="tests", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="rubrics", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="evaluations", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="tutoring", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *          @OA\Property(property="grades", type="object", 
     *              @OA\Property(property="enabled", type="boolean"),
     *              @OA\Property(property="value", type="integer", example=1)
     *          ),
     *      )
     *  )
     */
    public function rules()
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT' => $this->update(),
            default => []
        };
    }

    public function store()
    {


        return [
            //Primer paso
            'info' => 'required|array',
            'info.es' => 'required|array',
            'info.es.name' => 'required|string',
            'info.es.description' => 'required|string',
            'info.en' => 'required|array',
            'info.en.name' => 'required|string',
            'info.en.description' => 'required|string',
            'info.code' => 'required|string',
            'info.package_id' => 'required|integer',
            'info.custom' => 'required|boolean',
            'info.status' => 'required|boolean',
            'attributes' => 'required|array',
            'attributes.*.attribute_id' => 'required|integer',
            'attributes.*.quantity' => 'required|integer|min:0',
            'attributes.*.available' => 'required|boolean',
            'image' => 'nullable|string',
            //Segundo paso
            'second_step' => 'required|array',
            'second_step.educational_center.enabled' => 'required|boolean',
            'second_step.educational_center.value' => 'nullable|integer|min:0',
            'second_step.classes.enabled' => 'required|boolean',
            'second_step.classes.value' => 'nullable|integer|min:0',
            'second_step.students.enabled' => 'required|boolean',
            'second_step.students.value' => 'nullable|integer|min:0',
            'second_step.exercise_design.enabled' => 'required|boolean',
            'second_step.exercise_design.value' => 'nullable|integer|min:0',
            'second_step.training_sessions.enabled' => 'required|boolean',
            'second_step.training_sessions.value' => 'nullable|integer|min:0',
            'second_step.available_scenarios.enabled' => 'required|boolean',
            'second_step.available_scenarios.value' => 'nullable|integer|min:0',
            'second_step.tests.enabled' => 'required|boolean',
            'second_step.tests.value' => 'nullable|integer|min:0',
            'second_step.rubrics.enabled' => 'required|boolean',
            'second_step.rubrics.value' => 'nullable|integer|min:0',
            'second_step.evaluations.enabled' => 'required|boolean',
            'second_step.evaluations.value' => 'nullable|integer|min:0',
            'second_step.tutoring.enabled' => 'required|boolean',
            'second_step.tutoring.value' => 'nullable|integer|min:0',
            'second_step.grades.enabled' => 'required|boolean',
            'second_step.grades.value' => 'nullable|integer|min:0',
        ];

    }

    public function update()
    {


        return [
            //Primer paso
            'info' => 'required|array',
            'info.es' => 'required|array',
            'info.es.name' => 'required|string',
            'info.es.description' => 'required|string',
            'info.en' => 'required|array',
            'info.en.name' => 'required|string',
            'info.en.description' => 'required|string',
            'info.code' => 'required|string',
            'info.package_id' => 'required|integer|exists:packages,id',
            'info.custom' => 'required|boolean',
            'info.status' => 'required|boolean',
            'attributes' => 'required|array',
            'attributes.*.attribute_id' => 'required|integer',
            'attributes.*.quantity' => 'required|integer|min:0',
            'attributes.*.available' => 'required|boolean',
            'image' => 'nullable|string',
            //Segundo paso
            'second_step' => 'required|array',
            'second_step.educational_center.enabled' => 'required|boolean',
            'second_step.educational_center.value' => 'nullable|integer|min:0',
            'second_step.classes.enabled' => 'required|boolean',
            'second_step.classes.value' => 'nullable|integer|min:0',
            'second_step.students.enabled' => 'required|boolean',
            'second_step.students.value' => 'nullable|integer|min:0',
            'second_step.exercise_design.enabled' => 'required|boolean',
            'second_step.exercise_design.value' => 'nullable|integer|min:0',
            'second_step.training_sessions.enabled' => 'required|boolean',
            'second_step.training_sessions.value' => 'nullable|integer|min:0',
            'second_step.available_scenarios.enabled' => 'required|boolean',
            'second_step.available_scenarios.value' => 'nullable|integer|min:0',
            'second_step.tests.enabled' => 'required|boolean',
            'second_step.tests.value' => 'nullable|integer|min:0',
            'second_step.rubrics.enabled' => 'required|boolean',
            'second_step.rubrics.value' => 'nullable|integer|min:0',
            'second_step.evaluations.enabled' => 'required|boolean',
            'second_step.evaluations.value' => 'nullable|integer|min:0',
            'second_step.tutoring.enabled' => 'required|boolean',
            'second_step.tutoring.value' => 'nullable|integer|min:0',
            'second_step.grades.enabled' => 'required|boolean',
            'second_step.grades.value' => 'nullable|integer|min:0',
        ];

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
