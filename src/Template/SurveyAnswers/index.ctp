<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $surveyAnswers
 */
$options['title'] = 'Question Choices';
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
                            <th scope="col"><?= $this->Paginator->sort('survey_question_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('answer') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($surveyAnswers as $surveyAnswer) : ?>
                    <tr>
                        <td><?= $surveyAnswer->has('survey_question') ? $this->Html->link($surveyAnswer->survey_question->question, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyAnswer->survey_question->id]) : '' ?></td>
                        <td><?= h($surveyAnswer->answer) ?></td>
                        <td><?= h($surveyAnswer->created) ?></td>
                        <td><?= h($surveyAnswer->modified) ?></td>
                        <td class="actions btn-group btn-group-xs">
                            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
                            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'delete', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}?', $surveyAnswer->id)]) ?>
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
</div>
</section>
