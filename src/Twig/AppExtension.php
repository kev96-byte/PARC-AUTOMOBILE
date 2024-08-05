<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Service\DemandeService;

class AppExtension extends AbstractExtension
{
    private $demandeService;

    public function __construct(DemandeService $demandeService)
    {
        $this->demandeService = $demandeService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('nombre_demandes_validees', [$this, 'getNombreDemandesValidees']),
        ];
    }

    public function getNombreDemandesValidees()
    {
        return $this->demandeService->getNombreDemandesValidees();
    }
}
