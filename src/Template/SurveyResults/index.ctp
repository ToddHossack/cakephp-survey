<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $surveyResults
 */
$options['title'] = 'Surveys';
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <?= $this->element('CsvMigrations.Menu/index_top') ?>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-primary">
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('survey_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('survey_question_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('survey_answer_id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('result') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($surveyResults as $surveyResult) : ?>
                <tr>
                    <td><?= $surveyResult->has('survey') ? $this->Html->link($surveyResult->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyResult->survey->id]) : '' ?></td>
                    <td><?= $surveyResult->has('survey_question') ? $this->Html->link($surveyResult->survey_question->question, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyResult->survey_question->id]) : '' ?></td>
                    <td><?= $surveyResult->has('survey_answer') ? $this->Html->link($surveyResult->survey_answer->answer, ['controller' => 'SurveyAnswers', 'action' => 'view', $surveyResult->survey_answer->id]) : '' ?></td>
                    <td><?= $surveyResult->result;?> </td>
                    <td><?= $surveyResult->has('user') ? $this->Html->link($surveyResult->user->username, ['controller' => 'Users', 'action' => 'view', $surveyResult->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $surveyResult->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $surveyResult->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $surveyResult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveyResult->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
</div>
</section>
