<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class DatesConstraint extends Constraint
{
    public $messageStartTodayMission = 'La date de début de mission ne peut pas être antérieure à aujourd\'hui.';
    public $messageEndTodayMission = 'La date de fin de mission ne peut pas être antérieure à aujourd\'hui.';
    public $messageStartTodayMissionModified = 'La date de début de mission ne peut pas être antérieure à aujourd\'hui.';
    public $messageEndTodayMissionModified = 'La date de fin de mission ne peut pas être antérieure à aujourd\'hui.';
    public $messageDateDemande = 'La date de la demande ne peut pas être antérieure à aujourd\'hui.';
    public $messageStartMission = 'La date de début de mission ne peut pas être antérieure à la date de demande.';
    public $messageEndMission = 'La date de fin de mission ne peut pas être antérieure à la date de début de mission.';
    public $messageEndAssurance = "La date de fin d\'assurance ne peut pas être antérieure à la date de début d\'assurance.";
    public $messageEndVisite = 'La date de fin de visite ne peut pas être antérieure à la date de début de visite.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return DatesValidator::class;
    }
}
