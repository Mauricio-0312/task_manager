<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Task;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use \Symfony\Component\Security\Core\User\UserInterface;
class TaskController extends AbstractController
{
    
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $task_repo->findBy([], ["id"=>"desc"]);

    

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    public function detail(Task $task_id){
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $task = $task_repo->find($task_id);

        return $this->render('task/detail.html.twig', [
            'task' => $task,
        ]);
    }

    public function creation(Request $request, UserInterface $user){
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

      
        if($form->isSubmitted()){
            $task->setCreatedAt(new \DateTime("now"));
            $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl("tasks_detail", ["id"=> $task->getId()])); 
        }

        return $this->render('task/creation.html.twig', [
            'form' => $form->createView()
        ]); 
    }

    public function myTasks(UserInterface $user){
        $tasks = $user->getTasks();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'mine' => true
        ]);
    }

    public function edit(Request $request, UserInterface $user, Task $task){
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

      
        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl("tasks_detail", ["id"=> $task->getId()])); 
        }

        return $this->render('task/creation.html.twig', [
            'form' => $form->createView(),
            "edit" => true
        ]); 
    }

    public function delete(Task $task){
        $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        return $this->redirectToRoute("tasks");
    }
}
