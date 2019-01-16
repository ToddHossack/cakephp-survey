<?php
namespace Qobo\Survey\Shell;

use Cake\Console\Shell;

/**
 * Surveys shell command.
 *
 * @property \Qobo\Survey\Shell\Task\AddDefaultSectionsTask $AddDefaultSections
 */
class SurveysShell extends Shell
{
    public $tasks = [
        'Qobo/Survey.AddDefaultSections',
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
            );

        return $parser;
    }
}
