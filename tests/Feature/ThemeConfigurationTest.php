<?php

namespace MightyWeb\Tests\Feature;

use MightyWeb\Models\Theme;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeConfigurationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_default_theme_configuration()
    {
        $theme = Theme::create([
            'primary_color' => '#3B82F6',
            'secondary_color' => '#8B5CF6',
            'accent_color' => '#10B981',
            'background_color' => '#FFFFFF',
            'text_color' => '#1F2937',
            'font_family' => 'Roboto',
            'style_preset' => 'default',
            'is_dark_mode' => false,
        ]);

        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertEquals('#3B82F6', $theme->primary_color);
        $this->assertEquals('Roboto', $theme->font_family);
        $this->assertFalse($theme->is_dark_mode);
    }

    /** @test */
    public function it_validates_hex_color_format()
    {
        $theme = Theme::create([
            'primary_color' => '#FF5733',
            'secondary_color' => '#8B5CF6',
            'accent_color' => '#10B981',
            'background_color' => '#FFFFFF',
            'text_color' => '#1F2937',
        ]);

        $this->assertMatchesRegularExpression('/^#[A-Fa-f0-9]{6}$/', $theme->primary_color);
    }

    /** @test */
    public function it_can_apply_dark_mode_preset()
    {
        $theme = Theme::create([
            'primary_color' => '#60A5FA',
            'secondary_color' => '#A78BFA',
            'accent_color' => '#34D399',
            'background_color' => '#1F2937',
            'text_color' => '#F9FAFB',
            'style_preset' => 'dark',
            'is_dark_mode' => true,
        ]);

        $this->assertTrue($theme->is_dark_mode);
        $this->assertEquals('dark', $theme->style_preset);
        $this->assertEquals('#1F2937', $theme->background_color);
    }

    /** @test */
    public function it_supports_multiple_font_families()
    {
        $fonts = ['Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins'];

        foreach ($fonts as $font) {
            $theme = Theme::create([
                'primary_color' => '#3B82F6',
                'secondary_color' => '#8B5CF6',
                'accent_color' => '#10B981',
                'background_color' => '#FFFFFF',
                'text_color' => '#1F2937',
                'font_family' => $font,
            ]);

            $this->assertEquals($font, $theme->font_family);
        }
    }

    /** @test */
    public function it_can_update_theme_colors()
    {
        $theme = Theme::create([
            'primary_color' => '#3B82F6',
            'secondary_color' => '#8B5CF6',
            'accent_color' => '#10B981',
            'background_color' => '#FFFFFF',
            'text_color' => '#1F2937',
        ]);

        $theme->update([
            'primary_color' => '#FF5733',
            'accent_color' => '#FFC300',
        ]);

        $this->assertEquals('#FF5733', $theme->fresh()->primary_color);
        $this->assertEquals('#FFC300', $theme->fresh()->accent_color);
    }

    /** @test */
    public function it_stores_style_preset_name()
    {
        $presets = ['default', 'dark', 'ocean', 'sunset', 'forest'];

        foreach ($presets as $preset) {
            $theme = Theme::create([
                'primary_color' => '#3B82F6',
                'secondary_color' => '#8B5CF6',
                'accent_color' => '#10B981',
                'background_color' => '#FFFFFF',
                'text_color' => '#1F2937',
                'style_preset' => $preset,
            ]);

            $this->assertEquals($preset, $theme->style_preset);
        }
    }
}
