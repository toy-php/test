<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\Files\StoreRequest;
use App\Http\Resources\FilesResource;
use App\Jobs\Files\DestroyCommand;
use App\Jobs\Files\StoreCommand;
use App\Models\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Response;

class FilesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return FilesResource
     */
    public function store(StoreRequest $request)
    {
        $request->validated();
        [$file] = dispatch_now(new StoreCommand($request->file('file')));
        return new FilesResource($file);
    }

    /**
     * Display the specified resource.
     *
     * @param string $path
     * @return \Illuminate\Http\Response
     * @throws FileNotFoundException
     */
    public function show($path)
    {
        $file = File::wherePath($path)->firstOrFail();
        $disk = File::getDisk();
        if (!$disk->exists($file->path)) {
            App::abort(404);
        }

        $response = Response::make($disk->get($file->path), 200);
        $response->header("Content-Type", $disk->mimeType($file->path));
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $path
     * @return array
     */
    public function destroy($path)
    {
        $result = dispatch_now(new DestroyCommand($path));
        return [
            'result' => $result
        ];
    }

}
