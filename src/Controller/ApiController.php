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
use App\Model\Entity\Dog;
use App\Model\Entity\Place;
use SKAgarwal\GoogleApi\PlacesApi;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;

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

        $this->Dog = new Dog();
        $this->Place = new Place();
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

    public function addDogsPlaces()
    {
        $dog = $this->Dog->newEmptyEntity();
        $place = $this->Place->newEmptyEntity();

        if ($this->request->is('post')) {
            $dog = $this->Dog->patchEntity($dog, $this->request->getData("dog"));
            $place = $this->Place->patchEntity($place, $this->request->getData("place"));

            if ($this->Dog->save($dog) && $this->Place->save($place)) {
                $result = ['message' => 'Dog and Places are saved','error' => false];
            } else {
                $result = ['message' => 'problem saving Dog and Places','error' => true];
            }
        }

        $this->set(['response' => $result]);
        $this->viewBuilder()->setOption('serialize', true);
        return $this->RequestHandler->renderAs($this, 'json');
    }
}
