<?php
$options = [];
foreach ($entity->survey_answers as $item) {
    $options[] = [
        'value' => $item->id,
        'text' => $item->answer
    ];
}
?>
<?= $this->Form->create($entity)?>
<?= $this->Form->hidden('SurveyResults.survey_id', ['value' => $entity->survey_id]);?>
<?= $this->Form->hidden('SurveyResults.survey_question_id', ['value' => $entity->id]);?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <?= $this->Form->radio('SurveyResults.survey_answer_id', $options); ?>
    </div>
</div>
<?= $this->Form->submit(__('Save Result'));?>
<?= $this->Form->end();?>
<hr/>
<?php
if ($this->request->params['action'] == 'preview') {
    if (!empty($savedResults)) {
        pr($savedResults);
    }
}
?>
