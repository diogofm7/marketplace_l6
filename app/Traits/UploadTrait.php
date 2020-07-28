<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

trait UploadTrait
{

    private function imageUpload($images, $imageColumn = null)
    {
        $uploadedImages = [];

        if(is_array($images)){
            foreach ($images as $image){
                $imagePath = $image->store('products/original', 'public');
                $uploadedImages[] = [$imageColumn =>  $imagePath];

                $name = collect(explode('/', $imagePath))->last();

                $width = 200; // your max width
                $height = 200; // your max height
                $img = ImageManagerStatic::make($image->getRealPath());
                $img->height() > $img->width() ? $width=null : $height=null;
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                if (!File::isDirectory(storage_path('app/public/products/TBM'))) {
                    Storage::makeDirectory('public/products/TBM');
                }
                $img->save(storage_path('app/public/products/TBM/'.$name));
            }
        }else{
            $uploadedImages = $images->store('logo', 'public');
        }

        return $uploadedImages;
    }

}
