<?php
$isDisabled = !isset($isDisabled) ? false : $isDisabled;
?>
<div class="box-footer">
<?php if (!empty($questionEntry)) : ?>
    <?= $this->Form->hidden('SurveyEntryQuestions.' . $key . '.id', ['value' => $questionEntry->get('id')]) ?>
    <?= $this->Form->radio(
        'SurveyEntryQuestions.' . $key . '.status',
        [
            ['value' => 'pass', 'text' => __d('Qobo/Survey', 'Pass')],
            ['value' => 'fail', 'text' => __d('Qobo/Survey', 'Fail')],
        ],
        [
            'value' => ($questionEntry->isEmpty('status')) ? 'pass' : $questionEntry->get('status'),
            'disabled' => $isDisabled,
        ]
    ) ?>
    <hr/>
    <h4>Score: <?= $questionEntry->get('score') ?> </h4>
<?php else: ?>
    <h4><?= __d('Qobo/Survey', 'Score: 0 (No answers submitted)') ?></h4>
<?php endif;?>
</div>
