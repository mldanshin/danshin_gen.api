<?php

namespace App\Repositories\Download\People;

use App\Exceptions\DataNotFoundException;
use App\Repositories\Download\CreatorFile as CreatorFileBase;
use App\Repositories\Download\People as PeopleRepository;
use App\Services\Photo\FileSystem as PhotoFileSystem;

final class CreatorFile extends CreatorFileBase
{
    private readonly PeopleRepository $peopleRepository;
    private readonly FileType $fileType;

    /**
     * @throws DataNotFoundException
     */
    public function __construct(string $fileType)
    {
        $this->fileType = $this->fileTypeFrom($fileType);

        $this->peopleRepository = new PeopleRepository(
            PhotoFileSystem::instance()
        );
    }

    public function create(string $pathDirectory): string
    {
        return $this->createBuilder()->create($pathDirectory, $this->peopleRepository->getAll());
    }

    private function createBuilder(): BuilderAbstract
    {
        switch ($this->fileType) {
            case $this->fileType::PDF:
                return new BuilderPdf();
        }
    }

    /**
     * @throws DataNotFoundException
     */
    private function fileTypeFrom(string $fileType): FileType
    {
        $fileType = FileType::tryFrom($fileType);
        if ($fileType === null) {
            throw new DataNotFoundException("Transferred file format is not supported");
        }

        return $fileType;
    }
}
