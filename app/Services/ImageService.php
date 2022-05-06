<?php
declare(strict_type=1);

namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage; 
use Illuminate\Support\Collection;
class ImageService
{
  public function uploadMultiple(?array $imageFiles, string $folderName): Collection
  {
    $fileNameList = [];
    if(!is_null($imageFiles)) {
      foreach($imageFiles as $imageFile){ // それぞれ処理
        if(is_array($imageFile)){
          $file = $imageFile['image'];
        } else {
          $file = $imageFile;
        }
        $fileNameList[] = $this->upload($file, $folderName);
      }
    }
    return collect($fileNameList);
  }
  
  public function upload(?UploadedFile $imageFile, string $folderName): ?string
  {
    if(!is_null($imageFile) && $imageFile->isValid()){
      $fileName = uniqid(rand().'_');
      $extension = $imageFile->extension();
      $fileNameToStore = $fileName. '.' . $extension;
      $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
      // /storage/app/public/shopsに保存
      Storage::put("public/{$folderName}/". $fileNameToStore, $resizedImage);
      return $fileNameToStore;
    } else {
      return null;
    }
  }
}