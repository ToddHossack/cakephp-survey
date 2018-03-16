<?php
$answer = $entity->survey_answers[0];

$key = (isset($key) ? $key . '.' : '');

?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_question_id', ['value' => $entity->id]);?>
        <?= $this->Form->hidden('SurveyResults.' . $key . 'survey_answer_id', ['value' => $answer->id]);?>
        <?= $this->Form->input('SurveyResults.' . $key . 'result', ['type' => 'textarea', 'placeholder' => $answer->comment]); ?>
    </div>
</div>
