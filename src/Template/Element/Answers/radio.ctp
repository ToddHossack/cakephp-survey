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
$extraAttributes = [];

foreach ($entity->get('survey_answers') as $item) {
    $options[] = [
        'value' => $item->get('id'),
        'text' => $item->get('answer'),
    ];
}

if (!empty($options) && !empty($loadResults)) {
    $submits = $entity->getResultsPerEntry($surveyEntry->get('id'));
    if (!empty($submits)) {
        foreach ($options as $k => $item) {
            foreach ($submits as $submit) {
                if ($item['value'] == $submit->get('survey_answer_id')) {
                    $options[$k]['checked'] = true;
                }
            }
        }
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
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->get('id')]);?>
        <?= $this->Form->radio('SurveyResults.' . $key . 'survey_answer_id', $options, $extraAttributes); ?>
    </div>
</div>
