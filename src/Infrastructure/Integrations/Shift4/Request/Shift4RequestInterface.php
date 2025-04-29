<?php

namespace App\Infrastructure\Integrations\Shift4\Request;

interface Shift4RequestInterface
{
    public function getBody(): array;
}