<?php

namespace App\Validator;

use App\Entity\Visite;
use App\Entity\Demande;
use App\Entity\Assurance;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DatesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DatesConstraint) {
            throw new UnexpectedTypeException($constraint, DatesConstraint::class);
        }

        if (!$value instanceof Demande && !$value instanceof Assurance && !$value instanceof Visite) {
            throw new UnexpectedValueException($value, 'Demande, Assurance, or Visite');
        }

        $today = new \DateTimeImmutable('today');

        if ($value instanceof Demande) {
            // Validate Demande specific constraints
            if ($value->getDateDebutMission() && $value->getDateDebutMission() < $today) {
                $this->context->buildViolation($constraint->messageStartTodayMission)
                    ->atPath('dateDebutMission')
                    ->addViolation();
            }

            if ($value->getDateDebutMission() && $value->getDateDemande()) {
                if ($value->getDateDebutMission() < $value->getDateDemande()) {
                    $this->context->buildViolation($constraint->messageStartMission)
                        ->atPath('dateDebutMission')
                        ->addViolation();
                }
            }

            if ($value->getDateFinMission() && $value->getDateDebutMission()) {
                if ($value->getDateFinMission() < $value->getDateDebutMission()) {
                    $this->context->buildViolation($constraint->messageEndMission)
                        ->atPath('dateFinMission')
                        ->addViolation();
                }
            }
        }

        if ($value instanceof Assurance) {
            // Validate Assurance specific constraints
            if ($value->getDateFinAssurance() && $value->getDateDebutAssurance()) {
                if ($value->getDateFinAssurance() < $value->getDateDebutAssurance()) {
                    $this->context->buildViolation($constraint->messageEndAssurance)
                        ->atPath('dateFinAssurance')
                        ->addViolation();
                }
            }
        }

        if ($value instanceof Visite) {
            // Validate Visite specific constraints
            if ($value->getDateFinVisite() && $value->getDateDebutVisite()) {
                if ($value->getDateFinVisite() < $value->getDateDebutVisite()) {
                    $this->context->buildViolation($constraint->messageEndVisite)
                        ->atPath('dateFinVisite')
                        ->addViolation();
                }
            }
        }
    }
}
