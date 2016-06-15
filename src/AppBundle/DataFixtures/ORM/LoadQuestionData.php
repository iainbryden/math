<?php
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\Question;

/**
 * Created by PhpStorm.
 * User: aprilbryden
 * Date: 6/14/16
 * Time: 8:01 PM
 */
class LoadQuestionData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new Question();
        $userAdmin->setQuestion('Why');
        $userAdmin->setAnswer('Because');

        $manager->persist($userAdmin);
        $manager->flush();
    }
}