<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * AddSections shell task.
 */
class AddDefaultSectionsTask extends Shell
{
    const DEFAULT_SECTION_NAME = 'Default';
    const DEFAULT_SECTION_ORDER = 1;
    const DEFAULT_ACTIVE_FLAG = true;

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

        /** @var \Qobo\Survey\Model\Table\SurveyQuestions $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;

        $query = $this->Surveys->find()
            ->where();

        $query->execute();

        if (! $query->count()) {
            $this->info("No surveys found. Quiting...");

            return;
        }

        foreach ($query->all() as $survey) {
            $query = $this->SurveySections->find()
                ->where([
                    'survey_id' => $survey->get('id')
                ]);

            if ($query->count()) {
                $this->info("Skipping. Survey [{$survey->get('name')}] has [" . $query->count(). "] sections.");

                continue;
            }

            $section = $this->SurveySections->newEntity();

            $section->set('name', self::DEFAULT_SECTION_NAME);
            $section->set('survey_id', $survey->get('id'));
            $section->set('active', self::DEFAULT_ACTIVE_FLAG);
            $section->set('order', self::DEFAULT_SECTION_ORDER);

            $saved = $this->SurveySections->save($section);

            if (! $saved) {
                $this->warning("Couldn't save default section for survey {$survey->get('name')} [{$survey->get('id')}]");
            }

            $query = $this->SurveyQuestions->find()
                ->where([
                    'survey_id' => $survey->get('id')
                ]);

            if (! $query->count()) {
                continue;
            }

            $this->info("Linking questions to default section [{$saved->get('id')}]");

            foreach ($query->all() as $question) {
                $question->set('survey_section_id', $saved->get('id'));
                $this->SurveyQuestions->save($question);
            }
        }
    }

    protected function linkQuestionsToSection(string $id): void
    {
        /** @var \Qobo\Survey\Model\Table\SurveyQuestions $table */
        $table = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyQuestions');
        $this->SurveyQuestions = $table;
    }
}
