<?php
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use ModelBundle\Entity\Question;

/**
 * Created by PhpStorm.
 * Date: 6/14/16
 * Time: 8:01 PM
 */
class LoadQuestionData implements FixtureInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function load(ObjectManager $manager)
    {
        /** @var EntityManager entityManager */
        $this->entityManager = $manager;

        $q = new Question();
        $q->setQuestion('What does a nosey pepper do?');
        $q->setAnswer('Gets jalapeno business');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What do you call a fake noodle?');
        $q->setAnswer('An Impasta');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What do you call an alligator in a vest?');
        $q->setAnswer('An Investigator');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What happens if you eat yeast and shoe polish?');
        $q->setAnswer('Every morning you\'ll rise and shine');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What\'s the difference between a guitar and a fish?');
        $q->setAnswer('You can\'t tuna fish.');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What musical instrument is found in the bathroom?');
        $q->setAnswer('A tuba toothpaste.');
        $this->entityManager->persist($q);

        $q = new Question();
        $q->setQuestion('What do you call cheese that\'s not yours?');
        $q->setAnswer('Nacho cheese!');
        $this->entityManager->persist($q);

        $this->loadFromFile();

        $this->entityManager->flush();
    }

    private function loadFromFile()
    {



        $em         = $this->entityManager;
        $filePath   = __DIR__."/Questions.ini";
        $text       = file_get_contents($filePath);
        $textArray  = explode("\n", $text);

        $q = "";
        $a = "";
//        $iteration = 0;
//        for ($i = 0; $i < count($textArray); $i++) {
//            $iteration++;
//            if ($iteration == 1) {
//                $q = $textArray[$i];
//            }
//            if ($iteration == 2) {
//                $a = $textArray[$i];
//                $entity = new Question();
//                $entity->setQuestion($q);
//                $entity->setAnswer($a);
//                $em->persist($entity);
//            }
//            if ($iteration == 3) {
//                $iteration = 0;
//            }
//        }

        $iteration = 0;
        $lines = file($filePath);
        foreach ($lines as $line_num => $line) {
            $iteration++;
            if ($iteration == 1) {
                $q = $line;
            }
            if ($iteration == 2) {
                echo "\n$line_num : " . htmlspecialchars($line);
                $a = htmlspecialchars(str_replace("\n", "", $line));
                $entity = new Question();
                $entity->setQuestion($q);
                $entity->setAnswer($a);
                $em->persist($entity);
            }
            if ($iteration == 3) {
                $iteration = 0;
            }
        }
    }
}