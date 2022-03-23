<?php

namespace App\Controller\admin;

use App\Repository\FormationRepository;
use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormationsController extends AbstractController
{
    /**
     *
     * @var FormationRepository
     */
    private $repository;
    /**
     *
     * @var EntityManagerInterface
     */
    private $om;
    /**
     *
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository, EntityManagerInterface $om)
    {
        $this->repository = $repository;
        $this->om = $om;
    }
    /**
     * @route("/admin",name="admin.formations")
     * @return Response
     */
    public function index(): Response
    {
        $formations = $this->repository->findAllOrderBy('publishedAt', 'DESC');
        return $this->render("admin/formations.html.twig", [
            'formations' => $formations
        ]);
    }
    /**
     * @Route("/admin/suppr/{id}",name="admin.formations.suppr")
     * @param Formation $formation
     * @return Response
     */
    public function suppr(Formation $formation): Response
    {
        $this->om->remove($formation);
        $this->om->flush();
        return $this->redirectToRoute('admin.formations');
    }
    /**
     * @Route("/admin/ajout",name="admin.formations.ajout")
     *  @return Response
     */
    public function ajout(Request $request): Response
    {
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted() && $formFormation->isValid()) {
            $this->om->persist($formation);
            $this->om->flush();
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/formations.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
    /**
     * @Route("/admin/edit/{id}",name="admin.formations.edit")
     * @param Formation $formation
     * @return Response
     */
    public function edit(Formation $formation, Request $request): Response
    {

        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        if ($formFormation->isSubmitted() && $formFormation->isValid()) {
            $this->om->persist($formation);
            $this->om->flush();
            return $this->redirectToRoute('admin.formations');
        }
        return $this->render("admin/formations.edit.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);
    }
}
