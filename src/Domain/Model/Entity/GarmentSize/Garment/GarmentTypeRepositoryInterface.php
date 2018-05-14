<?php
/**
 * Created by PhpStorm.
 * User: programador
 * Date: 25/04/18
 * Time: 11:54
 */

namespace Inventory\Management\Domain\Model\Entity\GarmentSize\Garment;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

interface GarmentTypeRepositoryInterface
{
    public function insertGarmentType(string $name): GarmentType;

    public function listGarmentTypes(): array;

    public function findGarmentTypeById(int $id): ?GarmentType;

    public function findGarmentTypeByName(string $name): ?GarmentType;

    public function persistAndFlush(GarmentType $garmentTypeEntity): void;

    public function updateGarmentType(GarmentType $garmentTypeEntity, string $name): void;
}