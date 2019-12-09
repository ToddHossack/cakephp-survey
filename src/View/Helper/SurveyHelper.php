<?php
namespace Qobo\Survey\View\Helper;

use Cake\Datasource\EntityInterface;
use Cake\View\Helper;
use Qobo\Survey\Model\Entity\SurveyAnswer;
use Qobo\Survey\Model\Entity\SurveyQuestion;

class SurveyHelper extends Helper
{
    /**
     * Show Survey Answer defined score
     *
     * @param \Qobo\Survey\Model\Entity\SurveyAnswer|null $entity of the answers
     *
     * @return string $result with defined score.
     */
    public function renderAnswerScore(?SurveyAnswer $entity): string
    {
        $score = (string)__(' [Score: {0}]', 'N/A');

        if (!is_null($entity)) {
            $score = (string)__(' [Score: {0}]', $entity->get('score'));
        }

        $result = "<strong>$score</strong>";

        return $result;
    }
}
