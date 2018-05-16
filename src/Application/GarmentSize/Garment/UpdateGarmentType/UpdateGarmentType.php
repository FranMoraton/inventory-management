<?php
/**
 * Created by PhpStorm.
 * User: programador
 * Date: 26/04/18
 * Time: 12:25
 */

namespace Inventory\Management\Application\GarmentSize\Garment\UpdateGarmentType;

use Inventory\Management\Domain\Model\Entity\GarmentSize\Garment\GarmentTypeNotExistsException;
use Inventory\Management\Domain\Model\Entity\GarmentSize\Garment\GarmentTypeRepositoryInterface;
use Inventory\Management\Domain\Service\GarmentSize\Garment\FindGarmentTypeIfExists;

class UpdateGarmentType
{
    const OK = 'GarmentType actualizado con exito';
    const CODE_OK = 200;

    private $garmentTypeRepository;
    private $updateGarmentTypeTransform;
    private $findGarmentTypeIfExists;

    /**
     * UpdateGarmentType constructor.
     *
     * @param GarmentTypeRepositoryInterface      $garmentTypeRepository
     * @param UpdateGarmentTypeTransformInterface $updateGarmentTypeTransform
     * @param FindGarmentTypeIfExists             $findGarmentIfExists
     */
    public function __construct(
        GarmentTypeRepositoryInterface $garmentTypeRepository,
        UpdateGarmentTypeTransformInterface $updateGarmentTypeTransform,
        FindGarmentTypeIfExists $findGarmentIfExists
    ) {
        $this->garmentTypeRepository = $garmentTypeRepository;
        $this->updateGarmentTypeTransform = $updateGarmentTypeTransform;
        $this->findGarmentTypeIfExists = $findGarmentIfExists;
    }

    /**
     * @param UpdateGarmentTypeCommand $updateGarmentTypeCommand
     *
     * @return array
     */
    public function handle(UpdateGarmentTypeCommand $updateGarmentTypeCommand): array
    {
        $output = ['data' => self::OK, 'code' => self::CODE_OK ];

        $garmentTypeId = $updateGarmentTypeCommand->getId();
        $garmentTypeName = $updateGarmentTypeCommand->getName();

        try {
            $garmentTypeEntity = $this->findGarmentTypeIfExists->execute($garmentTypeId);
        } catch (GarmentTypeNotExistsException $gnex) {
            return [
                'data' => $gnex->getMessage(),
                'code' => $gnex->getCode()
            ];
        }

        $this
            ->garmentTypeRepository
            ->updateGarmentType(
                $garmentTypeEntity,
                $garmentTypeName
            );

        return $output;
    }
}
