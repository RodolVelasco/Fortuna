<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Sorteo;
use AppBundle\Form\SorteoType;
use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use AppBundle\Entity\Participa;
use AppBundle\Entity\Recarga;

use AppBundle\Pagination\Paginator;

/**
 * Recarga controller.
 *
 */
class RecargaController extends Controller
{

    /**
     * Lists all Recarga entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        //var_dump($this);die;
        //exit(\Doctrine\Common\Util\Debug::dump($this->container->get('security.context')->getToken()->getUser()));
        $em = $this->getDoctrine()->getManager();

        $entitiesLength = $em->getRepository('AppBundle:Recarga')->counter();

        return $this->render('AppBundle:Recarga:index.html.twig', array(
            'entitiesLength' => $entitiesLength));
    }

    /**
     * recargas list using ajax
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('AppBundle:Recarga')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('AppBundle:Recarga:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }

    /**
     * Creates a new Sorteo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Sorteo();
        $form = $this->createForm(new SorteoType(), $entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $entity->getPrimeraImage()->upload();
            $entity->getSegundaImage()->upload();
            $entity->getTerceraImage()->upload();
            $entity->setCreador($this->container->get('security.context')->getToken()->getUser());
            $limiteSuperior = ceil($entity->getPrecio() * $entity->getGanancia());

            for($i=1; $i<=$limiteSuperior;$i++){
                $participaEntity = new Participa();
                $participaEntity->setSorteo($entity);
                $participaEntity->setNumero($i);
                $em->persist($participaEntity);
            }
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "El sorteo fue creado exitosamente.");
            return $this->redirect($this->generateUrl('sorteo'));
            //return $this->redirect($this->generateUrl('sorteo_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario presentado !");
        return $this->render('AppBundle:Sorteo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Displays a form to create a new Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction()
    {
        $entity = new Sorteo();
        $form = $this->createForm(new SorteoType(), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        return $this->render('AppBundle:Sorteo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Finds and displays a Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Person:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Sorteo entity.
     * @Secure(roles="ROLE_ADMIN")
     *
     */
    public function editAction(Sorteo $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad Sorteo.');
        }
        $editForm = $this->createForm(new SorteoType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('AppBundle:Sorteo:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Edits an existing Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, Sorteo $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad Sorteo.');
        }
        $id = $entity->getId();
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm(new SorteoType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->getPrimeraImage()->upload();
            $entity->getSegundaImage()->upload();
            $entity->getTerceraImage()->upload();
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "La información del sorteo ha sido actualizada exitosamente.");
            return $this->redirect($this->generateUrl('sorteo_edit', array('id' => $id)));
        }
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Hay errores en el formulario !");
        return $this->render('AppBundle:Sorteo:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Deletes a Person entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Person')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Person entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "La acción finalizó exitosamente !");
        }

        return $this->redirect($this->generateUrl('person'));
    }

    /**
     * Creates a form to delete a Person entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Person')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }

    /**
     * Displays a form to edit an existing Sorteo entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function participaAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Sorteo')->find($id);
        //$numeros = $entity->getParticipantes();
        //exit(\Doctrine\Common\Util\Debug::dump($numeros));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sorteo entity.');
        }

        //$editForm = $this->createForm(new SorteoType(), $entity);
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        return $this->render('AppBundle:Sorteo:participa.html.twig', array(
            'entity'      => $entity,
            //'form'   => $editForm->createView(),
            'id' => $id
        ));
    }

    /**
     * participa list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function participaAjaxAction(Request $request, $id)
    {
        $session = $this->get('session');
        $session->set('winner', "");
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Sorteo')->find($id);
        $numeros = $entity->getParticipantes();
        //exit(\Doctrine\Common\Util\Debug::dump($numeros));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sorteo entity.');
        }

        return $this->render('AppBundle:Sorteo:ajax_form.html.twig', array(
            'numeros' => $numeros,));
    }

    /**
     * participa list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function participaAjaxPostAction(Request $request, $id/*, $numerosParticipantes*/)
    {
        $session = $this->get('session');
        $session->set('winner', "");
        $session->set('winnerNumber', "");
        $em = $this->getDoctrine()->getManager();
        //$ids = $request->get('numerosParticipantes');
        $logger = $this->get('logger');
        $logger->info('I just got the logger'/*.$numerosParticipantes*/);
        $ids = $request->get('numerosParticipantes');
        $numerosRechazados = array();
        //$this->get('session')->getFlashBag()->add('info', "DEBUG !");
        $winner = "";
        if(count($ids) > 0){
            $entidadesNumerosParticipantes = $em->getRepository('AppBundle:Participa')->search(array('ids'=>$ids));
            $logger->info('select '.count($entidadesNumerosParticipantes));
            foreach($entidadesNumerosParticipantes as $entidadNumeroParticipante){

                if($entidadNumeroParticipante->getUser() == null){

                    $user = $em->getRepository('AppBundle:User')->find($this->container->get('security.context')->getToken()->getUser()->getId());
                    $entidadNumeroParticipante->setUser($user);
                        //$em->persist($entidadNumeroParticipante);
                    $em->flush();
                }else{
                    array_push($numerosRechazados, $entidadNumeroParticipante->getNumero());

                }
            }

            $contador = $em->getRepository('AppBundle:Participa')->verificadorSoyElUltimo($id);

            $logger->info('FFF '.$contador);
            if($contador == 0){
                $sorteo = $em->getRepository('AppBundle:Sorteo')->find($id);
                $logger->info('Contador de sorteo '.count($sorteo));
                $participantes = $sorteo->getParticipantes();
                $logger->info('Contador de participantes '.count($participantes));
                $numeroGanador = rand(0,count($participantes));
                $logger->info('Número Ganador '.$numeroGanador);
                foreach($participantes as $participa){
                    if($participa->getNumero() == $numeroGanador){
                        $sorteo->setGanador($participa->getUser());
                        $em->flush();
                        $winner = $participa->getUser()->getFullName();
                        $session = $this->get('session');
                        $session->set('winner', $winner);
                        $session->set('winnerNumber', $numeroGanador);
                    }
                }

                $entity = $em->getRepository('AppBundle:Sorteo')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Sorteo entity.');
                }

                //return new Symfony\Component\Httpfoundation\Response\Response('1');

                /*return $this->render('AppBundle:Sorteo:ajax_form.html.twig', array(
                        'numeros' => $numeros));*/
                //return $this->redirect($this->generateUrl("sorteo_participa", array('id' => $id)));
            }

            /*$stringNumerosRechazados = '';
            if(count($numerosRechazados) > 0){
                $tamanoNumerosRechazados = count($numerosRechazados);
                for($i=0;$i<$tamanoNumerosRechazados;$i++){
                    $stringNumerosRechazados = $stringNumerosRechazados . ' ' . $numerosRechazados[i];
                }
                $this->get('session')->getFlashBag()->add('warning',
                                    "Bien hecho, estás participando en el sorteo con algunos de los números".
                                    "que seleccionaste. Los números que fueron rechazados son: ".$stringNumerosRechazados);
            }else{
                $this->get('session')->getFlashBag()->add('info', "Bien hecho, estás participando en el sorteo con los números que seleccionaste !");
            }*/
        }

        $entity = $em->getRepository('AppBundle:Sorteo')->find($id);
        $numeros = $entity->getParticipantes();
        //exit(\Doctrine\Common\Util\Debug::dump($numeros));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sorteo entity.');
        }
        // $cities = $em->getRepository('AppBundle:Person')->getCities();


        return $this->render('AppBundle:Sorteo:ajax_form.html.twig', array(
            'numeros' => $numeros));

    }
}
