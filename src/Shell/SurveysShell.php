<?php
namespace Qobo\Survey\Shell;

use Cake\Console\Shell;

/**
 * Surveys shell command.
 *
 * @property \Qobo\Survey\Shell\Task\AddDefaultSectionsTask $AddDefaultSections
 * @property \Qobo\Survey\Shell\Task\MoveSubmitsToEntriesTask $MoveSubmitsToEntries
 * @property \Qobo\Survey\Shell\Task\MigrateScoresToSurveyResultsTask $MigrateScoresToSurveyResults
 */
class SurveysShell extends Shell
{
    public $tasks = [
        'Qobo/Survey.AddDefaultSections',
        'Qobo/Survey.MoveSubmitsToEntries',
        'Qobo/Survey.MigrateScoresToSurveyResults',
        'Qobo/Survey.MoveSurveyResultsToEntryQuestions',
    ];
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->setDescription('Surveys shell handles related survey tasks.')
            ->addSubcommand(
                'add_default_sections',
                [
                    'help' => 'Add default sections to existing surveys',
                    'parser' => $this->AddDefaultSections->getOptionParser()
                ]
            )->addSubcommand(
                'move_submits_to_entries',
                [
                    'help' => 'Pre-populating Survey Entry with all the submits that took place',
                    'parser' => $this->MoveSubmitsToEntries->getOptionParser()
                ]
            )->addSubcommand(
                'migrate_scores_to_survey_results',
                [
                    'help' => 'Migrate score values to survey_results records',
                    'parser' => $this->MigrateScoresToSurveyResults->getOptionParser()
                ]
            )->addSubcommand(
                'move_survey_results_to_entry_questions',
                [
                    'help' => 'Assign survey_entry_question_id fields for survey_results',
                    'parser' => $this->MoveSurveyResultsToEntryQuestions->getOptionParser(),
                ]
            );

        return $parser;
    }
}
