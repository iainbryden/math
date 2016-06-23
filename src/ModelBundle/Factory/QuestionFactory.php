<?php
namespace ModelBundle\Factory;
/**
 * Created by PhpStorm.
 * User: aprilbryden
 * Date: 6/23/16
 * Time: 1:28 PM
 */
class QuestionFactory
{
    /**
     * @param int $level
     */
    public function getQuestions($level = QuestionLevels::LEVEL_1)
    {
        $questions = [];
        for ($i = 0; $i < 10; $i++) {
            $questions[] = $this->getQuestion($level);
        }

        return $questions;
    }

    /**
     * @param int $level
     */
    public function getQuestion($level)
    {
        switch($level) {
            case(QuestionLevels::LEVEL_1):
                return $this->getQuestionLevelOne();
            break;
            case(QuestionLevels::LEVEL_2);
                return $this->getQuestionLevelTwo();
            break;
        }
        return null;
    }

    private function getQuestionLevelOne()
    {
        $question                   = [];
        $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 10);
        $question['operator']       = $this->getRandomOperator([Operators::ADD, Operators::SUBTRACT]);

        $this->calculateResult($question, QuestionLevels::LEVEL_1);

        return $question;
    }


    private function getQuestionLevelTwo()
    {
        $question                   = [];
        $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 10);
        $question['operator']       = $this->getRandomOperator([Operators::MULTIPLY]);

        $this->calculateResult($question, QuestionLevels::LEVEL_2);

        return $question;
    }

    private function getRandomOperator($allowed = null)
    {
        $operators  = Operators::getAllOperators($allowed);
        $rand       = rand(0, count($operators) -1 );

        return array_slice($operators, $rand, 1, true);
    }

    private function getRandomSourceNumbers($count, $highestValue)
    {
        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = rand(0, $highestValue);
        }
        return $numbers;
    }

    private function calculateResult(&$question, $level)
    {
        //$question['whatIsThis'] = end($question['operator']);

        switch (end($question['operator'])) {
            case (Operators::ADD):
                $val = 0;
                foreach($question['sourceNumbers'] as $number) {
                    $val += intval($number);
                }
                $question['result'] = $val;
                break;
            case (Operators::SUBTRACT):
                // TODO: sort from hi to low value before calculating if avoiding negative numbers (based on $level).
                $iteration = 0;
                $val = 0;
                foreach($question['sourceNumbers'] as $number) {
                    $val = ($iteration++ == 0) ? $number : $val - $number;
                }
                $question['result'] = $val;
                break;
            case (Operators::MULTIPLY):
                $iteration = 0;
                $val = 0;
                foreach($question['sourceNumbers'] as $number) {
                    $val = ($iteration++ == 0) ? $number : $val * $number;
                }
                $question['result'] = $val;
                break;
        }

    }
}