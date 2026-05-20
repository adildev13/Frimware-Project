<?php

namespace App\Controller;

use App\Entity\SoftwareVersion;
use App\Form\SoftwareVersionType;
use App\Repository\SoftwareVersionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/software-versions')]
class AdminSoftwareVersionController extends AbstractController
{
    #[Route('', name: 'admin_software_versions_index', methods: ['GET'])]
    public function index(SoftwareVersionRepository $repository): Response
    {
        return $this->render('admin/software_version/index.html.twig', [
            'items' => $repository->findBy([], ['name' => 'ASC', 'systemVersionAlt' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_software_versions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $item = new SoftwareVersion();
        $form = $this->createForm(SoftwareVersionType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('admin_software_versions_index');
        }

        return $this->render('admin/software_version/form.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
            'title' => 'Add software version',
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_software_versions_edit', methods: ['GET', 'POST'])]
    public function edit(SoftwareVersion $item, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SoftwareVersionType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_software_versions_index');
        }

        return $this->render('admin/software_version/form.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
            'title' => 'Edit software version',
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_software_versions_delete', methods: ['POST'])]
    public function delete(SoftwareVersion $item, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($item);
        $entityManager->flush();

        return $this->redirectToRoute('admin_software_versions_index');
    }
}
