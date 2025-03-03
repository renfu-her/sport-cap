<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * 處理上傳的圖片並轉換為 WebP 格式
     *
     * @param UploadedFile $file 上傳的文件
     * @param string $directory 存儲目錄
     * @param int $width 目標寬度
     * @param int $height 目標高度
     * @return string 處理後的文件路徑
     */
    public static function processImage(UploadedFile $file, string $directory, int $width = 1024, int $height = 1024): string
    {
        // 生成唯一文件名，使用 uuid7
        $filename = Str::uuid7()->toString() . '.webp';
        $path = $directory . '/' . $filename;

        // 使用 Intervention/Image 處理圖片
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        $image->resize(width: $width, height: $height);

        $encodedImage = $image->toWebp(90); // 轉換為 WebP 格式，質量為 90%

        // 保存到存儲
        Storage::disk('public')->put($path, $encodedImage->toString());

        return $path;
    }
}
