<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.max' => 'Pertanyaan maksimal 255 karakter.',
            'answer.required' => 'Jawaban wajib diisi.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min' => 'Urutan minimal 0.',
        ];
    }
}
