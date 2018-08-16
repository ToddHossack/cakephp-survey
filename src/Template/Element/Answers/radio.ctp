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
foreach ($entity->survey_answers as $item) {
    $options[] = [
        'value' => $item->id,
        'text' => $item->answer
    ];
}

$key = (isset($key) ? $key . '.' : '');

if (!empty($entity->extras)) {
    echo $entity->extras;
}
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->id]);?>
        <?= $this->Form->radio('SurveyResults.' . $key . 'survey_answer_id', $options); ?>
    </div>
</div>
