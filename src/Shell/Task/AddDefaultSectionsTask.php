<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * AddSections shell task.
 * @method \Cake\Console\ConsoleIo info($message = null, $newlines = 1, $level = self::NORMAL)
 * @method \Cake\Console\ConsoleIo warning($message = null, $newlines = 1)
 */
class AddDefaultSectionsTask extends Shell
{
    /** @var \Qobo\Survey\Model\Table\SurveysTable $Surveys */
    public $Surveys;

    /** @var \Qobo\Survey\Model\Table\SurveySectionsTable $SurveySections */
    public $SurveySections;

    /** @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $SurveyQuestions */
    public $SurveyQuestions;

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
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        /** @var \Qobo\Survey\Model\Table\SurveysTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.Surveys');
        $this->Surveys = $table;

        /** @var \Qobo\Survey\Model\Table\SurveySectionsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveySections');
        $this->SurveySections = $table;

        $query = $this->Surveys->find()
            ->where();

        $query->execute();

        if (! $query->count()) {
            $this->info("No surveys found. Quiting...");

            return true;
        }

        foreach ($query->all() as $survey) {
            $query = $this->SurveySections->find()
                ->where([
                    'survey_id' => $survey->get('id')
                ]);

            if ($query->count()) {
                $this->info("Skipping. Survey [{$survey->get('name')}] has [" . $query->count() . "] sections.");

                continue;
            }

            $saved = $this->SurveySections->createDefaultSection($survey->get('id'));

            if (! $saved instanceof EntityInterface) {
                $this->warning("Couldn't save default section for survey {$survey->get('name')} [{$survey->get('id')}]");
                continue;
            } else {
                $this->success("Created Section [{$saved->get('name')}] for survey [{$survey->get('name')}]. Updating questions..");
            }

            $updated = $this->linkQuestionsToSection($survey, $saved->get('id'));

            if (empty($updated)) {
                continue;
            }

            foreach ($updated as $questionId => $status) {
                if (!$status) {
                    $this->warning("Question [$questionId] update status [" . (bool)$status . "]");
                } else {
                    $this->info("Question [$questionId] update status [" . (bool)$status . "]");
                }
            }
        }
        $this->hr();
        $this->out("Done updating surveys. Exiting..");

        return true;
    }

    /**
     * Link Questions to Survey Section
     *
     * @param \Cake\Datasource\EntityInterface $survey instance
     * @param string $sectionId of the section
     *
     * @return mixed[] $result with question id and status of update.
     */
    protected function linkQuestionsToSection(EntityInterface $survey, string $sectionId): array
    {
        $result = [];

        /** @var \Qobo\Survey\Model\Table\SurveyQuestionsTable $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;

        $query = $this->SurveyQuestions->find()
            ->where([
                'survey_id' => $survey->get('id')
            ]);

        if (! $query->count()) {
            return $result;
        }

        foreach ($query->all() as $question) {
            $question->set('survey_section_id', $sectionId);
            if ($this->SurveyQuestions->save($question)) {
                $result[$question->get('id')] = true;
            } else {
                $result[$question->get('id')] = false;
            }
        }

        return $result;
    }
}
