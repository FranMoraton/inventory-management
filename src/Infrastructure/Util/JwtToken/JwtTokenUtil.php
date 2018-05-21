<?php

namespace Inventory\Management\Infrastructure\Util\JwtToken;

use Firebase\JWT\JWT;
use Inventory\Management\Domain\Model\JwtToken\InvalidTokenException;
use Inventory\Management\Domain\Model\JwtToken\InvalidUserTokenException;
use Inventory\Management\Domain\Model\JwtToken\JwtToken;
use Symfony\Component\HttpFoundation\RequestStack;

class JwtTokenUtil
{
    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function createToken(array $data): string
    {
        $time = time();
        $token = [
            'iat' => $time,
            'exp' => $time + JwtToken::ONE_HOUR,
            'aud' => $this->audience(),
            'data' => $data
        ];

        return JWT::encode($token, JwtToken::KEY);
    }

    /**
     * @param string $token
     * @return object
     */
    public function checkToken(string $token): object
    {
        $decode = JWT::decode(
            $token,
            JwtToken::KEY,
            JwtToken::TYPE_ENCRYPT
        );

        return $decode;
    }

    public function audience(): string
    {
        $server = $this->request->getCurrentRequest()->server;
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
