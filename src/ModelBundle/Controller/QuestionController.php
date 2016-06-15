<?php

namespace ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $repo       = $this->getDoctrine()->getRepository("ModelBundle:Question");
        $entities   = $repo->findAll();
        return $this->render('ModelBundle:Question:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * @Route("/{id}")
     * @param string $id
     */
    public function showAction($id)
    {
        $repo       = $this->getDoctrine()->getRepository("ModelBundle:Question");
        $entity     = $repo->find($id);
        return $this->render('ModelBundle:Question:show.html.twig', array(
            'entity' => $entity
        ));
    }

    /**
     * @Route("/add")
     */
    public function addAction()
    {
        return $this->render('ModelBundle:Question:add.html.twig', array(
            // ...
        ));
    }

}
