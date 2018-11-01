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
use AppBundle\Form\RecargaType;
use AppBundle\Form\RecargaUserType;
use AppBundle\Form\RecargaIndividualType;

use AppBundle\Pagination\Paginator;

use Symfony\Component\Form\Extension\Core\Type\TextType;

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
     * Creates a new Recarga entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction(Request $request)
    {
        //dump("Fortuna");die();
        $cantidadCodigo = $request->get('cantidadCodigo');
        $entity = new Recarga();
        $form = $this->createForm(new RecargaType(), $entity);

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            for($i=1; $i<=$cantidadCodigo;$i++){
                $recargaEntity = new Recarga();
                //dump($recargaEntity->getFechaCreacion());die();
                $recargaEntity->setCodigo($this->random_str());
                $recargaEntity->setRecarga($entity->getRecarga());
                $recargaEntity->setPrecio($entity->getPrecio());
                $recargaEntity->setTipoPagoPorMonedero($entity->getTipoPagoPorMonedero());
                $recargaEntity->setEstado($entity->getEstado());
                $em->persist($recargaEntity);
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "Los códigos fueron creados exitosamente.");
            return $this->redirect($this->generateUrl('recarga'));
            //return $this->redirect($this->generateUrl('sorteo_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario presentado !");
        return $this->render('AppBundle:Recarga:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    //function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    function random_str($length = 16, $keyspace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    /**
     * Displays a form to create a new Recarga entity.
     * @Secure(roles="ROLE_ADMIN")
     *
     */
    public function newAction()
    {
        $entity = new Recarga();
        $form = $this->createForm(new RecargaType(), $entity);

        //$em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        return $this->render('AppBundle:Recarga:new.html.twig', array(
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
    public function editAction(Recarga $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad Recarga.');
        }

        $editForm = $this->createForm(new RecargaIndividualType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('AppBundle:Recarga:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Edits an existing Recarga entity.
     * @Secure(roles="ROLE_ADMIN")
     *
     */
    public function updateAction(Request $request, Recarga $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad Recarga.');
        }
        $id = $entity->getId();
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm(new RecargaIndividualType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "La información de la recarga ha sido actualizada exitosamente.");
            return $this->redirect($this->generateUrl('recarga'));
        }
        // $cities = $em->getRepository('AppBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Hay errores en el formulario !");
        return $this->render('AppBundle:Recarga:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Deletes a Recarga entity.
     * @Secure(roles="ROLE_ADMIN,ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Recarga')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Recarga entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "La acción finalizó exitosamente !");
        }

        return $this->redirect($this->generateUrl('recarga'));
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
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Recarga')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('La recarga con id:' . $id .' no fue encontrada');
        }
        try {
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La recarga fue eliminada exitosamente');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Error al intentar eliminar la recarga');
        }
        return $this->redirect($this->generateUrl('recarga'));
    }

    /**
     * Redeem codes
     * @Secure(roles="ROLE_USER")
     */
    public function redeemCodeAction(Request $request)
    {
        $data = array();
    	$form = $this->createFormBuilder($data)
                    ->add('redeemCodeA', TextType::class)
                    ->add('redeemCodeB', TextType::class)
                    ->add('redeemCodeC', TextType::class)
                    ->add('redeemCodeD', TextType::class)
                    ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dump("submitted and valid");die();
            $data = $form->getData();
            $codigo = strtoupper($data['redeemCodeA']).strtoupper($data['redeemCodeB']).strtoupper($data['redeemCodeC']).strtoupper($data['redeemCodeD']);

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Recarga')->findOneByCodigo($codigo);

            $user = $this->container->get('security.context')->getToken()->getUser();
            if(!$entity){
                if($user->getContadorFalloRecarga() < 3){
                    $user->setContadorFalloRecarga($user->getContadorFalloRecarga()+1);
                }else{
                    $user->setEnabled(false);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('danger', "Código de recarga incorrecto. Usuario deshabilitado.");
                    $this->container->get('security.context')->setToken(null);
                    return $this->redirect($this->generateUrl('sorteo'));

                }

                $em->flush();
                $this->get('session')->getFlashBag()->add('danger', "Código de recarga incorrecto. Intente de nuevo.");
                return $this->redirect($this->generateUrl('sorteo'));
                throw $this->createNotFoundException('Código de recarga incorrecto. Intente de nuevo');
            }

            $msg = "";
            if($entity->getRecargador() == NULL){
                $entity->setRecargador($user);
                $entity->setFechaRecarga(new \DateTime());
                if($entity->getTipoPagoPorMonedero() == 1){
                    $user->setSaldoPrincipal($user->getSaldoPrincipal() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo principal es de $".$user->getSaldoPrincipal();
                }
                if($entity->getTipoPagoPorMonedero() == 2){
                    $user->setSaldoBono($user->getSaldoBono() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo de bono es de $".$user->getSaldoBono();
                }
                if($entity->getTipoPagoPorMonedero() == 3){
                    $user->setSaldoPromocional($user->getSaldoPromocional() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo promocional es de $".$user->getSaldoPromocional();
                }
                $user->setContadorFalloRecarga(0);
                $em->flush();
            }else{
                $this->get('session')->getFlashBag()->add('danger', "Error al realizar la recarga. El código ya fue utilizado");
                return $this->redirect($this->generateUrl('sorteo'));
            }


            $this->get('session')->getFlashBag()->add('success', $msg);
            return $this->redirect($this->generateUrl('sorteo'));
        }
        /*
        $codeA = $request->get('redeemCodeA');
        $codeB = $request->get('redeemCodeB');
        $codeC = $request->get('redeemCodeC');
        $codeD = $request->get('redeemCodeD');*/

        return $this->render('AppBundle:Recarga:redeem_new.html.twig', array(
            'form' => $form->createView()
        ));
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

    /**
     * Creates a new Recarga entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function recargaUserAction(Request $request, Recarga $recarga)
    {
        if(!$recarga)
            throw $this->createNotFoundException('Recarga no encontrada.');
        //dump("recargaUser");die;

        $form = $this->createForm(new RecargaUserType(), $recarga);

        return $this->render('AppBundle:Recarga:recarga_user.html.twig', array(
            'entity' => $recarga,
            'form'   => $form->createView(),
        ));

    }


    /**
     * Creates a new Recarga entity.
     * @Secure(roles="ROLE_ADMIN")
     */
    public function recargaUserCreateAction(Request $request, Recarga $entity)
    {
        //dump($request->get('recarga_user_type[codigo]'));die;
        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad Recarga.');
        }

        $form = $this->createForm(new RecargaUserType(), $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $user = $form->get('recargador')->getData();
            //$entity->setRecargador($user);

            //$entityAux = $em->getRepository('AppBundle:Recarga')->find($entity->getId());
            //dump($entityAux);die;
            $msg = "";
            //dump($entityAux->getRecargador());die;
            if($entity->getFechaRecarga() == NULL){
                $entity->setRecargador($user);
                $entity->setFechaRecarga(new \DateTime());
                if($entity->getTipoPagoPorMonedero() == 1){
                    $user->setSaldoPrincipal($user->getSaldoPrincipal() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo principal es de $".$user->getSaldoPrincipal();
                }
                if($entity->getTipoPagoPorMonedero() == 2){
                    $user->setSaldoBono($user->getSaldoBono() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo de bono es de $".$user->getSaldoBono();
                }
                if($entity->getTipoPagoPorMonedero() == 3){
                    $user->setSaldoPromocional($user->getSaldoPromocional() + $entity->getRecarga());
                    $msg = "Ha abonado $".$entity->getRecarga()." exitosamente. Su saldo promocional es de $".$user->getSaldoPromocional();
                }
                $user->setContadorFalloRecarga(0);
                $em->flush();
            }else{
                $this->get('session')->getFlashBag()->add('danger', "Error al realizar la recarga. El código ya fue utilizado");
                return $this->redirect($this->generateUrl('recarga'));
            }

            $this->get('session')->getFlashBag()->add('success', $msg);
            return $this->redirect($this->generateUrl('recarga'));
        }

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario presentado !");
        return $this->redirect($this->generateUrl('recarga'));

    }

}
