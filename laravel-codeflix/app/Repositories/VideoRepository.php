<?php

namespace CodeFlix\Repositories;

use Illuminate\Http\UploadedFile;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VideoRepository
 * @package namespace CodeFlix\Repositories;
 */
interface VideoRepository extends RepositoryInterface
{
    public function uploadThumb($id, UploadedFile $file);
}
