<?php

namespace App\Controller\admin;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminNiveauxController extends AbstractController
{
    /**
     *
     * @var NiveauRepository
     */
    private $repository;
    /**
     *
     * @var EntityManagerInterface
     */
    private $om;
    /**
     *
     * @param NiveauRepository $repository
     */
    public function __construct(NiveauRepository $repository, EntityManagerInterface $om)
    {
        $this->repository = $repository;
        $this->om = $om;
    }
    /**
     * @route("/admin/niveaux",name="admin.niveaux")
     * @return Response
     */
    public function index(): Response
    {
        $niveaux = $this->repository->findAll();
        return $this->render("admin/niveaux.html.twig", [
            'niveaux' => $niveaux
        ]);
    }
    /**
     * @Route("/admin/niveaux/suppr/{id}",name="admin.niveaux.suppr")
     * @param Niveau $niveau
     * @return Response
     */
    public function suppr(Niveau $niveau): Response
    {
        $this->om->remove($niveau);
        $this->om->flush();
        return $this->redirectToRoute('admin.niveaux');
    }
    /**
     * @Route("/admin/niveaux/ajout",name="admin.niveaux.ajout")
     */
    public function ajout(Request $request): Response
    {
        $nomNiveau = $request->get("leveltitle");
        $niveau = new Niveau;
        $niveau->setLeveltitle($nomNiveau);
        $this->om->persist($niveau);
        $this->om->flush();
        return $this->redirectToRoute('admin.niveaux');
    }
}
