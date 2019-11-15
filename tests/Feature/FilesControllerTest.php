<?php

namespace Tests\Feature;

use App\Jobs\Files\StoreCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilesControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStore()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('poster.jpg');

        $response = $this->post('/files', [
            'file' => $file
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'path' => $response->original->path
            ]
        ]);

        Storage::disk('public')->assertExists($response->original->path);

    }

    public function testShow()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('poster.jpg');

        [$fileModel] = dispatch_now(new StoreCommand($file));

        $response = $this->get('/files/' . $fileModel->path);

        $response->assertStatus(200);

        $response->assertHeader('content-type', $file->getMimeType());

    }

    public function testDestroy()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('poster.jpg');

        [$fileModel] = dispatch_now(new StoreCommand($file));

        $response = $this->delete('/files/' . $fileModel->path);

        $response->assertStatus(200);

        Storage::disk('public')->assertMissing($fileModel->path);

    }


}
