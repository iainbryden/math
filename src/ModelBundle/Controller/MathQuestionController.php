<?php

namespace ModelBundle\Controller;

use ModelBundle\Factory\QuestionFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/mathquestion")
 */
class MathQuestionController extends Controller
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
     * @Route("/{level}")
     * @param string $level
     * @return Response
     */
    public function showLevelAction($level)
    {
        $questionFactory    = new QuestionFactory($level);
        $questions          = $questionFactory->getQuestions();

        return $this->render('ModelBundle:MathQuestion:show.html.twig', array (
            'questions' => $questions,
        ));
    }

    /**
     * @Route("/{level}/json")
     * @param string $level
     * @return Response
     */
    public function showLevelJsonAction($level)
    {
        $questionFactory    = new QuestionFactory($level);
        $questions          = $questionFactory->getQuestions();

        //return new Response($questions);
        $serializer = $this->container->get('serializer');
        $s = $serializer->normalize($questions, 'json');
        $response = new Response(json_encode($s, JSON_PRETTY_PRINT));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

//        return $this->render('ModelBundle:MathQuestion:show.html.twig', array (
//            'questions' => $questions,
//        ));
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
