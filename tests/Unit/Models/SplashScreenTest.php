<?php

namespace MightyWeb\Tests\Unit\Models;

use MightyWeb\Models\SplashScreen;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SplashScreenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_splash_screen()
    {
        $splashScreen = SplashScreen::create([
            'logo' => 'splash_logo.png',
            'background' => 'splash_background.png',
            'duration' => 3000,
            'background_color' => '#FFFFFF',
        ]);

        $this->assertInstanceOf(SplashScreen::class, $splashScreen);
        $this->assertEquals('splash_logo.png', $splashScreen->logo);
        $this->assertEquals('splash_background.png', $splashScreen->background);
        $this->assertEquals(3000, $splashScreen->duration);
        $this->assertEquals('#FFFFFF', $splashScreen->background_color);
    }

    /** @test */
    public function it_has_default_duration_of_3000()
    {
        $splashScreen = SplashScreen::create([
            'logo' => 'splash_logo.png',
        ]);

        $this->assertEquals(3000, $splashScreen->duration);
    }

    /** @test */
    public function it_has_default_background_color_of_white()
    {
        $splashScreen = SplashScreen::create([
            'logo' => 'splash_logo.png',
        ]);

        $this->assertEquals('#FFFFFF', $splashScreen->background_color);
    }

    /** @test */
    public function it_can_update_splash_screen()
    {
        $splashScreen = SplashScreen::create([
            'logo' => 'old_logo.png',
            'duration' => 2000,
        ]);

        $splashScreen->update([
            'logo' => 'new_logo.png',
            'duration' => 5000,
        ]);

        $this->assertEquals('new_logo.png', $splashScreen->logo);
        $this->assertEquals(5000, $splashScreen->duration);
    }

    /** @test */
    public function it_can_delete_splash_screen()
    {
        $splashScreen = SplashScreen::create([
            'logo' => 'splash_logo.png',
        ]);

        $id = $splashScreen->id;
        $splashScreen->delete();

        $this->assertNull(SplashScreen::find($id));
    }
}
