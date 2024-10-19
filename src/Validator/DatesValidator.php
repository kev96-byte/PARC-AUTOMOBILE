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

        if ($value instanceof Demande) {
            $mode = $this->context->getRoot()->getConfig()->getOption('mode');
            $oldDateDebutMission = $this->context->getRoot()->getConfig()->getOption('oldDateDebutMission');
            $oldDateFinMission = $this->context->getRoot()->getConfig()->getOption('oldDateFinMission');
            $today = (new \DateTimeImmutable('today'))->format('Y-m-d');
            if ($value->getDateDebutMission()->format('Y-m-d') < $today) {
                $mode = $this->context->getRoot()->getConfig()->getOption('mode');
                dump($mode);
                if ($mode === 'add') {
                    $this->context->buildViolation($constraint->messageStartTodayMission)
                    ->atPath('dateDebutMission')
                    ->addViolation();
                } else {
                    // Vérifier si la date de début de mission a été modifiée
                    $dateDebutModified = $value->getDateDebutMission()->format('Y-m-d') != $oldDateDebutMission->format('Y-m-d');
                    // Si la DateDebutMission a été modifiée et elle est dans le passé, bloquer la modification
                    if ($dateDebutModified && $value->getDateDebutMission()->format('Y-m-d') < $today) {
                        $this->context->buildViolation($constraint->messageStartTodayMissionModified)                    
                        ->atPath('dateDebutMission')
                        ->addViolation();
                    }
                }
                    
            } elseif ($value->getDateFinMission()->format('Y-m-d') < $today) {
                $mode = $this->context->getRoot()->getConfig()->getOption('mode');
                if ($mode === 'add') {
                    $this->context->buildViolation($constraint->messageEndTodayMission)
                    ->atPath('dateFinMission')
                    ->addViolation();
                } else {
                    // Vérifier si la date de fin de mission a été modifiée
                    $dateFinModified = $value->getDateFinMission()->format('Y-m-d') != $oldDateFinMission->format('Y-m-d');
                    // Si la DateFinMission a été modifiée et elle est dans le passé, bloquer la modification
                    if ($dateFinModified && $value->getDateFinMission()->format('Y-m-d') < $today) {                    
                        $this->context->buildViolation($constraint->messageEndTodayMissionModified)
                        ->atPath('dateFinMission')
                        ->addViolation();
                    }
                }
            } elseif ($value->getDateFinMission() < $value->getDateDebutMission()) {
                $this->context->buildViolation($constraint->messageEndMission)
                ->atPath('dateFinMission')
                ->addViolation();
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
