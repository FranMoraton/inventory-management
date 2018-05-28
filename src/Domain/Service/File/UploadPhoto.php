<?php

namespace Inventory\Management\Domain\Service\File;

use Inventory\Management\Domain\Model\File\ImageCanNotUploadException;
use Inventory\Management\Domain\Service\Util\GenerateCharacters;

class UploadPhoto
{
    private $generateCharacters;

    public function __construct(GenerateCharacters $generateCharacters)
    {
        $this->generateCharacters = $generateCharacters;
    }

    public function execute($fileImage, string $urlImage): string
    {
        $numberOfCharacters = 20;
        $generatedName = $this->generateCharacters->execute($numberOfCharacters);
        $filmImageName = $generatedName.'.'.$this->extensionImage($fileImage);
        list($width, $height) = getimagesize($fileImage['tmp_name']);
        $tn = imagecreatetruecolor($width, $height);
        if ('image/png' === $fileImage['type']) {
            $image = imageCreateFromPng($fileImage['tmp_name']);
        } else {
            $image = imageCreateFromJpeg($fileImage['tmp_name']);
        }
        imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
        $url = __DIR__.'/../../../../public/uploads/'.$urlImage.$filmImageName;
        if ('image/png' === $fileImage["type"]) {
            $isUpload = imagepng($tn, $url);
        } else {
            $isUpload = imagejpeg($tn, $url, 100);
        }
        if (false === $isUpload) {
            throw new ImageCanNotUploadException();
        }

        return $filmImageName;
    }

    private function extensionImage($fileTypeImage): string
    {
        $extension = "jpg";
        if ('image/png' === $fileTypeImage['type']) {
            $extension = "png";
        }

        return $extension;
    }
}
