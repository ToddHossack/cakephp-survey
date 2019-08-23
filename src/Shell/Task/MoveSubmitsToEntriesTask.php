<?php
namespace Qobo\Survey\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * MoveSubmitsToEntries shell task.
 */
class MoveSubmitsToEntriesTask extends Shell
{

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
        $this->out((string)__('Moving Current submits into Survey Entries'));

        $results = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyResults');
        $entries = TableRegistry::getTableLocator()->get('Qobo/Survey.SurveyEntries');

        $query = $results->find()
            ->group('submit_id');

        if (! $query->count()) {
            $this->out((string)__('No submits found in the survey_results table. Exiting'));

            return true;
        }
        $count = 0;

        foreach ($query->all() as $item) {
            $found = $entries->find()
                ->where([
                    'id' => $item->get('submit_id')
                ]);

            if (! $found->count()) {
                $entry = $entries->newEntity();
                $entry->set('id', $item->get('submit_id'));
                $entry->set('submit_date', $item->get('submit_date'));
                $entry->set('survey_id', $item->get('survey_id'));
                $entry->set('resource', 'Users');
                $entry->set('resource_id', $item->get('user_id'));
                $entry->set('status', 'in_review');

                $saved = $entries->save($entry);

                if ($saved) {
                    $count++;
                }
            }
        }

        $this->out((string)__('Moved {0} submits into survey_entries', $count));

        return true;
    }
}
