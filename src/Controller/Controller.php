<?php

namespace App\Controller;

abstract class Controller
{
    protected function render(string $template, array $data = []): void
    {
        extract($data);
        require ROOTPATH . $template . '.php';
    }
}
