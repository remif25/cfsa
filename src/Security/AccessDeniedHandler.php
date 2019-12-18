<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/12/2019
 * Time: 08:34
 *
 * Copyright 2018-2019, Rémi Fongaufier, All rights reserved.
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $content = [];

        return new Response($content, 403);
    }
}