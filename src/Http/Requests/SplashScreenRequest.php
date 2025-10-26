<?php

namespace MightyWeb\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SplashScreenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'logo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'duration' => ['required', 'integer', 'min:1000', 'max:10000'],
            'background_color' => ['required', 'string', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ];

        // Make logo required only on create, not on update
        if ($this->isMethod('post')) {
            $rules['logo'][0] = 'required';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'logo.required' => 'Please upload a logo image for the splash screen.',
            'logo.image' => 'Logo must be a valid image file.',
            'logo.mimes' => 'Logo must be a JPEG, PNG, JPG, or GIF file.',
            'logo.max' => 'Logo file size must not exceed 2MB.',
            
            'background.image' => 'Background must be a valid image file.',
            'background.mimes' => 'Background must be a JPEG, PNG, JPG, or GIF file.',
            'background.max' => 'Background file size must not exceed 2MB.',
            
            'duration.required' => 'Splash screen duration is required.',
            'duration.integer' => 'Duration must be a number.',
            'duration.min' => 'Duration must be at least 1 second (1000 milliseconds).',
            'duration.max' => 'Duration cannot exceed 10 seconds (10000 milliseconds).',
            
            'background_color.required' => 'Background color is required.',
            'background_color.regex' => 'Background color must be a valid hex color code (e.g., #FFFFFF).',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'logo' => 'splash logo',
            'background' => 'background image',
            'duration' => 'display duration',
            'background_color' => 'background color',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert duration to integer if string
        if ($this->has('duration') && is_string($this->duration)) {
            $this->merge([
                'duration' => (int) $this->duration,
            ]);
        }

        // Ensure background_color has # prefix
        if ($this->has('background_color') && !str_starts_with($this->background_color, '#')) {
            $this->merge([
                'background_color' => '#' . $this->background_color,
            ]);
        }
    }
}
