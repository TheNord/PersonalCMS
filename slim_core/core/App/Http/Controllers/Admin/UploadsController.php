<?php

namespace App\Http\Controllers\Admin;

use App\ReadModel\ContactReadRepository;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\UploadedFile;

class UploadsController
{
    public function storeImage(RequestInterface $request, ResponseInterface $response)
    {
        $image = $request->getUploadedFiles()['file'];

        $uploadsFolder = app()->get('settings')['public_folder'] . '/uploads/images';

        if ($image->getError() === UPLOAD_ERR_OK) {
            try {
                $filename = $this->moveUploadedFile($uploadsFolder, $image);
                return json_encode(['link' => "/uploads/images/" . $filename]);
            } catch (\Exception $e) {
                $response->withStatus(403);
                return $response->write($e->getMessage());
            }
        }
    }

    private function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        if (!in_array($extension, $allowedExts)) {
            throw new \Exception('Неверный формат изображения');
        }

        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}