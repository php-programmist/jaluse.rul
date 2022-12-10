<?php

namespace App\Controller\Admin;

use App\Form\ChangeUriType;
use App\Model\Admin\ChangeUri;
use App\Service\ImportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ChangeUriController extends AbstractController
{
    /**
     * @Route("/admin/change-uri", name="admin_change_uri")
     */
    public function changeUri(Request $request, ImportManager $manager): Response
    {
        $changeUriDto = new ChangeUri();
        $form         = $this->createForm(ChangeUriType::class, $changeUriDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $updated  = $manager->changeUri($changeUriDto);
                $redirect = $manager->getRedirect($changeUriDto);
            } catch (Throwable $e){
                $this->addFlash('warning', $e->getMessage());
            }
        }
        
        return $this->render('admin/change-uri/index.html.twig', [
            'form'     => $form->createView(),
            'updated'  => $updated ?? [],
            'redirect' => $redirect ?? '',
        ]);
    }
}