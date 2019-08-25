<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Qobo\Survey\Model\Entity;

use Cake\ORM\Entity;

/**
 * SurveyQuestion Entity
 *
 * @property string $id
 * @property string $survey_id
 * @property string $question
 * @property string $type
 * @property bool $active
 * @property bool $is_required
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $trashed
 *
 * @property \Qobo\Survey\Model\Entity\Survey $survey
 */
class SurveyQuestion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Get Score of the question based on Survey Entry id
     *
     * @param string $id of the survey entries instance
     *
     * @return int|float $result;
     */
    public function getScorePerEntry(string $id)
    {
        $result = 0;

        // `scores` assigned to answers.
        if (empty($this->get('survey_answers'))) {
            return $result;
        }

        $map = [];

        foreach ($this->get('survey_answers') as $answer) {
            $map[$answer->get('id')] = [
                'score' => $answer->get('score'),
                'quantity' => 0
            ];
        }

        foreach ($this->get('survey_answers') as $answer) {
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
