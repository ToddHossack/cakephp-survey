<?php
namespace Qobo\Survey\View\Helper;

use Cake\Datasource\EntityInterface;
use Cake\View\Helper;

class SurveyHelper extends Helper
{
    /**
     * Calculate question score based on answers submitted to the question
     *
     * @param \Cake\Datasource\EntityInterface $question containing Answers/Results entities
     * @param string $id of the survey entry submitted.
     *
     * @return int $result of the score.
     */
    public function getQuestionScore(EntityInterface $question, string $id) : int
    {
        $result = 0;

        // `scores` assigned to answers.
        if (empty($question->get('survey_answers'))) {
            return $result;
        }

        $map = [];

        foreach ($question->get('survey_answers') as $answer) {
            $map[$answer->get('id')] = [
                'score' => $answer->get('score'),
                'quantity' => 0
            ];
        }

        foreach ($question->get('survey_answers') as $answer) {
            if (empty($answer->get('survey_results'))) {
                continue;
            }

            foreach ($answer->get('survey_results') as $item) {
                if ($item->get('submit_id') !== $id) {
                    continue;
                }

                if ($item->get('survey_answer_id') == $answer->get('id')) {
                    $map[$item->get('survey_answer_id')]['quantity'] += 1;
                }
            }
        }

        foreach ($map as $answerID => $info) {
            $result += ($info['score'] * $info['quantity']);
        }

        return $result;
    }
}
