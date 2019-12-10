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

$attributes = [
    'type' => 'select',
    'options' => [],
    'empty' => __d('Qobo/Survey', '-- Choose Answer --')
];

foreach ($entity->get('survey_answers') as $item) {
    $attributes['options'][$item->get('id')] = $item->get('answer');
}

$key = (isset($key) ? $key . '.' : '');
$id = md5(serialize($attributes['options']));

echo $this->element('Qobo/Survey.SurveyQuestions/view_extras', ['entity' => $entity, 'id' => $id, 'collapsed' => $collapsed]);
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->get('id')]);?>
        <?= $this->Form->control('SurveyResults.' . $key . 'survey_answer_id', $attributes); ?>
    </div>
</div>
