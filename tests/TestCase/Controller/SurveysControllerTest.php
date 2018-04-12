<?php
namespace Qobo\Survey\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Survey\Controller\SurveysController;

class SurveysControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'plugin.qobo/survey.survey_results',
        'plugin.qobo/survey.survey_questions',
        'plugin.qobo/survey.survey_answers',
        'plugin.qobo/survey.surveys',
        'plugin.qobo/survey.users',
    ];

    public function setUp()
    {
        parent::setUp();

        $userId = '00000000-0000-0000-0000-000000000001';
        $this->session([
            'Auth' => [
                'User' => TableRegistry::get('Users')->get($userId)->toArray()
            ]
        ]);
    }

    public function testIndex()
    {
        $this->get('/surveys/surveys');
        $this->assertResponseOk();
    }

    public function testAdd()
    {
        $this->get('/surveys/surveys/add');
        $this->assertResponseOk();
    }

    public function testEdit()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/edit/' . $surveyId);
        $this->assertResponseOk();
    }

    public function testDeleteRedirectOk()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->delete('/surveys/surveys/delete/' . $surveyId);
        $this->assertRedirect(['controller' => 'Surveys', 'action' => 'index']);
    }

    public function testPreviewGet()
    {
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $this->get('/surveys/surveys/preview/' . $surveyId);

        $this->assertResponseOk();
    }
}
