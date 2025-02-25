<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreTestRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description=" name in spanish ", format="string", example="Bueno " ),
     *   @OA\Property( title="Name in English", property="name_english", description=" name in English", format="string", example="Good" ),
     *   @OA\Property( title="Description in Spanish", property="description_spanish", description="description in spanish ", format="string", example="Bueno " ),
     *   @OA\Property( title="Description in English", property="description_english", description="description in English", format="string", example="Good" ),
     *   @OA\Property( title="Test Type", property="test_type_id", description="Test Type ", format="integer", example="1" ),
     *   @OA\Property( title="Test Sub Type", property="test_sub_type_id", description="Test Sub Type ", format="integer", example="1" ),
     *   @OA\Property( title="Value", property="value", description="test value in percentage or points", format="double", example="100" ),
     *   @OA\Property( title="Image", property="image", description="the related image", format="file", example="" ),
     *   @OA\Property( title="New Questions", property="new_questions", description="array to the new questions by test", format="application/json", example="[{ 'name_spanish ': 'Como fue la atención recibida? ', 'name_english ': 'How was the care received? ', 'question_category_code ':null, 'value ':50, 'associate_responses ':[{'response_id':27,'value': 0,'unit_id':1,'cal_value':false,'is_index':false,'laterality':''}],'new_responses':[{ 'name_spanish ': 'Extremadamente mala ', 'name_english ': 'Very much Bad ', 'value ':0, 'tooltick ':null,'unit_id':1,'cal_value':false,'is_index':false,'laterality':''}]}]" ),
     *   @OA\Property( title="Associate Questions", property="associate_questions", description="array to the associate old questions by test", format="application/json", example="[{'question_id' : 26, 'value': 0,'associate_responses':[{'response_id':27,'value': 0,'unit_id':1,'cal_value':false,'is_index':false,'laterality':''}],'new_responses':[{ 'name_spanish ': 'Extremadamente mala ', 'name_english ': 'Very much Bad ', 'value ':0, 'tooltick ':null,'unit_id':1,'cal_value':false,'is_index':false,'laterality':''}]}]" ),
     *   @OA\Property( title="Type Valoration", property="type_valoration_code", description="Defines if the test is evaluated by points or by percentage", format="string", example="percentage" ),
     *   @OA\Property( title="Sport", property="sport_id", description="id to sport to relate test", format="integer", example="1" ),
     *   @OA\Property( title="Configurations", property="configurations", description="configurations associates", format="array", example="[1,2,3]" ),
     * * )
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_spanish'         => 'required|string',
            'name_english'         => 'required|string',
            'description_spanish'  => 'nullable|string',
            'description_english'  => 'nullable|string',
            'test_type_id'         => 'required|exists:test_types,id' ,
            'test_sub_type_id'     => 'nullable|exists:test_sub_types,id' ,
            'type_valoration_code' => 'required|string|exists:type_valorations,code',
            'value'                => 'required|numeric',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,svg|dimensions:min_width=250,min_height=250|min:1|max:2048',
            'new_questions'        => 'nullable|json',
            'new_questions.*.name_spanish' => 'required|string',
            'new_questions.*.name_english' => 'required|string',
            'new_questions.*.question_category_code' => 'nullable|exists:question_categories,code',
            'new_questions.*.value' => 'required|numeric',
            'new_questions.*.associate_responses' => 'nullable|array',
            'new_questions.*.associate_responses.*.response_id' => 'required|integer|exists:responses,id',
            'new_questions.*.associate_responses.*.value' => 'required|numeric',
            'new_questions.*.new_responses' => 'nullable|array',
            'new_questions.*.new_responses.*.name_spanish' => 'required|string',
            'new_questions.*.new_responses.*.name_english' => 'required|string',
            'new_questions.*.new_responses.*.value' => 'required|numeric',
            'new_questions.*.new_responses.*.tooltick' => 'required|string',
            'associate_questions'  => 'nullable|json',
            'associate_questions.*.value' => 'required|numeric',
            'associate_questions.*.question_id' => 'required|integer|exists:questions,id',
            'associate_questions.*.associate_responses' => 'nullable|array',
            'associate_questions.*.associate_responses.*.response_id' => 'required|integer|exists:responses,id',
            'associate_questions.*.associate_responses.*.value' => 'required|numeric',
            'associate_questions.*.new_responses' => 'nullable|array',
            'associate_questions.*.new_responses.*.name_spanish' => 'required|string',
            'associate_questions.*.new_responses.*.name_english' => 'required|string',
            'associate_questions.*.new_responses.*.value' => 'required|numeric',
            'associate_questions.*.new_responses.*.tooltick' => 'nullable|string',
            'sport_id' => 'nullable|integer|exists:sports,id', 
            'configurations' => 'nullable|array'                                
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
