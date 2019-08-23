<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * MigrateScoresToSurveyResults shell task.
 *
 *
 *
 * @property \Qobo\Survey\Model\Table\SurveyEntriesTable $SurveyEntries
 * @property \Qobo\Survey\Model\Table\SurveyResultsTable $SurveyResults
 */
class MigrateScoresToSurveyResultsTask extends Shell
{
    public $SurveyEntries;

    public $SurveyResults;

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
     * Initialize all required task properties to complete the task
     *
     * @return void
     */
    public function init() : void
    {
        /** @var \Qobo\Survey\Model\Table\SurveyEntriesTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntries');
        $this->SurveyEntries = $table;

        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $this->SurveyResults = $table;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->info((string)__('Migrating the scores from existing survey_entries to survey_results'));

        // preparing required properties for the migration
        $this->init();

        if (!$this->hasEntries()) {
            $this->info((string)__('No Survey submits found. Exiting'));

            return true;
        }

        $entries = $this->SurveyEntries->find()
            ->where(['id' => 'e2032854-4870-49b5-af94-5375afb0e208'])
            ->contain(['SurveyResults']);

        foreach ($entries->all() as $entry) {
            $tree = $this->getSurveyResultsTree($entry);

            if (empty($tree)) {
                $this->out(
                    (string)__(
                        'No tree information for survey entry [{0}]. Next..',
                        $entry->get('id')
                    )
                );
                continue;
            }

            /** @var string $entryId */
            foreach ($tree as $entryId => $questions) {
                foreach ($questions as $qId => $answers) {
                    $status = $this->setSurveyResultsScore($entryId, $qId, $answers);
                }
            }
        }
    }

    /**
     * Check if survey entries are present in the table.
     *
     * @return bool $result if any found
     */
    protected function hasEntries() : bool
    {
        $query = $this->SurveyEntries->find();

        $result = $query->count() ? true : false;

        return $result;
    }

    /**
     * To avoid overhead, we simply store key/value data in a submit tree,
     * that will be easier to process.
     *
     * Tree Structure:
     *  'survey_entry_id' => [
     *    'survey_question_id' => [
     *        'survey_answer_id' => score,
     *        'survey_answer_id' => score
     *     ]
     *     ...
     *  ]
     *
     * @param \Cake\Datasource\EntityInterface $entry of the survey_entries instance
     *
     * @return mixed[] $data array containing survey_results tree.
     */
    protected function getSurveyResultsTree(EntityInterface $entry) : array
    {
        $data = [];
        $submit = $this->SurveyResults->find()
            ->where([
                'submit_id' => $entry->get('id')
            ])
            ->contain(['SurveyQuestions', 'SurveyAnswers']);

        if (empty($submit->count())) {
            return $data;
        }

        $entryId = $entry->get('id');

        foreach ($submit as $item) {
            $question = $item->get('survey_question');
            $answer = $item->get('survey_answer');

            $qId = $question->get('id');
            $aId = $answer->get('id');
            $score = $answer->get('score');

            if (!isset($data[$entryId][$qId])) {
                $data[$entryId][$qId] = [];
            }

            $data[$entryId][$qId] = array_merge($data[$entryId][$qId], [$aId => $score]);
        }

        return $data;
    }

    /**
     *  Update Score fields of each survey_results entry
     *
     * @param string $entryId of the survey_entries table
     * @param string $questionId of the survey_questions table
     * @param mixed[] $answers that contain key/value store of `answer_id` => `score` values
     *
     * @return bool $result
     */
    protected function setSurveyResultsScore(string $entryId, string $questionId, array $answers = []) : bool
    {
        $result = false;

        if (empty($answers)) {
            return $result;
        }

        $query = $this->SurveyResults->find()
            ->where([
                'submit_id' => $entryId,
                'survey_question_id' => $questionId,
                'survey_answer_id IN' => array_keys($answers),
            ]);

        if (!$query->count()) {
            return $result;
        }

        foreach ($query as $item) {
            $aId = $item->get('survey_answer_id');

            $item->set('score', $answers[$aId]);
            $saved = $this->SurveyResults->save($item);

            if ($saved) {
                $result = true;
            } else {
                $this->warn(
                    (string)__(
                        "Entry [{0}] Result ID: [{1}]: Couldn't update score for Question [{2}]. Answer ID [{3}]",
                        $entryId,
                        $item->get('id'),
                        $questionId,
                        $aId
                    )
                );
            }
        }

        return $result;
    }
}
