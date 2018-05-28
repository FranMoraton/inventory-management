<?php

namespace Inventory\Management\Domain\Service\Util;

class GenerateCharacters
{
    public function execute(int $numberOfCharacters): string
    {
        $characters = 'abcdefghijklmnñopqrstuvwxyz123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
        $charactersSize = strlen($characters) - 1;
        $generatedCharacters = '';
        for ($i = 0; $i < $numberOfCharacters; $i++) {
            $generatedCharacters .= $characters[rand(0, $charactersSize)];
        }

        return $generatedCharacters;
    }
}
