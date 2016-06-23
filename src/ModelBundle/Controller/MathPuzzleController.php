<?php

namespace ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * @Route("/mathpuzzle")
 */
class MathPuzzleController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $repo       = $this->getDoctrine()->getRepository("ModelBundle:Question");
        $entities   = $repo->findAll();
        return $this->render('ModelBundle:MathPuzzle:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * @Route("/{id}")
     * @param string $id
     */
    public function showAction($id)
    {

        if ($this->container->has('profiler'))
        {
            $this->container->get('profiler')->disable();
        }

        /** @var Question $entity **/
        $repo       = $this->getDoctrine()->getRepository("ModelBundle:Question");
        $entities   = $repo->findAll();
        $prev = 0;
        $next = 0;
        $self = 0;
        $index = 0;
        $entityArray = [];
        foreach ($entities as $entity) {
            $index++;
            $entityArray[$index] = $entity;
            if ($entity->getId() == $id) {
                $prev = $index-1;
                $self = $index;
                $next = $index+1;
            }
        }
        $prevEntity     = ($prev>0) ? $entityArray[$prev] : null;
        $entity         = $entityArray[$self];
        $nextEntity     = ($next < count($entityArray)) ? $entityArray[$next] : null;

        return $this->render('ModelBundle:MathPuzzle:show.html.twig', array(
            'prevEntity'    => $prevEntity,
            'entity'        => $entity,
            'nextEntity'    => $nextEntity,
        ));
    }

    /**
     * @Route("/add")
     */
    public function addAction()
    {
        return $this->render('ModelBundle:MathPuzzle:add.html.twig', array(
            // ...
        ));
    }

}
