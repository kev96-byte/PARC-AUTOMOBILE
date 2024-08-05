<?php
// src/Twig/CustomTwigExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Loader\FilesystemLoader;

class CustomTwigExtension extends AbstractExtension
{
    private $loader;

    public function __construct(FilesystemLoader $loader)
    {
        $this->loader = $loader;
    }

    public function addCustomPath(string $namespace, string $path)
    {
        $this->loader->addPath($path, $namespace);
    }

    // Add other methods for your Twig extension as needed
}

