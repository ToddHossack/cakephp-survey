<?= $this->Form->create($entity)?>
<?= $this->Form->hidden('SurveyResults.survey_id', ['value' => $entity->survey_id]);?>
<?= $this->Form->hidden('SurveyResults.survey_question_id', ['value' => $entity->id]);?>
<?php $answer = $entity->survey_answers[0]; ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->hidden('SurveyResults.survey_answer_id', ['value' => $answer->id]);?>
        <?= $this->Form->input('SurveyResults.result', ['type' => 'text', 'placeholder' => $answer->comment]); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
    <?= $this->Form->submit(__('Proceed'));?>
    </div>
</div>
<?= $this->Form->end();?>
