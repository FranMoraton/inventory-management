<?php

namespace Inventory\Management\Application\Util\JwtToken;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Inventory\Management\Domain\Model\JwtToken\ExpiredTokenException;
use Inventory\Management\Domain\Model\JwtToken\InvalidTokenException;
use Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;
use Inventory\Management\Infrastructure\Util\JwtToken\JwtTokenUtil;

class CheckToken implements Observer
{
    private $statusInvalidToken;
    private $statusExpiredToken;
    private $statusInvalidUserToken;
    private $jwtTokenUtil;

    public function __construct(JwtTokenUtil $jwtTokenUtil)
    {
        $this->statusInvalidToken = false;
        $this->statusExpiredToken = false;
        $this->statusInvalidUserToken = false;
        $this->jwtTokenUtil = $jwtTokenUtil;
    }

    public function handle(string $token): array
    {
        if (null === $token) {
            $this->statusInvalidToken = true;
        }
        try {
            $decode = $this->jwtTokenUtil->checkToken($token);
        } catch (ExpiredException $expiredException) {
            $this->statusExpiredToken = true;
        } catch (SignatureInvalidException $signatureInvalidException) {
            $this->statusInvalidUserToken = true;
        }
        if ($this->jwtTokenUtil->audience() !== $decode['aud']) {
            $this->statusInvalidUserToken = true;
        }
        ListExceptions::instance()->notify();

        return $decode['data'];
    }

    /**
     * @throws ExpiredTokenException
     * @throws InvalidTokenException
     * @throws InvalidUserTokenException
     */
    public function update()
    {
        switch (true) {
            case $this->statusInvalidToken:
                throw new InvalidTokenException();
            case $this->statusExpiredToken:
                throw new ExpiredTokenException();
            case $this->statusInvalidUserToken:
                throw new InvalidUserTokenException();
        }
    }
}
