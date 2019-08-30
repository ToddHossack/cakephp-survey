<?php
namespace Qobo\Survey\View\Helper;

use Cake\Datasource\EntityInterface;
use Cake\View\Helper;
use Qobo\Survey\Model\Entity\SurveyQuestion;

class SurveyHelper extends Helper
{
    /**
     * Calculate question score based on answers submitted to the question
     *
     * @param \Qobo\Survey\Model\Entity\SurveyQuestion $question containing Answers/Results entities
     * @param string $id of the survey entry submitted.
     *
     * @return int|float $result of the score.
     */
    public function getQuestionScore(SurveyQuestion $question, string $id)
    {
        return $question->getScorePerEntry($id);
    }
}
