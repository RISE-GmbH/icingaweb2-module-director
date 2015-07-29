<?php

use Icinga\Module\Director\Web\Controller\ActionController;
use Icinga\Module\Director\Objects\SyncProperty;
use Icinga\Module\Director\Sync\Sync;
use Icinga\Exception\InvalidPropertyException;
use Icinga\Web\Notification;

class Director_SyncpropertyController extends ActionController
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
        if ($runId = Import::run($id = SyncProperty::load($this->params->get('id'), $this->db()))) {
            Notification::success('adf' . $runId);
            $this->redirectNow('director/list/syncproperty');
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
            $this->view->title = $this->translate('Edit sync property rule');
            $this->getTabs()->add('edit', array(
                'url'       => 'director/syncproperty/edit' . '?id=' . $id,
                'label'     => $this->view->title,
            ))->activate('edit');
        } else {
            $this->view->title = $this->translate('Add sync property rule');
            $this->getTabs()->add('add', array(
                'url'       => 'director/syncproperty/add',
                'label'     => $this->view->title,
            ))->activate('add');
        }

        $form = $this->view->form = $this->loadForm('syncProperty')
            ->setSuccessUrl('director/list/syncproperty')
            ->setDb($this->db());

        if ($edit) {
            $form->loadObject($id);
        }

        $form->handleRequest();

        $this->render('object/form', null, true);
    }
}
