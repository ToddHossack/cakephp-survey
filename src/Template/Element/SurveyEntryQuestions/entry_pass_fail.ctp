<div class="box-footer">
<?php if (!empty($questionEntry)) : ?>
    <?= $this->Form->hidden('SurveyEntryQuestions.' . $key . '.id', ['value' => $questionEntry->get('id')]) ?>
    <?= $this->Form->radio(
        'SurveyEntryQuestions.' . $key . '.status',
        [
            ['value' => 'pass', 'text' => __('Pass')],
            ['value' => 'fail', 'text' => __('Fail')]
        ],
        [
            'value' => $questionEntry->get('status')
        ]
    ) ?>
    <hr/>
    <h4>Score: <?= $questionEntry->get('score') ?> </h4>
<?php else: ?>
    <h4><?= __('Score: 0 (No answers submitted)') ?></h4>
<?php endif;?>
</div>
