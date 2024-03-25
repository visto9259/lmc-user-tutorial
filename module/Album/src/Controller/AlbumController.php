<?php

namespace Album\Controller;

use Album\Form\AlbumForm;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use LmcUser\Controller\UserController;
use LmcUser\Entity\UserInterface;

class AlbumController extends AbstractActionController
{
    private $table;

    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    public function indexAction(): ViewModel
    {
        if (! $this->lmcUserAuthentication()->hasIdentity()) {
            // If not, then redirect to the 'login' route
            return $this->redirect()->toRoute(UserController::ROUTE_LOGIN);
        }
        /** @var UserInterface $user */
        $user = $this->lmcUserAuthentication()->getIdentity();

        return new ViewModel([
            'albums' => $this->table->fetchAll(['user_email' => $user->getEmail()]),
        ]);
    }

    public function addAction()
    {
        if (! $this->lmcUserAuthentication()->hasIdentity()) {
            // If not, then redirect to the 'login' route
            return $this->redirect()->toRoute(UserController::ROUTE_LOGIN);
        }

        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        /** @var UserInterface $user */
        $user = $this->lmcUserAuthentication()->getIdentity();
        $data = $form->getData();
        // Add the user's email to the album data
        $data['user_email'] = $user->getEmail();
        $album->exchangeArray($data);
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
        if (! $this->lmcUserAuthentication()->hasIdentity()) {
            // If not, then redirect to the 'login' route
            return $this->redirect()->toRoute(UserController::ROUTE_LOGIN);
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        /** @var UserInterface $user */
        $user = $this->lmcUserAuthentication()->getIdentity();

        // Check that the album belongs to the user and if not redirect to the album page
        // This can happen if the user navigated to the edit page for an album he does not own
        if ($album->user_email != $user->getEmail()) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveAlbum($album);
        } catch (\Exception $e) {
        }

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    public function deleteAction()
    {
        if (! $this->lmcUserAuthentication()->hasIdentity()) {
            // If not, then redirect to the 'login' route
            return $this->redirect()->toRoute(UserController::ROUTE_LOGIN);
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('album');
        }

        // Get the album first
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        /** @var UserInterface $user */
        $user = $this->lmcUserAuthentication()->getIdentity();
        // Does the album belong to the user?
        if ($album->user_email != $user->getEmail()) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->table->getAlbum($id),
        ];
    }
}
