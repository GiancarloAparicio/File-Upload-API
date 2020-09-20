<?php

namespace App\Services;

use App\Models\Music;
use App\Models\Photo;
use App\Models\Video;
use App\Validator\FileValidator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileServices
{

    private $fileValidator;

    public function __construct(
        Photo $photo,
        Video $video,
        Music $music,
        FileValidator $fileValidator
    ) {
        $this->photo = $photo;
        $this->music = $music;
        $this->video = $video;
        $this->fileValidator = $fileValidator;
    }

    /**
     *  Create a resource depending on the parameters it receives
     * 
     *  @param File $file
     *  @param String $string
     *  @param Model $model
     *  @return  Model $model
     */
    public function createResource($file, String $type, $model)
    {
        $fileName = time() . $file->getClientOriginalName();
        $destinationPath =  base_path() . '/public/uploads/' . $type . '/';
        $file->move($destinationPath, $fileName);

        return $model::create([
            'name' => $file->getClientOriginalName(),
            'path' => './uploads/' . $type . '/' . $fileName
        ]);
    }


    /**
     * Save a file, depending if it is a photo, music or video, otherwise it 
     *  returns an exception
     * 
     *  @param File $file  (.mp3, .mp4, .svg, .jpg, .png)
     *  @return  Model $model
     */
    public function createFile($file)
    {
        $this->fileValidator->validate();

        $fileType = $this->getTypeFile($file);

        return $this->createResource($file, $fileType['route'], $fileType['model']);
    }

    /**
     * Gets the type of model and the name of the current path, 
     *  if the file is in the wrong path it returns an exception
     * 
     *  @param File $file
     *  @return Object $route
     */
    public function getTypeFile($file)
    {
        $routeName = request()->route()[1]['as'];
        $model = explode(".", $routeName)[0];

        if ($this->validateFileToRoute($file, $model)) {
            return [
                'route' => $model,
                'model' => $this->$model
            ];
        }

        throw new HttpException(400, 'Request is bad');
    }

    /**
     * Validate that the file you want to upload is in the correct path that corresponds to it
     * 
     *  @param File $file
     *  @param String $nameRoute
     *  @return Boolean 
     */
    public function validateFileToRoute($file, $nameRoute)
    {
        $fileExtension = $file->getClientOriginalExtension();

        if (($fileExtension == 'mp4') && ($nameRoute == 'video')) {
            return true;
        }

        if (($fileExtension == 'mp3') && ($nameRoute == 'music')) {
            return true;
        }

        if (($fileExtension == 'png' || $fileExtension == 'svg' || $fileExtension == 'jpg') && ($nameRoute == 'photo')) {
            return true;
        }

        return false;
    }

    public function showFile(int $id)
    {
        return $this->getFileById($id);
    }

    public function updateFile(int $id, $file)
    {
        $this->fileValidator->validate();
        $type = $this->getTypeFile($file);

        return $this->updateResource($file, $id, $type);
    }

    public function updateResource($file, $id, $type)
    {
        $model = $type['model']::findOrFail($id);

        $name = $file->getClientOriginalName();
        $fileName = time() . $name;

        $destinationPath =  base_path() . '/public/uploads/' . $type['route'] . '/';
        $file->move($destinationPath, $fileName);

        return $model->update([
            'name' => $name,
            'path' => './uploads/' . $type['route'] . '/' . $fileName
        ]);
    }

    public function getFileById(int $id)
    {

        $routeName = request()->route()[1]['as'];
        $model = explode(".", $routeName)[0];
        return $this->$model::findOrFail($id);
    }
}
