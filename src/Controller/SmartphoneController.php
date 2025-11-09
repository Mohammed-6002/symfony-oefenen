<?php
namespace App\Controller;

use App\Entity\Smartphone;
use App\Form\SmartphoneType;
use App\Repository\SmartphoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmartphoneController extends AbstractController
{
    #[Route('/smartphone', name: 'app_smartphone')]
    public function index(SmartphoneRepository $smartphoneRepository): Response
    {
        return $this->render('smartphone/index.html.twig', [
            'smartphones' => $smartphoneRepository->findAll(),
        ]);
    }

    #[Route('/smartphone/{id}', name: 'app_view_smartphone')]
    public function view(SmartphoneRepository $smartphoneRepository, int $id): Response
    {
        $smartphone = $smartphoneRepository->find($id);
        if (!$smartphone) { throw $this->createNotFoundException('Smartphone not found'); }
        return $this->render('smartphone/view.html.twig', ['smartphone' => $smartphone]);
    }

    #[Route('/smartphone-add', name: 'app_add_smartphone')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $smartphone = new Smartphone();
        $form = $this->createForm(SmartphoneType::class, $smartphone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($smartphone);
            $em->flush();
            $this->addFlash('success', 'Smartphone has been added');
            return $this->redirectToRoute('app_smartphone');
        }
        return $this->render('smartphone/add.html.twig', ['form' => $form]);
    }

    #[Route('/smartphone-update/{id}', name: 'app_update_smartphone')]
    public function update(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $smartphone = $em->getRepository(Smartphone::class)->find($id);
        if (!$smartphone) { throw $this->createNotFoundException('Smartphone not found'); }
        $form = $this->createForm(SmartphoneType::class, $smartphone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Smartphone has been updated');
            return $this->redirectToRoute('app_smartphone');
        }
        return $this->render('smartphone/update.html.twig', ['form' => $form, 'smartphone' => $smartphone]);
    }

    #[Route('/smartphone-delete/{id}', name: 'app_delete_smartphone')]
    public function delete(EntityManagerInterface $em, int $id): Response
    {
        $smartphone = $em->getRepository(Smartphone::class)->find($id);
        if ($smartphone) {
            $em->remove($smartphone);
            $em->flush();
            $this->addFlash('danger', 'Smartphone has been removed');
        }
        return $this->redirectToRoute('app_smartphone');
    }
}
