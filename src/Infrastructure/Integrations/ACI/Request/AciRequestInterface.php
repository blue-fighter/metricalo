<?php

namespace App\Infrastructure\Integrations\ACI\Request;

interface AciRequestInterface
{
    public function getBody(): array;
}