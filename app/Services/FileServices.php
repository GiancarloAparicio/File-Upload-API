<?php

namespace App\Services;

use App\Models\Music;
use App\Models\Photo;
use App\Models\Video;
use App\Validator\FileValidator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileServices
{

    private $photo;
    private $music;
    private $video;
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
     *  @return  App\Models\Photo - App\Models\Music - App\Models\Video
     */
    public function createResource($file, String $type, $model)
    {
        $fileName = time() . $file->getClientOriginalName();
        $destinationPath =  base_path() . '/public/uploads/' . $type . '/';
        $file->move($destinationPath, $fileName);

        return $model::create([
            'name' => $fileName,
            'path' => $destinationPath
        ]);
    }


    /**
     * Save a file, depending if it is a photo, music or video, otherwise it 
     *  returns an exception
     * 
     *  @param File $file  (.mp3, .mp4, .svg, .jpg, .png)
     *  @return  App\Models\Photo - App\Models\Music - App\Models\Video
     */
    public function createFile($file)
    {
        $this->fileValidator->validate();
        $fileExtension = $file->getClientOriginalExtension();

        if ($fileExtension == 'jpg' || $fileExtension ==  'png' || $fileExtension == 'svg') {
            return $this->createResource($file, 'photos', $this->photo);
        }

        if ($fileExtension == 'mp3') {
            return $this->createResource($file, 'musics', $this->music);
        }

        if ($fileExtension == 'mp4') {
            return $this->createResource($file, 'videos', $this->video);
        }

        throw new HttpException(400, 'Request is bad');
    }
}
