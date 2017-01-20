<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\TaskType;
use Symfony\Component\Debug\Tests\Fixtures\ToStringThrower;
use Symfony\Component\BrowserKit\Response;
use Propel\Generator\Behavior\Validate\ValidateBehavior;


 

class ApiController extends FOSRestController {
	
	/**
	 * @GET("/task")
	 *
	 */
	
    public function getTaskAction() {

    	$task=$this->getDoctrine()->getRepository("AppBundle:Task")->findAll();
        $task=$this->getDoctrine()->getRepository("AppBundle:Task")->findOneBy()
    	
    	if (!$task) {
    		$view = $this->view($task,204);
    	}
    	
    	
    	else $view = $this->view($task,200);
    	return $this->handleView($view);
	}

	
	/**
	 * @GET("/task/{id}")
	 *@param $id
	 *@return mixed
	 *
	 */
	
	public function getOneTaskAction($id) {
	
		$task=$this->getDoctrine()->getRepository("AppBundle:Task")->find($id);
		
		if (!$task) {
			$view = $this->view($task,404);
		}		
		else $view = $this->view($task,200);
		return $this->handleView($view);
	}
	

	/**
	 * @POST("/task")
	 *
	 */
	public function postAction(Request $request){
		
		$data=(array) json_decode($request->getContent());		
		
		if($this->validateRequest($data)){		
		$startdat=new \DateTime($data['start_date']);
		$enddat= new \DateTime($data['end_date']);		
		$task=new Task();
		$task->setName($data['name']);
		$task->setDescryption($data['descryption']);
		$task->setStartDate($startdat);
		$task->setEndDate($enddat);		
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();	
		$view = $this->view($task,201);
		}
		else $view = $this->view("",500);		
		return $this->handleView($view);
		
	}
	
	/**
	 * @DELETE("/task/{id}")
	 *
	 *@param Request $request
	 *@param $id
	 *@return mixed
	 *
	 */
	
	public function deleteAction(Request $request, $id)
	{
		
		$task=$this->getDoctrine()->getRepository("AppBundle:Task")->find($id);
                
		$em = $this->getDoctrine()->getManager();
		$em->remove($task);
		$em->flush($task);
		$view = $this->view("",200);
		return $this->handleView($view);
	}
	
	 
	 /**
	 * @PUT("task/{id}")
	 * 
	 * @param Request $request
	 * @param unknown $id
	 * @return mixed
	 */
	
	
	
	
	public function putAction(Request $request, $id)
	{		
		$a=(array) json_decode($request->getContent());
		$task=$this->getDoctrine()->getRepository("AppBundle:Task")->find($id);	
		
		
		$task = $this->processForm($task, $a, 'PUT');
		
		/*if($task == 0) {
			$view = $this->view("",500);		
		}
		else */$view = $this->view($task,200);
		return $this->handleView($view);
		
	}
	
	
	

	private function processForm(Task $task, array $parameters, $method = 'PUT') {
	
		
		
		$form = $this->createForm(new TaskType(), $task);	
		
		$form->submit($parameters);				
		
	
				
		if(isset($parameters['start_date'])){
				
				$sd = \DateTime::createFromFormat('Y-m-d', $parameters['start_date']);
				$errors = (array)\DateTime::getLastErrors();
				$er=$errors['error_count'];
				
				if($er==0){
				$parameters['start_date']=new \DateTime($parameters['start_date']);				
				$task->setStartDate($parameters['start_date']);} 
				else return 0;
				
			}
			
			if(isset($parameters['end_date'])){
				
				$ed = \DateTime::createFromFormat('Y-m-d', $parameters['end_date']);
				$errors = (array)\DateTime::getLastErrors();
				$er=$errors['error_count'];
				
				if($er==0){
				$parameters['end_date']=new \DateTime($parameters['end_date']);
				$task->setEndDate($parameters['end_date']);}
				else return 0;
			}
			
			
			
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($task);			
			$em->flush();
			return $parameters;;
	
			
			
	
	}
	
	private function validateRequest($data){
		
		if(isset($data['name']) && isset($data['descryption']) && isset($data['start_date']) && isset($data['end_date'])){
			
				$sd = \DateTime::createFromFormat('Y-m-d', $data['start_date']);
				$errors = (array)\DateTime::getLastErrors();
				$er=$errors['error_count'];
			
				$ed = \DateTime::createFromFormat('Y-m-d', $data['start_date']);
				$errors = (array)\DateTime::getLastErrors();
				$er+=$errors['error_count'];
				
				
				if($er==0) return 1;
				else return 0;
		
		}
		
		else return 0;
		
	}
	
}
