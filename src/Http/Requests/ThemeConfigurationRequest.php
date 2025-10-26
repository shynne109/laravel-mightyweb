<?php

namespace MightyWeb\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MightyWeb\Rules\HexColorRule;

class ThemeConfigurationRequest extends FormRequest
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
        return [
            'primary_color' => ['required', 'string', new HexColorRule()],
            'secondary_color' => ['required', 'string', new HexColorRule()],
            'accent_color' => ['required', 'string', new HexColorRule()],
            'background_color' => ['required', 'string', new HexColorRule()],
            'text_color' => ['required', 'string', new HexColorRule()],
            'font_family' => ['required', 'string', 'max:100'],
            'style_preset' => ['required', 'string', 'in:default,dark,ocean,sunset,forest'],
            'is_dark_mode' => ['boolean'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'primary_color.required' => 'Primary color is required for theme configuration.',
            'secondary_color.required' => 'Secondary color is required for theme configuration.',
            'accent_color.required' => 'Accent color is required for theme configuration.',
            'background_color.required' => 'Background color is required for theme configuration.',
            'text_color.required' => 'Text color is required for theme configuration.',
            'font_family.required' => 'Please select a font family.',
            'font_family.max' => 'Font family name cannot exceed 100 characters.',
            'style_preset.required' => 'Please select a style preset.',
            'style_preset.in' => 'Invalid style preset selected. Choose from: default, dark, ocean, sunset, or forest.',
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
            'primary_color' => 'primary color',
            'secondary_color' => 'secondary color',
            'accent_color' => 'accent color',
            'background_color' => 'background color',
            'text_color' => 'text color',
            'font_family' => 'font family',
            'style_preset' => 'style preset',
            'is_dark_mode' => 'dark mode setting',
        ];
    }
}
