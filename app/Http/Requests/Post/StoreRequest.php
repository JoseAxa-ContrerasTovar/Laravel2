<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{

    protected  function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->title),
            //'slug' => Str::of($this->title)->slug()->append("-adicional"),
            //'slug' => Str::($this->title)->slug(),
        ]);
    }

    static public function myRules()
    {
        return [
            "title" => "required|min:5|max:500",
            "slug" => "required|min:5|max:500|unique:posts",
            "content" => "required|min:7",
            "category_id" => "required|integer",
            "description" => "required|min:7",
            "posted" => "required"
        ]; 
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if($this->expectsJson()){
            $response = new Response($validator->errors(),422);
            throw new ValidationException($validator, $response);
        }
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->myRules();
    }
}
