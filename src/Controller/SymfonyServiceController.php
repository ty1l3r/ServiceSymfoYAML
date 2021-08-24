<?php

namespace App\Controller;

use App\Form\OrganizationAddType;
use App\Form\OrganizationsType;
use App\Services\ServicesYAML;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SymfonyServiceController extends AbstractController
{
    /**
     * READ
     * @Route("/", name="accueil")
     */
    public function accueil(ServicesYAML $services): Response
    {
        //SYMFONY SERVICE
        $datasOrganization = $services->ReadOrganizationsYAML();
        return $this->render('symfony_service/accueil.html.twig', [
            'datas' => $datasOrganization,
        ]);
    }

    /**
     * CREATE
     * @Route("/ajouter-une-organisation", name="ajouter_organization")
     */
    public function addOrganization(Request $request, ServicesYAML $services): Response
    {
        $formAddOrganizations = $this->createForm(OrganizationAddType::class);
        $formAddOrganizations->handleRequest($request);
        if ($formAddOrganizations->isSubmitted()
            && $formAddOrganizations->isValid ($formAddOrganizations)) {
            //SYMFONY SERVICE
            $services->CreateOrganization($formAddOrganizations);
            return $this->redirectToRoute('accueil');
        }
        return $this->render('symfony_service/add.html.twig', [
            'formCreateOrganisations' => $formAddOrganizations->createView(),
        ]);
    }

    /**
     * UPDATE
     * @Route("/{dataForm}/modifier", name="update_organizations")
     * @param $dataForm
     * @param ServicesYAML $services
     * @param Request $request
     * @return Response
     */
    public function updateOrganization($dataForm, ServicesYAML $services, Request $request): Response
    {
        //SYMFONY SERVICE
        $organizations = $services->MakeEntityYAMLForm($dataForm);

        $form = $this->createForm(OrganizationsType::class, $organizations);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $services->UpdateForm($organizations, $dataForm);
            return $this->redirectToRoute("accueil");
        }
        return $this->render('symfony_service/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * DELETE
     * @Route("/{dataForm}/delete", name="delete_organizations")
     */
    public function DeleteOrganizations($dataForm, ServicesYAML $services)
    : \Symfony\Component\HttpFoundation\RedirectResponse
    {
        //SYMFONY SERVICE
        $services->DeleteOrganizations($dataForm);
        return $this->redirectToRoute("accueil");
    }


















}
