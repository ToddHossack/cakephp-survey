<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * MoveSurveyResultsToEntryQuestions shell task.
 */
class MoveSurveyResultsToEntryQuestionsTask extends Shell
{
    public $SurveyResults;

    public $SurveyEntryQuestions;

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

    public function initTables() : void
    {
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $this->SurveyResults = $table;

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
        $this->out((string)__('Migrating `survey_question_id` into survey_entry_questions table from `survey_results`'));
        $this->initTables();

        // create survey_entry_questions entities.
        $this->createSurveyEntryQuestions();

        // link existing survey_results records to `survey_entry_question_id`
        $this->linkSurveyEntryQuestionsToResults();

        return true;
    }

    /**
     * Create Survey Entry Questions entities from survey_results
     *
     * @return void
     */
    protected function createSurveyEntryQuestions() : void
    {
        $count = 0;
        $query = $this->SurveyResults->find();

        if (empty($query->count())) {
            $this->out((string)__('No submitted results found'));

            return;
        }

        foreach ($query as $resultEntity) {
            $entryQuestion = $this->SurveyEntryQuestions->find()
                ->where([
                    'survey_entry_id' => $resultEntity->get('submit_id'),
                    'survey_question_id' => $resultEntity->get('survey_question_id')
                ])
                ->first();

            if (!$entryQuestion) {
                $entity = $this->SurveyEntryQuestions->newEntity();
                $entity->set('survey_entry_id', $resultEntity->get('submit_id'));
                $entity->set('survey_question_id', $resultEntity->get('survey_question_id'));

                $result = $this->SurveyEntryQuestions->save($entity);

                if ($result) {
                    $count++;
                } else {
                    $this->warning((string)__("Couldn't save entity for {0} : {1}", $resultEntity->get('submit_id'), $resultEntity->get('survey_question_id')));
                }
            }
        }

        $this->success((string)__('Saved {0} survey_entry_question new records', $count));
    }

    /**
     * Link Survey Entry Question records to `survey_results` records.
     *
     * @return void
     */
    protected function linkSurveyEntryQuestionsToResults() : void
    {
        $questionEntries = $this->SurveyEntryQuestions->find();
        $count = 0;
        if (empty($questionEntries->count())) {
            $this->out((string)__('No SurveyEntry Questions found. Existing'));

            return;
        }

        foreach ($questionEntries as $entry) {
            $results = $this->SurveyResults->find()
                ->where([
                    'submit_id' => $entry->get('survey_entry_id'),
                    'survey_question_id' => $entry->get('survey_question_id')
                ]);

            if (empty($results->count())) {
                continue;
            }

            foreach ($results as $entity) {
                if (!$entity->isEmpty('survey_entry_question_id')) {
                    continue;
                }

                $entity->set('survey_entry_question_id', $entry->get('id'));

                $saved = $this->SurveyResults->save($entity);
                if ($saved) {
                    $count++;
                } else {
                    pr($entity->getErrors());
                }
            }
        }

        $this->out((string)__('Updates {0} survey_results with survey_entry_question_id', $count));
    }
}
