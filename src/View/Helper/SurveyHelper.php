<?php
namespace Qobo\Survey\View\Helper;

use Cake\View\Helper;
use Qobo\Survey\Model\Entity\SurveyAnswer;

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
        $score = (string)__d('Qobo/Survey', ' [Score: {0}]', 'N/A');

        if (!is_null($entity)) {
            $score = (string)__d('Qobo/Survey', ' [Score: {0}]', $entity->get('score'));
        }

        $result = "<strong>$score</strong>";

        return $result;
    }
}
