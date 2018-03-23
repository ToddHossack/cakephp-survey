<table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
    <thead>
        <tr>
            <th scope="col"><?= __('Question') ?></th>
            <th scope="col"><?= __('Type') ?></th>
            <th scope="col"><?= __('Active') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($survey->survey_questions as $surveyQuestion) : ?>
    <tr>
        <td><?= h($surveyQuestion->question) ?></td>
        <td><?= h($questionTypes[$surveyQuestion->type]) ?></td>
        <td><?= h($surveyQuestion->active) ?></td>
        <td class="actions btn-group btn-group-xs">
            <?= $this->Html->link('<i class="fa fa-file"></i>', ['controller' => 'SurveyQuestions', 'action' => 'preview', $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'SurveyQuestions', 'action' => 'edit', $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'SurveyQuestions', 'action' => 'delete', $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}?', $surveyQuestion->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

