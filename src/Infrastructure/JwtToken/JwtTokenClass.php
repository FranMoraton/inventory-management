<?php

namespace Inventory\Management\Infrastructure\JwtToken;

use Firebase\JWT\JWT;
use Inventory\Management\Domain\Model\JwtToken\InvalidRoleTokenException;
use Inventory\Management\Domain\Model\JwtToken\InvalidTokenException;
use Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException;
use Inventory\Management\Domain\Model\JwtToken\JwtToken;
use Inventory\Management\Domain\Model\JwtToken\JwtTokenClassInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class JwtTokenClass implements JwtTokenClassInterface
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function createToken(string $role, array $data): string
    {
        $time = time();
        $token = [
            'iat' => $time,
            'exp' => $time + JwtToken::ONE_HOUR,
            'aud' => $this->audience(),
            'role' => $role,
            'data' => $data
        ];
        $token = JWT::encode($token, JwtToken::KEY);

        return $token;
    }

    /**
     * @param string $role
     * @return mixed
     * @throws InvalidRoleTokenException
     * @throws InvalidTokenException
     * @throws InvalidUserTokenException
     */
    public function checkToken(string $role)
    {
        $token = $this->requestStack->getCurrentRequest()->headers->get('X-AUTH-TOKEN');
        if (null === $token) {
            throw new InvalidTokenException();
        }
        $decode = JWT::decode(
            $token,
            JwtToken::KEY,
            JwtToken::TYPE_ENCRYPT
        );
        if ($role !== $decode->role) {
            throw new InvalidRoleTokenException();
        }
        if ($this->audience() !== $decode->aud) {
            throw new InvalidUserTokenException();
        }

        return $decode->data;
    }

    private function audience(): string
    {
        $server = $this->requestStack->getCurrentRequest()->server;
        switch (true) {
            case null !== $server->get('HTTP_CLIENT_IP'):
                $aud = $server->get('HTTP_CLIENT_IP');
                break;
            case null !== $server->get('HTTP_X_FORWARDED_FOR'):
                $aud = $server->get('HTTP_X_FORWARDED_FOR');
                break;
            default:
                $aud = $server->get('REMOTE_ADDR');
        }
        $aud .= @$server->get('HTTP_USER_AGENT');
        $aud .= gethostname();

        return sha1($aud);
    }
}
