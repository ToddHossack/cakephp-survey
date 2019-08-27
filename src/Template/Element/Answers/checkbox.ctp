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
$options = [];
$extraAttributes = ['multiple' => 'checkbox'];

foreach ($entity->survey_answers as $item) {
    $text = $item->get('answer');

    if (!empty($showAnswerScore)) {
        $text .= __(' (Weight: {0})', $item->get('score'));
    }
    $options[$item->get('id')] = $text;
}

if (!empty($loadResults)) {
    $submits = $entity->getResultsPerEntry($surveyEntry->get('id'));
    $extraAttributes['value'] = [];

    foreach ($submits as $item) {
        array_push($extraAttributes['value'], $item->get('survey_answer_id'));
    }
}

if (!empty($disabled)) {
    $extraAttributes['disabled'] = true;
}

$key = (isset($key) ? $key . '.' : '');
$id = md5(serialize($options));
echo $this->element('Qobo/Survey.SurveyQuestions/view_extras', ['entity' => $entity, 'id' => $id, 'collapsed' => $collapsed]);
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->id]);?>
        <?= $this->Form->select('SurveyResults.' . $key . 'survey_answer_id', $options, $extraAttributes); ?>
    </div>
</div>
