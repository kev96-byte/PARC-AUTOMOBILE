<?php
// src/Twig/GlobalVariablesExtension.php

namespace App\Twig;

use App\Entity\User;
use Twig\TwigFunction;
use AllowDynamicProperties;
use Psr\Log\LoggerInterface;
use App\Repository\VisiteRepository;
use App\Repository\DemandeRepository;
use App\Repository\VidangeRepository;
use Twig\Extension\AbstractExtension;
use App\Repository\AffecterRepository;
use App\Repository\VehiculeRepository;
use App\Repository\AssuranceRepository;
use App\Repository\ChauffeurRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



#[AllowDynamicProperties] class GlobalVariablesExtension extends AbstractExtension
{
    private $vehiculeRepository;
    private $chauffeurRepository;
    private $demandeRepository;
    private $affecterRepository;
    private $tokenStorage;
    private $logger;
    private $assuranceRepository;
    private $visiteRepository;
    private $vidangeRepository;

    public function __construct(TokenStorageInterface $tokenStorage, LoggerInterface $logger, VehiculeRepository $vehiculeRepository, ChauffeurRepository $chauffeurRepository, DemandeRepository $demandeRepository, AssuranceRepository $assuranceRepository, VisiteRepository $visiteRepository, VidangeRepository $vidangeRepository, AffecterRepository $affecterRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->vehiculeRepository = $vehiculeRepository;
        $this->chauffeurRepository = $chauffeurRepository;
        $this->demandeRepository = $demandeRepository;
        $this->affecterRepository = $affecterRepository;
        $this->logger = $logger;
        $this->assuranceRepository = $assuranceRepository;
        $this->visiteRepository = $visiteRepository;
        $this->vidangeRepository = $vidangeRepository;
    }




    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombreVehiculesDisponibles', [$this, 'getNombreVehiculesDisponibles']),
            new TwigFunction('nombreChauffeursDisponibles', [$this, 'getNombreChauffeursDisponibles']),
            new TwigFunction('nombreTotalVehicules', [$this, 'getNombreTotalVehicules']),
            new TwigFunction('nombreDemandes', [$this, 'getNombreDemandes']),
            new TwigFunction('nombreDemandeVehiculesParUtilisateur', [$this, 'getNombreDemandeVehiculesParUtilisateur']),
            new TwigFunction('lieuVehiculeMission', [$this, 'getLieuVehiculeMission']),
            new TwigFunction('nombreChauffeursInMission', [$this, 'getNombreChauffeursInMission']),
            new TwigFunction('getUser', [$this, 'getUser']),
            new TwigFunction('nombreChauffeursTotal', [$this, 'getNombreChauffeursTotal']),
            new TwigFunction('nombreVehiculesTotal', [$this, 'getNombreVehiculesTotal']),
            new TwigFunction('nombreVehiclesInMission', [$this, 'getNombreVehiclesInMission']),
            new TwigFunction('nombreDemandesEnAttente', [$this, 'getNombreDemandesEnAttente']),
            new TwigFunction('nombreDemandesInitieeByPointFocal', [$this, 'getNombreDemandesInitieeByPointFocal']),
            new TwigFunction('nombreDemandesForPointFocalApprouvees', [$this, 'getNombreDemandesForPointFocalApprouvees']),
            new TwigFunction('nombreDemandesApprouveesByResponsableStructure', [$this, 'getNombreDemandesApprouveesByResponsableStructure']),
            new TwigFunction('nombreDemandesTraiteesByChefParc', [$this, 'getNombreDemandesTraiteesByChefParc']),
            new TwigFunction('nombreAllDemandesEnAttenteDApprobation', [$this, 'getAllDemandesEnAttenteDApprobation']),
            new TwigFunction('nombreAllDemandesEnAttenteDeTraitement', [$this, 'getAllDemandesEnAttenteDeTraitement']),
            new TwigFunction('nombreDemandesRejetees', [$this, 'getDemandesRejetees']),
            new TwigFunction('nombreAssurancesNonvalides', [$this, 'getNombreAssurancesNonvalides']),
            new TwigFunction('nombreVisitesNonvalides', [$this, 'getNombreVisitessNonvalides']),
            new TwigFunction('nombreVidangesNonvalides', [$this, 'getNombreVidangesNonvalides']),
            new TwigFunction('nombreMissionsAFinaliser', [$this, 'getNombreMissionsAFinaliser']),
            new TwigFunction('nombreVehiclesJamaisAssure', [$this, 'getNombreVehiclesJamaisAssure']),
            new TwigFunction('nombreVehiclesJamaisVisite', [$this, 'getNombreVehiclesJamaisVisite']),
            new TwigFunction('nombreVehiclesSansVidange', [$this, 'getNombreVehiclesSansVidange']),
        ];
    }

    public function getNombreMissionsAFinaliser(): int
    {
        return $this->demandeRepository->countExpiredMissions();
    }

    public function getNombreVehiculesDisponibles(): int
    {
        return $this->vehiculeRepository->countAvailableVehicles();
    }


    public function getNombreChauffeursDisponibles(): int
    {
        return $this->chauffeurRepository->countAvailableChauffeurs();
    }



    public function getNombreTotalVehicules(): int
    {
        return $this->vehiculeRepository->countAllAvailableVehicles();
    }



    public function getNombreAssurancesNonvalides() : int
    {
        return $this->assuranceRepository->countAssurancesNonvalides();
    }

    public function getNombreVisitessNonvalides() : int
    {
        return $this->visiteRepository->countVisitesNonvalides();
    }

    public function getNombreVidangesNonvalides() : int
    {
        return $this->vehiculeRepository->countVidangesNonvalides();
    }



    public function getNombreDemandeVehiculesParUtilisateur(int $idUtilisateur) : int
    {
        return $this->demandeRepository->countAllDemandesByUser($idUtilisateur);
    }



    public function getLieuVehiculeMission(int $idVehicule) : array
    {
        $lieux = $this->affecterRepository->findLieuxByVehiculeId($idVehicule);
        return array_column($lieux, 'lieu');
    }


    public function getNombreDemandes() : int
    {
        return $this->demandeRepository->countAllDemandes();
    }


    public function getNombreDemandesInitieeByPointFocal(): ?int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            $roles = $user->getRoles();
            if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
                $nombreDemandesInitieeByPointFocal = $this->demandeRepository->countDemandesInitieeByPointFocal($user);

                return $nombreDemandesInitieeByPointFocal;
            }



        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }
    public function getNombreVehiclesJamaisAssure(): int
    {
        return $this->vehiculeRepository->countVehiclesJamaisAssure();
    }


    public function getNombreVehiclesJamaisVisite(): int
    {
        return $this->vehiculeRepository->countVehiclesJamaisVisite();
    }


    public function getNombreVehiclesSansVidange(): int
    {
        return $this->vehiculeRepository->countVehiclesSansVidange();
        }

    public function getNombreChauffeursInMission(): int
    {
        return $this->chauffeurRepository->countChauffeursInMission();
        }

    public function getNombreChauffeursTotal(): int
    {
        return $this->chauffeurRepository->count(['deleteAt' =>null]);
    }

    public function getNombreDemandesForPointFocalApprouvees(): ?int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            $roles = $user->getRoles();
            if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
                $nombreDemandesForPointFocalApprouvees = $this->demandeRepository->countDemandesForPointFocalApprouvees($user);

                return $nombreDemandesForPointFocalApprouvees;
            }



        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }


    public function getNombreVehiclesInMission(): int
    {
        return $this->vehiculeRepository->countVehiclesInMission();
        }



    public function getNombreDemandesTraiteesByChefParc(): int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            $roles = $user->getRoles();
            if (in_array('ROLE_CHEF_PARC', $roles, true)) {
                $nombreDemandesTraiteesByChefParc = $this->demandeRepository->countDemandesTraiteesByValidateur($user);

                return $nombreDemandesTraiteesByChefParc;
            }



        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }






    public function getNombreDemandesApprouveesByResponsableStructure(): ?int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            $roles = $user->getRoles();
            if (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
                $nombreDemandesApprouveesByResponsableStructure = $this->demandeRepository->countDemandesApprouveesByResponsableStructure($user);

                return $nombreDemandesApprouveesByResponsableStructure;
            }




        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }

    public function getNombreVehiculesTotal(): int
    {
        return $this->vehiculeRepository->count(['deleteAt' =>null]);
    }



    public function getAllDemandesEnAttenteDApprobation(): int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            $roles = $user->getRoles();

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            if (in_array('ROLE_CABINET', $roles, true) OR in_array('ROLE_ADMIN', $roles, true)) {
                $institution = $user->getInstitution();
                $nombreAllDemandesEnAttenteDApprobation = $this->demandeRepository->countAllDemandesEnAttenteDApprobation($institution);
            }

            return $nombreAllDemandesEnAttenteDApprobation;


        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }


    public function getAllDemandesEnAttenteDeTraitement(): int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            $roles = $user->getRoles();

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            if (in_array('ROLE_CABINET', $roles, true) OR in_array('ROLE_ADMIN', $roles, true)) {
                $institution = $user->getInstitution();
                $nombreAllDemandesEnAttenteDeTraitement = $this->demandeRepository->countAllDemandesEnAttenteDeTraitement($institution);
            }

            return $nombreAllDemandesEnAttenteDeTraitement;


        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }





    public function getNombreDemandesEnAttente(): ?int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            $roles = $user->getRoles();

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
                $nombreDemandesEnAttente = $this->demandeRepository->countApprobateurDemandesEnAttente($user);

            } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
                // Récupération de la structure de l'utilisateur connecté
                $structure = $user->getStructure();
                $nombreDemandesEnAttente = $this->demandeRepository->countApprobateurDemandesEnAttente($structure);


            } elseif (in_array('ROLE_VALIDATEUR', $roles, true)) {
                // Récupération du parc du chef de parc
                $parc = $user->getStructure()->getParc();

                // Récupération des structures associées à ce parc
                $structures = $parc->getStructure();

                // Parcourir chaque structure pour récupérer les demandes
                $nombreDemandesEnAttente = 0;
                foreach ($structures as $structure) {
                    $nombreDemandesEnAttente = $nombreDemandesEnAttente + $this->demandeRepository->countValidateurDemandesEnAttente($structure);
                }
            } else {
                $institution = $user->getInstitution();
                $nombreDemandesEnAttente = $this->demandeRepository->countApprobateurDemandesEnAttente($institution);


            }

            return $nombreDemandesEnAttente;


        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }

    public function getDemandesRejetees(): ?int
    {
        try {
            // Vérifie si un token existe
            $token = $this->tokenStorage->getToken();
            if (null === $token) {
                $this->logger->error('Aucun jeton d\'authentification trouvé.');
                throw new AuthenticationException('Aucun jeton trouvé. L\'utilisateur n\'est peut-être pas connecté.');
            }

            // Récupère l'utilisateur depuis le token
            $user = $token->getUser();

            // Vérifie si l'utilisateur est bien un objet (utilisateur authentifié)
            if (!is_object($user)) {
                $this->logger->warning('L\'utilisateur n\'est pas authentifié ou est anonyme.');
                throw new AuthenticationException('L\'utilisateur n\'est pas authentifié.');
            }

            $roles = $user->getRoles();

            if (!$user instanceof User) {
                throw new AccessDeniedException('L\'utilisateur n\'est pas connecté.');
            }

            if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
                $nombreDemandesRejetees = $this->demandeRepository->countDemandesForPointFocalRejetees($user);

            } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
                $nombreDemandesRejetees = $this->demandeRepository->countDemandesRejeteesByResponsableStructure($user);


            } elseif (in_array('ROLE_VALIDATEUR', $roles, true)) {
                $nombreDemandesRejetees = $this->demandeRepository->countDemandesRejeteesByValidateur($user);

            } else {
                $institution = $user->getInstitution();
                $nombreDemandesRejetees = $this->demandeRepository->countAllDemandesRejeteesForInstitution($institution);


            }

            return $nombreDemandesRejetees;


        } catch (AuthenticationException $e) {
            // Gère l'exception d'authentification
            $this->logger->error('Erreur d\'authentification : ' . $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Gère toute autre erreur imprévue
            $this->logger->error('Une erreur inattendue est survenue : ' . $e->getMessage());
            return null;
        }
    }

}
