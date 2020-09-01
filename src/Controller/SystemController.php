<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\System;
use App\Form\SystemType;
use Symfony\Component\HttpFoundation\Request;
use App\Utils\Flasher;

class SystemController extends AbstractController {

    /**
     * @Route("/update-system", name="update_system", methods={"POST","GET"})
     */
    public function updateSystem(Request $request, Flasher $flasher) {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(System::class);
        $systemObj = $repo->getSystemSettings();

        $formObj = $this->createForm(SystemType::class, $systemObj);
        $formObj->handleRequest($request);

        if ($formObj->isSubmitted() && $formObj->isValid()) {
            $systemObj = $formObj->getData();

             $entityManager->persist($systemObj);
             $entityManager->flush();
                
            $flasher->flashSuccess('Changes have been saved!');
                     
           return $this->redirectToRoute("invoice_list");
        }

        

        return $this->render('system/system_settings.html.twig', [
                    'systemObj' => $systemObj,
                    'formObj' => $formObj->createView(),
        ]);
    }

}
