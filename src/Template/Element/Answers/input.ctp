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
$answer = $entity->survey_answers[0];
$key = (isset($key) ? $key . '.' : '');
$id = md5($answer);

$options = [
    'type' => 'text',
    'placeholder' => $answer->get('comment'),
];

if (!empty($loadResults)) {
    $submits = $entity->getResultsPerEntry($surveyEntry->get('id'));
    if (!empty($submits)) {
        foreach ($submits as $item) {
            $options['value'] = $item->get('result');
        }
    }
}

if (!empty($disabled)) {
    $options['readonly'] = true;
}

echo $this->element('Qobo/Survey.SurveyQuestions/view_extras', ['entity' => $entity, 'id' => $id, 'collapsed' => $collapsed]);
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->get('id')]);?>
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_answer_id', ['value' => $answer->get('id')]);?>
        <?= $this->Form->control('SurveyResults.' . $key . 'result', $options); ?>
    </div>
</div>
