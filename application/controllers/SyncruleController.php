<?php

use Icinga\Module\Director\Web\Controller\ActionController;
use Icinga\Module\Director\Objects\SyncRule;
use Icinga\Module\Director\Import\Sync;
use Icinga\Exception\InvalidPropertyException;
use Icinga\Web\Notification;

class Director_SyncruleController extends ActionController
{
    public function addAction()
    {
        $this->indexAction();
    }

    public function editAction()
    {
        $this->indexAction();
    }

    public function runAction()
    {
        if ($runId = Sync::run(SyncRule::load($this->params->get('id'), $this->db()))) {
            Notification::success('Just testing');
            $this->redirectNow('director/list/syncrule');
        } else {
        }
    }

    public function indexAction()
    {
        $edit = false;

        if ($id = $this->params->get('id')) {
            $edit = true;
        }

        if ($edit) {
            $this->view->title = $this->translate('Edit sync rule');
            $this->getTabs()->add('edit', array(
                'url'       => 'director/syncrule/edit' . '?id=' . $id,
                'label'     => $this->view->title,
            ))->activate('edit');
        } else {
            $this->view->title = $this->translate('Add sync rule');
            $this->getTabs()->add('add', array(
                'url'       => 'director/syncrule/add',
                'label'     => $this->view->title,
            ))->activate('add');
        }

        $form = $this->view->form = $this->loadForm('syncRule')
            ->setSuccessUrl('director/list/syncrule')
            ->setDb($this->db());

        if ($edit) {
            $form->loadObject($id);
        }

        $form->handleRequest();

        $this->render('object/form', null, true);
    }
}
