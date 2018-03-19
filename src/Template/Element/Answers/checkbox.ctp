<?php
$options = [];
foreach ($entity->survey_answers as $item) {
    $options[$item->id] = $item->answer;
}

$key = (isset($key) ? $key . '.' : '');
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->id]);?>
        <?= $this->Form->select('SurveyResults.' . $key . 'survey_answer_id', $options, ['multiple' => 'checkbox']); ?>
    </div>
</div>
