<?php

namespace App\Controller;

use App\Repository\NiveauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;

/**
 * Description of FormationsController
 *
 * @author emds
 */
class FormationsController extends AbstractController
{

    private const PAGEFORMATIONS = "pages/formations.html.twig";

    /**
     *
     * @var FormationRepository
     */
    private $repository;
    /**
     *
     * @var NiveauRepositoryRepository
     */
    private $nivrepository;

    /**
     * 
     * @param FormationRepository $repository
     */
    function __construct(FormationRepository $repository,NiveauRepository $nivrepository)
    {
        $this->repository = $repository;
        $this->nivrepository = $nivrepository;
    }

    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response
    {
        $formations = $this->repository->findAll();
        return $this->render(self::PAGEFORMATIONS, [
            'formations' => $formations
        ]);
    }

    /**
     * @Route("/formations/tri/{champ}/{ordre}", name="formations.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response
    {
        $formations = $this->repository->findAllOrderBy($champ, $ordre);
        return $this->render(self::PAGEFORMATIONS, [
            'formations' => $formations
        ]);
    }

    /**
     * @Route("/formations/recherche/{champ}", name="formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    public function findAllContain($champ, Request $request): Response
    {

        if ($this->isCsrfTokenValid('filtre_' . $champ, $request->get('_token'))) {
            $valeur1 = $request->get("recherche");
            $valeur2 = $request->get("filtreniveau");
            if($champ=="title"){
            $formations = $this->repository->findByContainValue($champ, $valeur1);
            }
            else{
                $niveau = $this->nivrepository->findOneByName($valeur2);
                $formations=$niveau->getFormations();
            }
            return $this->render(self::PAGEFORMATIONS, [
                'formations' => $formations
            ]);
        }
        return $this->redirectToRoute("formations");
    }

    /**
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response
    {
        $formation = $this->repository->find($id);
        return $this->render("pages/formation.html.twig", [
            'formation' => $formation
        ]);
    }
}
