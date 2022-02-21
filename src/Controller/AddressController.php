<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddressController extends AbstractController
{
    #[Route('/admin/address', name: 'admin_address_index')]
    public function index(AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findAll();
        return $this->render('admin/address.html.twig', [
            'addresses' => $address,
        ]);
    }

    #[Route('/admin/address/create', name: 'address_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été ajoutée');
            return $this->redirectToRoute('admin_address_index');
        }
        return $this->render('admin/addressForm.html.twig', [
            'addressForm' => $form->createView()
        ]);
    }

    #[Route('/admin/address/update/{id}', name: 'address_update')]
    public function update(AddressRepository $addressRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $address = $addressRepository->find($id);
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($address);
            $manager->flush();
            $this->addFlash('success', 'L\'adresse a bien été modifiée');
            return $this->redirectToRoute('admin_address_index');
        }
            
        return $this->render('admin/addressForm.html.twig', [
            'addressForm' => $form->createView(),
            'addresses' => $address
        ]);
    }

    #[Route('/admin/address/delete/{id}', name: 'address_delete')]
    public function delete(AddressRepository $addressRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $address = $addressRepository->find($id);
                
        $manager = $managerRegistry->getManager();
        $manager->remove($address);
        $manager->flush();
        $this->addFlash('success', 'L\'adresse a bien été supprimée');
        return $this->redirectToRoute('admin_address_index');
    }
}
