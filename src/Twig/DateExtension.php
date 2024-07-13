<?php
// src/Twig/DateExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('format_date', [$this, 'formatDate']),
        ];
    }

    public function formatDate($date, $format = 'm/d/Y H:i:s')
    {
        if ($date instanceof \DateTimeInterface) {
            return $date->format($format);
        }

        return $date; // ou retourner null ou une chaîne vide si $date n'est pas une instance de DateTimeInterface
    }
}
