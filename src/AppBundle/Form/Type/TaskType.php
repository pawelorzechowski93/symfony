<?php

namespace AppBundle\Form\Type;

use Propel\Bundle\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\Task;

class TaskType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'AppBundle\Model\Task',
        'name'       => 'task',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('descryption');
        $builder->add('startDate');
        $builder->add('endDate');
    }


public function processForm(Task $task)
{
	$statusCode = $task->isNew() ? 201 : 204;

	$form = $this->createForm(new TaskType(), $task);
	$form->handleRequest($this->getRequest());

	if ($form->isValid()) {
		$user->save();

		$response = new Response();
		$response->setStatusCode($statusCode);

		// set the `Location` header only when creating new resources
		if (201 === $statusCode) {
			$response->headers->set('Location',
					$this->generateUrl(
							'acme_demo_user_get', array('id' => $task->getId()),
							true // absolute
							)
					);
		}

		return $response;
	}

	return View::create($form, 400);
}
}