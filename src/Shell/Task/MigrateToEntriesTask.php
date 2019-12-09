<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * Following script allows us to migrate to newer
 * version of `cakephp-survey` plugin v5.0.0.
 *
 * We split `survey_results` into separate tables that will let us keep the
 * data split:
 * 1. `survey_entries` - to keep track of submitted surveys
 * 2. `survey_entry_questions` - to keep track of entry questions submitted
 * 3. `survey_results` will be attached to entry tables to keep the scoring clean.
 */
class MigrateToEntriesTask extends Shell
{
    protected $Surveys;

    protected $SurveyEntries;

    protected $SurveyEntryQuestions;

    protected $SurveyResults;

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * Initializing tables that will be used for the migration.
     *
     * @return void
     */
    public function initTables(): void
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys');
        $this->Surveys = $table;

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $this->SurveyResults = $table;

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntries');
        $this->SurveyEntries = $table;

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntryQuestions');
        $this->SurveyEntryQuestions = $table;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out((string)__d('Qobo/Survey', 'Preparing migration of existing surveys to new structure'));

        $this->initTables();

        $surveyEntriesIds = $this->createSurveyEntries();

        if (empty($surveyEntriesIds)) {
            $this->out((string)__d('Qobo/Survey', 'No submitted surveys found. Exiting'));

            return true;
        }

        $questionEntryIds = $this->createSurveyEntryQuestions($surveyEntriesIds);

        if (!empty($questionEntryIds)) {
            foreach ($questionEntryIds as $questionEntryId) {
                $this->linkEntryQuestionToSurveyResults($questionEntryId);
            }
        }
    }

    /**
     * Iterate through `survey_results` and create survey_entries
     * with matching `submit_id` for `survey_entries` primary key
     *
     * @return mixed[] $result with survey_entries.id array
     */
    protected function createSurveyEntries(): array
    {
        $result = [];
        $query = $this->SurveyResults->find();
        $count = 0;

        $this->out((string)__d('Qobo/Survey', 'Found [{0}] survey_result records', $query->count()));

        if (empty($query->count())) {
            return $result;
        }

        foreach ($query as $item) {
            $survey = $this->Surveys->find()
                ->where(['id' => $item->get('survey_id')]);

            if (!$survey->count()) {
                $this->warn((string)__d('Qobo/Survey', 'Survey [{0}] is not found. Moving on', $item->get('survey_id')));

                continue;
            }

            $entry = $this->SurveyEntries->find()
                ->where([
                    'id' => $item->get('submit_id'),
                ])
                ->first();

            if (empty($entry)) {
                if (empty($item->get('submit_id'))) {
                    continue;
                }

                $entry = $this->SurveyEntries->newEntity();
                $entry->set('id', $item->get('submit_id'));
                $entry->set('submit_date', $item->get('submit_date'));
                $entry->set('survey_id', $item->get('survey_id'));
                $entry->set('status', 'in_review');
                $entry->set('score', 0);

                $saved = $this->SurveyEntries->save($entry);

                if ($saved) {
                    $result[] = $saved->get('id');
                    $count++;
                } else {
                    $this->out((string)__d('Qobo/Survey', 'Survey Result with Submit ID [{0}] cannot be saved. Next', $item->get('submit_id')));
                }
            } else {
                // saving existing survey_entries,
                // to double check if anything is missing as well.
                $result[] = $entry->get('id');
            }
        }

        $this->out((string)__d('Qobo/Survey', 'Saved [{0}] survey_entries', $count));

        //keeping only unique entry ids, to avoid excessive iterations.
        $result = array_values(array_unique($result));

        return $result;
    }

    /**
     * Iterate through survey Entry ids and create corresponding survey_entry_questions
     * records that carry survey_entry_id and questions that been submitted to it.
     *
     * These instances will be matched to `survey_results`.`survey_entry_question_id`
     *
     * @param mixed[] $entryIds array of survey_entries ids
     *
     * @return mixed[] $result with entry_question_id list
     */
    protected function createSurveyEntryQuestions(array $entryIds = []): array
    {
        $result = [];
        $count = 0;

        if (empty($entryIds)) {
            $this->out((string)__d("Qobo/Survey", "Not `survey_entries` passed to create Survey Entry Questions"));

            return $result;
        }

        foreach ($entryIds as $entryId) {
            $query = $this->SurveyResults->find()
                ->where([
                    'submit_id' => $entryId,
                ]);

            $this->out((string)__d('Qobo/Survey', 'Found [{0}] for survey results Entry ID: [{1}]', $query->count(), $entryId));

            if (empty($query->count())) {
                $this->out((string)__d('Qobo/Survey', 'No survey_results found for {0} entry. Skipping', $entryId));

                continue;
            }

            foreach ($query as $surveyResultEntity) {
                $questionEntry = $this->SurveyEntryQuestions->find()
                    ->where([
                        'survey_entry_id' => $entryId,
                        'survey_question_id' => $surveyResultEntity->get('survey_question_id'),
                    ])
                    ->first();

                if (!empty($questionEntry)) {
                    $result[] = $questionEntry->get('id');

                    continue;
                }

                $questionEntry = $this->SurveyEntryQuestions->newEntity();
                $questionEntry->set('survey_entry_id', $entryId);
                $questionEntry->set('survey_question_id', $surveyResultEntity->get('survey_question_id'));

                $saved = $this->SurveyEntryQuestions->save($questionEntry);

                if ($saved) {
                    $result[] = $saved->get('id');
                    $count++;
                } else {
                    $this->out((string)__d('Qobo/Survey', 'Couldnt save survey_entry_question record for {0} entryId', $entryId));
                    $this->out(print_r($questionEntry->getErrors(), true));
                }
            }
        }

        $this->out((string)__d('Qobo/Survey', 'Saved {0} survey_entry_question record', $count));

        return $result;
    }

    /**
     * Link SurveyResults entries to survey_entry_questions.id
     *
     * @param string $questionEntryId of the survey_entry_questions instance
     *
     * @return void
     */
    private function linkEntryQuestionToSurveyResults(string $questionEntryId): void
    {
        $questionEntry = $this->SurveyEntryQuestions->get($questionEntryId);
        $count = 0;

        $query = $this->SurveyResults->find()
            ->where(
                [
                    'submit_id' => $questionEntry->get('survey_entry_id'),
                    'survey_question_id' => $questionEntry->get('survey_question_id'),
                ]
            );

        if (empty($query->count())) {
            $this->out(
                (string)__d(
                    'Qobo/Survey',
                    'No submits found for entry ID {0} and Question ID {1}',
                    $questionEntry->get('survey_entry_id'),
                    $questionEntry->get('survey_question_id')
                )
            );

            return;
        }

        $answersTable = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyAnswers');

        foreach ($query as $submit) {
            $submit->set('survey_entry_question_id', $questionEntryId);

            /** @var \Qobo\Survey\Model\Entity\SurveyAnswer|null $answer */
            $answer = $answersTable->find()
                ->where([
                    'id' => $submit->get('survey_answer_id'),
                ])
                ->first();

            if (!empty($answer)) {
                $submit->set('score', $answer->get('score'));
            }

            $saved = $this->SurveyResults->save($submit);
            if ($saved) {
                $count++;
            } else {
                $this->out(print_r($submit->getErrors(), true));
            }
        }

        $this->out((string)__d('Qobo/Survey', 'Updated {0} with survey_entry_question_id: {1}', $count, $questionEntryId));
    }
}
