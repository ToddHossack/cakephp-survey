<?php
$options = [];
foreach ($entity->survey_answers as $item) {
    $options[] = [
        'value' => $item->id,
        'text' => $item->answer
    ];
}

$key = (isset($key) ? $key . '.' : '');
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->id]);?>
        <?= $this->Form->radio('SurveyResults.' . $key . 'survey_answer_id', $options); ?>
    </div>
</div>
