<?php
namespace App\Controller;
   use App\Entity\Listing;
   use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
   use Doctrine\ORM\EntityManagerInterface;
   use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
   use Symfony\Component\HttpFoundation\Request;
   use Symfony\Component\HttpFoundation\Response;
   use Symfony\Component\Routing\Annotation\Route;
   use Symfony\Flex\Command\Remove;

/**
  * @Route("/", name="listing_")
  */

class ListingController extends AbstractController {

    /**
     * @Route("/{listingId}", name="show", requirements={"listingId"="\d+"})
     */
    public function show(EntityManagerInterface $entityManager, $listingId=null) {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

        if (!empty($listingId)) {
            $currentListing = $entityManager->getRepository(Listing::class)->find($listingId);
        }
        if (empty($currentListing)) {
            $currentListing = current($listings);
        }
        return $this->render('Listing.html.twig',[
            'listings' => $listings,
            'currentListing' => $currentListing
            ]);
    }

    /**
     * @Route("/{listingId}/delete", name="delete", requirements={"listingId"="\d+"})
     */
    public function delete(EntityManagerInterface $entityManager, $listingId) {
        $listing = $entityManager->getRepository(Listing::class)->find($listingId);

        if (empty($listingId)) {
            $this->addFlash (
                "warning",
                "Impossible de supprimer la liste"
            );
        } else {
            $entityManager->remove($listing);
            $entityManager->flush();
            $name = $listing->getName();

            $this->addFlash (
                "success",
                "La liste « $name » a été supprimée avec succès"
            );
        }
        return $this->redirectToRoute('listing_show');
    }

    /**
     * @Route("/new", methods="POST", name="create")
     */
    public function create(EntityManagerInterface $entityManager, Request $request) {
        $name = $request->get('name');

        if (empty($name)) {
            $this->addFlash ("warning", "un nom de liste est obligatoire");
            return $this->redirectToRoute('listing_show');
        }

        $listing = new Listing();
        $listing->setName($name);
        try {
            $entityManager->persist($listing);
            $entityManager->flush();
            /*return new Response("OK");*/
            $this->addFlash (
                "success",
                "La liste « $name » a été crée avec succès"
            );
        } catch (UniqueConstraintViolationException $e) {
            $this->addFlash (
                "danger",
                "La liste « $name » existe déjà !"
            );
        }
        return $this->redirectToRoute('listing_show');
    }
}