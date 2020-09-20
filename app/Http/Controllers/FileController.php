<?php

namespace App\Http\Controllers;

use App\Services\FileServices;
use App\Traits\Response;
use Illuminate\Http\Request;

class FileController extends Controller
{

    use Response;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FileServices $fileServices)
    {
        $file = $fileServices->createFile($request->file);

        return $this->successResponse('File save', $file, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param FileServices $fileServices
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, FileServices $fileServices)
    {
        $file = $fileServices->getFileById($id);

        return response()->download($file->path, $file->name);
        //return $this->successResponse('File show', $file, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FileServices $fileServices
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, FileServices $fileServices, Request $request)
    {
        $file = $fileServices->updateFile($id, $request->file);

        return $this->successResponse('File update', $file, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param FileServices $fileServices
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, FileServices $fileServices)
    {
        $file = $fileServices->deleteById($id);
        return $this->successResponse('File delete', $file, 200);
    }
}
