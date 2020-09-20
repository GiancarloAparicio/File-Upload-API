# File Upload API (Lumen)

Api to upload any type of file, compress and store them, photos, music and videos

## Starting

To create the data base

> php artisan migrate

Create the development server

> php -S localhost:8000 -t ./public/

## Routes

API paths for files:

### Store

> http://localhost:8000/api/v1/file/photo (POST)

> http://localhost:8000/api/v1/file/music (POST)

> http://localhost:8000/api/v1/file/video (POST)

    JSON

     {
     "file": File.jpg | File.mp3 | File.mp4
     }

### Show (Download)

> http://localhost:8000/api/v1/file/photo/{id} (GET)

> http://localhost:8000/api/v1/file/music/{id} (GET)

> http://localhost:8000/api/v1/file/video/{id} (GET)

### Update

> http://localhost:8000/api/v1/file/photo/{id} (POST)

> http://localhost:8000/api/v1/file/music/{id} (POST)

> http://localhost:8000/api/v1/file/video/{id} (POST)

    JSON

     {
     "file": File.jpg | File.mp3 | File.mp4
     "_method": "PUT"
     }

### Delete

> http://localhost:8000/api/v1/file/photo/{id} (DELETE)

> http://localhost:8000/api/v1/file/music/{id} (DELETE)

> http://localhost:8000/api/v1/file/video/{id} (DELETE)
