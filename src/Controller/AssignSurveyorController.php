<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 11-07-2019
 * Time: 03:46 PM
 */

namespace App\Controller;

use App\Entity\Tasks;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AssignSurveyorController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function __invoke(Users $data,$taskId)
    {
       $task = $this->manager->getRepository(Tasks::class)->find($taskId);

       if($task){
           if($data->getRoles()[0] === Users::ROLE_SURVEYOR){
               $data->addTask($task);
               $this->manager->persist($data);
               $this->manager->flush();
               return new JsonResponse(['result'=> 'Task Assigned']);
           }else{
               return new JsonResponse(['result'=> 'Sorry tasks can only be assigned to surveyors']);
           }
       }
       return new JsonResponse(['result'=> 'Sorry No task found to assign']);


    }
}