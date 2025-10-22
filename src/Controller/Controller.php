<?php

namespace App\Controller;

abstract class Controller
{
    protected function render(string $template, array $data = []): void
    {
        extract($data);
        require_once ROOTPATH .'src/' . $template . '.php';
    }
}
