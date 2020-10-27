<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use SKAgarwal\GoogleApi\PlacesApi;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\BadRequestException;
use Cake\Validation\Validator;
use Exception;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class ApiController extends AppController
{
    protected $Place;

    protected $Dog;

    protected $GooglePlacesWrapper;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Security');
        $this->Dog = $this->getTableLocator()->get('dogs');
        $this->Place = $this->getTableLocator()->get('places');
        $this->GooglePlacesWrapper = new PlacesApi(env('GOOGLE_MAP_API'));
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Security->setConfig('unlockedActions', ['searchPlace', 'addDogsPlaces','search']);
    }

    public function index()
    {
        throw new ForbiddenException();
    }

    public function searchPlace()
    {
        $query = $this->request->getData("place");

        if (!isset($query)) {
            $response = ['response' => 'No search query specified','error' => true];
        } else {
            $response = ['response' => $this->GooglePlacesWrapper->placeAutocomplete($query), 'error' => false];
        }

        $this->set(['response' => $response]);
        $this->viewBuilder()->setOption('serialize', true);
        return $this->RequestHandler->renderAs($this, 'json');
    }

    public function getDogs()
    {
        $allDogs = $this->Dog->find('all')->all();
        $this->set(['response' => $allDogs->toArray()]);
        $this->viewBuilder()->setOption('serialize', true);
        return $this->RequestHandler->renderAs($this, 'json');
    }

    public function addDogsPlaces()
    {
        try {
            $jsonData = $this->request->getData();
        } catch (Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        $jsonValidator = new Validator();
        $dogValidator = new Validator();
        $placeValidator = new Validator();
        $dogValidator->requirePresence('name')
        ->notEmptyString('name', 'Please fill dog name')
        ->add('name', [
            'length' => [
                'rule' => ['minLength', 2],
                'message' => 'Titles need to be at least 2 characters long',
            ]
        ])->requirePresence('breed')
        ->requirePresence('time_located');

        $placeValidator
        ->requirePresence('location')
        ->requirePresence('name')
        ->add('location', [
            'length' => [
                'rule' => ['minLength', 5],
                'message' => 'Titles need to be at least 5 characters long',
            ]
        ]);

        $jsonValidator
        ->requirePresence('dog')
        ->addNested('dog', $dogValidator)
        ->requirePresence('location')
        ->addNested('location', $placeValidator);

        $errors = $jsonValidator->validate((array)$jsonData);

        if (!empty($errors)) {
            $this->set(['response' => ["error" => true, "response" => $errors]]);
            $this->viewBuilder()->setOption('serialize', true);
            return $this->RequestHandler->renderAs($this, 'json');
        }

        $dog = $this->Dog->newEmptyEntity();
        $place = $this->Place->newEmptyEntity();
        $result = "";

        if ($this->request->is('post')) {
            $dog = $this->Dog->patchEntity($dog, $jsonData['dog']);
            $place = $this->Place->patchEntity($place, $jsonData['location']);

            try {
                if ($this->Place->save($place)) {
                    $dog->place_id = $place->id;
                    if ($this->Dog->save($dog)) {
                        $result = ['message' => 'Dog and Places are saved','error' => false];
                    } else {
                        $result = ['message' => 'problem saving Dog and Places','error' => true];
                    }
                }
            } catch (Exception $e) {
                throw $e; //rethrow upwards
            }
        }

        $this->set(['response' => $result]);
        $this->viewBuilder()->setOption('serialize', true);
        return $this->RequestHandler->renderAs($this, 'json');
    }
}
