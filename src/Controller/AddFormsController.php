<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 11-07-2019
 * Time: 04:43 PM
 */

namespace App\Controller;


use App\Entity\Forms;
use App\Entity\FormTasks;
use App\Entity\Tasks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\LogicException;

class AddFormsController
{


    /**
     * @var EntityManagerInterface
     */
    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(Tasks $data,$forms_id,$description)
    {

        if($data){
            $form = $this->manager->getRepository(Forms::class)->find($forms_id);
            if ($form){

                $form_collection_task = $this->manager->getRepository(FormTasks::class)->createQueryBuilder('data')
                    ->select('data,data2')
                    ->leftJoin('data.Tasks','data2')
                    ->getQuery()
                    ->getResult();

                foreach ($form_collection_task as $checkData){
                    if($data->getId() === $checkData->getTasks()->getId() && $form->getId() === $checkData->getForm()->getId()){
                        throw new LogicException('this task has this form already');
                    }
                }

                $form_task = new FormTasks();

                $form_task->setDescription($description);
                $form_task->setFormDataJson($form->getFormDataJson());
                $form->addTasksForm($form_task);
                $data->addForm($form_task);
                $this->manager->persist($form_task);

                $this->manager->flush();
                return new JsonResponse(['result' =>'FORM ADDED'],Response::HTTP_OK);
            }else{
                return new JsonResponse(['error' =>'sorry no form found'],Response::HTTP_NOT_FOUND);
            }

        }

        return new JsonResponse(['error' => 'Sorry something went wrong'],Response::HTTP_BAD_REQUEST);
    }
}