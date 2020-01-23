<?php
namespace App\Services;

use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Generator;

class Api
{
    public function generateJWT($user)
    {
        $key = 'gondalisinuaeandgondalisbestverygoodokok' . $user['timestamp'];
        $signer = new HS256($key);
        $generator = new Generator($signer);
        $jwt = $generator->generate($user);
        return $jwt;
    }
}