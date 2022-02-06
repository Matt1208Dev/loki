<?php

namespace App\Controller;

use DateTime;
use App\Entity\Owner;
use App\Form\OwnerType;
use Faker\Provider\ar_EG\Text;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner/{id}/edit", name="owner_edit")
     */
    public function edit($id, OwnerRepository $ownerRepository, UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em)
    {
        $owner = $ownerRepository->find($id);

        $form = $this->createForm(OwnerType::class);

        $form->setData($owner);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $em->flush();

            return $this->redirectToRoute('owner_show', [
                'id' => $owner->getId()
            ]);
        }

        $formView = $form->createView();

        return $this->render('owner/edit.html.twig', [
            'owner' => $owner,
            'formView' => $formView,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/owner/create", name="owner_create")
     */
    public function create(FormFactoryInterface $factory, UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em): Response
    {
        // Création du builder sans utiliser de classe "Type" personnalisée
        // $builder = $factory->createBuilder(FormType::class, null, [
        //     'data_class' => Owner::class
        // ]);

        // Création du builder en utilisant OwnerType et le FormFactoryInterface
        // $builder = $factory->createBuilder(OwnerType::class);

        // $form = $builder->getForm();

        // Création du formulaire directement avec OwnerType et le raccourci de l'Abstract Controller
        $form = $this->createForm(OwnerType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $owner = $form->getData();
            $owner->setCreatedAt(new DateTime());
            $em->persist($owner);
            $em->flush();

        }

        $formView = $form->createView();

        return $this->render('owner/create.html.twig', [
            'formView' => $formView,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/owner", name="owner_list")
     */
    public function list(OwnerRepository $ownerRepository, UrlGeneratorInterface $urlGenerator)
    {
        $owners = $ownerRepository->findBy([], ['lastName' => 'ASC'], null);

        if (!$owners) {
            throw $this->createNotFoundException("Aucune donnée à afficher");
        }

        return $this->render('owner/list.html.twig', [
            'owners' => $owners,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/owner/{id}", name="owner_show")
     */
    public function show($id, OwnerRepository $ownerRepository, UrlGeneratorInterface $urlGenerator)
    {
        $owner = $ownerRepository->findOneBy([
            'id' => $id
        ]);

        if (!$owner) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render('owner/show.html.twig', [
            'owner' => $owner,
            'urlGenerator' => $urlGenerator
        ]);
    }
}
