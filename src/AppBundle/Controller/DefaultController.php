<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Translation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/category", name="category")
     */
    public function categoryAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Category');
        $repositoryTranslation = $em->getRepository('Gedmo\Translatable\Entity\Translation');

        $food = new Category();
        $food->setTitle('Food');

        $fruits = new Category();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Category();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);

        $em->persist($food);
        $em->persist($fruits);
        $em->persist($vegetables);
        $em->persist($carrots);
        $em->flush();


        $category = $repository->findOneBy(['title' => 'Fruits']);
        $category->setTitle('Voce');
        $category->setTranslatableLocale('sr_RS');
        $em->persist($category);
        $em->flush();

        // load category with given locale

        $category = $repository->findOneBy(['title' => 'Fruits']);
        $category->setTranslatableLocale('sr_RS');
        $em->refresh($category);

        dump($category);

        //load all translations for category

        $category = $repository->findOneBy(['title' => 'Fruits']);
        $translations = $repositoryTranslation->findTranslations($category);

        dump($translations);
        die();
    }
}
