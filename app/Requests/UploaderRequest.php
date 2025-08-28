<?php

declare(strict_types=1);

namespace App\Requests;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use League\MimeTypeDetection\FinfoMimeTypeDetector;
use Psr\Http\Message\UploadedFileInterface;
use finfo;

class UploaderRequest
{
    public function verifyFile(UploadedFileInterface $file): bool
    {
        if (!$file) {
            throw new ValidationException(['file' => 'File no found']);
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new ValidationException(['file' => 'File have error']);
        }

        $size = 5 * 1024 * 1024;
        if ($file->getSize() > $size) {
            throw new ValidationException(['file' => 'file size is large 5MB']);
        }

        $allowedMimeType = ['image/png', 'image/jpg', 'image/jpeg'];
        $fileUrl = $file->getStream()->getMetadata('uri');

        if (!in_array($file->getClientMediaType(), $allowedMimeType)) {
            throw new ValidationException(['file' => ["File don't have valid mime type"]]);
        }

        $detector = new FinfoMimeTypeDetector();

        if (!in_array($detector->detectMimeTypeFromFile($fileUrl), $allowedMimeType)) {
            throw new ValidationException(['file' => "file don't have valid type"]);
        }

        return true;
    }
}
