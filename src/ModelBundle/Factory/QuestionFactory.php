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
    private $level;
    public function __construct($level)
    {
        $this->level = $level;
    }
    /**
     * @param int $level
     */
    public function getQuestions()
    {
        $questions = [];
        for ($i = 0; $i < 30; $i++) {
            $questions[] = $this->getQuestion();
        }

        return $questions;
    }

    /**
     * @param int $level
     */
    public function getQuestion()
    {
        switch($this->level) {
            case(QuestionLevels::LEVEL_1):
                return $this->getQuestionLevelOne();
            break;
            case(QuestionLevels::LEVEL_2);
                return $this->getQuestionLevelTwo();
            break;
            case(QuestionLevels::LEVEL_3);
                return $this->getQuestionLevelThree();
            break;
            default:
                return $this->getQuestionLevelOne();
        }
    }

    private function getQuestionLevelOne()
    {
        $question                   = [];
        $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 10);
        $question['operator']       = $this->getRandomOperator([Operators::ADD, Operators::SUBTRACT]);

        $this->calculateResult($question);

        return $question;
    }


    private function getQuestionLevelTwo()
    {
        $question                   = [];
        $operator                   = $this->getRandomOperator([Operators::ADD, Operators::SUBTRACT, Operators::MULTIPLY, Operators::DIVIDE]);
        $question['operator']       = $operator;

        switch (end($operator)) {
        case (Operators::ADD):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 100);
            break;
        case (Operators::SUBTRACT):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 100, NumberOrder::HIGHER_FIRST);
            break;
        case (Operators::MULTIPLY):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, [100, 2]);
            break;
        case (Operators::DIVIDE):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 10);
            break;
        }

        $this->calculateResult($question);

        return $question;
    }

    private function getQuestionLevelThree()
    {
        $question                   = [];
        $operator                   = $this->getRandomOperator([Operators::DIVIDE]);
        $question['operator']       = $operator;

        switch (end($operator)) {
        case (Operators::ADD):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 100);
            break;
        case (Operators::SUBTRACT):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 100, NumberOrder::HIGHER_FIRST);
            break;
        case (Operators::MULTIPLY):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, [100, 2]);
            break;
        case (Operators::DIVIDE):
            $question['sourceNumbers']  = $this->getRandomSourceNumbers(2, 10);
            break;
        }

        $this->calculateResult($question);

        return $question;
    }

    private function getRandomOperator($allowed = null)
    {
        $operators  = Operators::getAllOperators($allowed);
        $rand       = rand(0, count($operators) -1 );

        return array_slice($operators, $rand, 1, true);
    }

    private function getRandomSourceNumbers($count, $highestValue, $numberOrder = NumberOrder::ANY)
    {
        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            if (is_array($highestValue) && count($highestValue) >= $i ) {
                $numbers[] = rand(0, $highestValue[$i]);
            } else {
                $numbers[] = rand(0, $highestValue);
            }
        }
        switch($numberOrder) {
            case (NumberOrder::HIGHER_FIRST):
                arsort($numbers);
                break;
            case (NumberOrder::LOWER_FIRST):
                asort($numbers);
                break;
        }

        return $numbers;
    }

    private function calculateResult(&$question)
    {
        switch (end($question['operator'])) {
            case (Operators::ADD):
                $val = 0;
                foreach ($question['sourceNumbers'] as $number) {
                    $val += $number;
                }
                $question['result'] = $val;
                break;
            case (Operators::SUBTRACT):
                $iteration = 0;
                $val = 0;
                foreach ($question['sourceNumbers'] as $number) {
                    $val = ($iteration++ == 0) ? $number : $val - $number;
                }
                $question['result'] = $val;
                break;
            case (Operators::MULTIPLY):
                $iteration = 0;
                $val = 0;
                foreach ($question['sourceNumbers'] as $number) {
                    $val = ($iteration++ == 0) ? $number : $val * $number;
                }
                $question['result'] = $val;
                break;
            case (Operators::DIVIDE):
                // 3 x 2 = 6     -- sort higher first
                // 6 % 3 = 2     -- swap result and first number
                // 5 % 0 = ?     -- avoid divide by zero
                $iteration  = 0;
                $val        = 0;
//                if (in_array('0', $numbers)) { // if there's a zero here, make it first and just set the answer to 0
//                    asort($numbers); // low to high
//                    $question['result'] = 0;
//                    $question['sourceNumbers']  = $numbers;
//                } else {
                    arsort($question['sourceNumbers']); // high to low
                    foreach ($question['sourceNumbers'] as $number) {
                        $val = ($iteration++ == 0) ? $number : $val * $number;
                    }
                    // swap first number with the answer
                    $firstNumber                    = &$question['sourceNumbers'][0];
                    $question['sourceNumbers'][0]   = $val;
                    $question['result']             = $firstNumber;
//                }
                break;
        }

    }
}