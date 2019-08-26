<?php
$surveyId = empty($survey->get('slug')) ? $survey->get('id') : $survey->get('slug');
$resourceUser = $surveyEntry->get('resource_user');

$options['title'] = __(
    '{0} &raquo; {1} &raquo; {2}',
    $this->Html->link(__('Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    __('Submit at "{0}" by "{1}"', $surveyEntry->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm'), $resourceUser['displayField'])
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                Aha!
            </h3>
        </div>
        <div class="box-body">Content</div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                Details
            </h3>
        </div>
        <div class="box-body">Pass/Fail</div>
    </div>
</section>
