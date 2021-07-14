<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\UploadController;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    /** @test */
    public function test_upload_file()
    {
        $this->travelTo(Carbon::make('2021-01-01 00:00:00'));

        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');

        $this
            ->post(action(UploadController::class), [
                'file' => $file,
            ])
            ->assertSuccessful()
            ->assertSee('/storage/uploads/2021-01-01-00-00-00-test.jpg');

        Storage::disk('public')->assertExists('/uploads/2021-01-01-00-00-00-test.jpg');
    }
}
