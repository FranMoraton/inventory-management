<?php
/**
 * Created by PhpStorm.
 * User: programador
 * Date: 25/04/18
 * Time: 9:49
 */

namespace Inventory\Management\Infrastructure\Controller;

use Inventory\Management\Application\GarmentSize\Garment\InsertGarment\InsertGarment;
use Inventory\Management\Application\GarmentSize\Garment\InsertGarment\InsertGarmentCommand;
use Inventory\Management\Application\GarmentSize\Garment\InsertGarment\InsertGarmentTransform;
use Inventory\Management\Application\GarmentSize\Garment\InsertGarmentType\InsertGarmentTypeTransform;
use Inventory\Management\Application\GarmentSize\Garment\InsertGarmentType\InsertGarmentType;
use Inventory\Management\Application\GarmentSize\Garment\InsertGarmentType\InsertGarmentTypeCommand;
use Inventory\Management\Application\GarmentSize\Garment\ListGarment\ListGarment;
use Inventory\Management\Application\GarmentSize\Garment\ListGarment\ListGarmentTransform;
use Inventory\Management\Application\GarmentSize\Garment\ListGarmentTypes\ListGarmentTypes;
use Inventory\Management\Application\GarmentSize\Garment\ListGarmentTypes\ListGarmentTypesTransform;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarment\UpdateGarment;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarment\UpdateGarmentCommand;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarment\UpdateGarmentTransform;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarmentType\UpdateGarmentType;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarmentType\UpdateGarmentTypeCommand;
use Inventory\Management\Application\GarmentSize\Garment\UpdateGarmentType\UpdateGarmentTypeTransform;
use Inventory\Management\Infrastructure\Repository\GarmentSize\Garment\GarmentRepository;
use Inventory\Management\Infrastructure\Repository\GarmentSize\Garment\GarmentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControllerGarment extends Controller
{

    public function insertGarment(
        string $name,
        int $garmentTypeId,
        GarmentRepository $garmentRepository,
        GarmentTypeRepository $garmentTypeRepository
    ) {
        $insertGarmentTransform = new InsertGarmentTransform();
        $insertGarment = new InsertGarment($garmentRepository, $garmentTypeRepository, $insertGarmentTransform);
        $insertGarment->handle(new InsertGarmentCommand($name, $garmentTypeId));
        return $this->json(['insert garment']);
    }

    public function listGarment(GarmentRepository $listGarmentRepository)
    {
        $listGarmentTransform = new ListGarmentTransform();
        $queryOutput = new ListGarment($listGarmentRepository, $listGarmentTransform);
        $queryOutput = $queryOutput->handle();

        return $this->json([$queryOutput]);
    }

    public function updateGarment(int $id, string $name, GarmentRepository $updateGarmentRepository)
    {
        $updateGarmentTransform = new UpdateGarmentTransform();
        $updateGarment = new UpdateGarment($updateGarmentRepository, $updateGarmentTransform);
        $updateGarment->handle(new UpdateGarmentCommand($id, $name));

        return $this->json(
            [
                'Status' => 'Garment actualizado con exito'
            ]
        );
    }

    public function insertGarmentType(string $name, GarmentTypeRepository $insertGarmentTypeRepository)
    {
        $insertGarmentTypeTransform = new InsertGarmentTypeTransform();
        $insertGarmentType = new InsertGarmentType($insertGarmentTypeRepository, $insertGarmentTypeTransform);
        $insertGarmentType->handle(new InsertGarmentTypeCommand($name));

        return $this->json(
            [
                'Status' => '200 OK'
            ]
        );
    }

    public function listGarmentTypes(GarmentTypeRepository $listGarmentTypeRepository)
    {
        $listGarmentTypesTransform = new ListGarmentTypesTransform();
        $queryOutput = (new ListGarmentTypes($listGarmentTypeRepository, $listGarmentTypesTransform))->handle();

        return $this->json([$queryOutput]);
    }

    public function updateGarmentType(int $id, string $name, GarmentTypeRepository $updateGarmentTypeRepository)
    {
        $updateGarmentTypeTransform = new UpdateGarmentTypeTransform();
        $updateGarmentType = new UpdateGarmentType($updateGarmentTypeRepository, $updateGarmentTypeTransform);
        $updateGarmentType->handle(new UpdateGarmentTypeCommand($id, $name));

        return $this->json(
            [
                'Status' => 'GarmentType actualizado con exito'
            ]
        );
    }
}
