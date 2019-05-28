<?php

// Функция для обрезания изображения под соотношение
function cropImage($imagePath, $cropPX){


    list($width, $height) = getimagesize($imagePath);


    if(!function_exists('imageCreateFromAny')) {
        function imageCreateFromAny($filepath)
        {

            $im = null;

            $type = exif_imagetype($filepath);
            $allowedTypes = array(
                1,  // [] gif
                2,  // [] jpg
                3,  // [] png
                6   // [] bmp
            );
            if (!in_array($type, $allowedTypes)) {
                return false;
            }
            switch ($type) {
                case 1 :
                    $im = imageCreateFromGif($filepath);
                    break;
                case 2 :
                    $im = imageCreateFromJpeg($filepath);
                    break;
                case 3 :
                    $im = imageCreateFromPng($filepath);
                    break;
            }
            return $im;
        }
    }


    $myImage = imageCreateFromAny($imagePath);



    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }


    $thumbSize = $cropPX;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);


    imagejpeg($thumb, $imagePath);
}