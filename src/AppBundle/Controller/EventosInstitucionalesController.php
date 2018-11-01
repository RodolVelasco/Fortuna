<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\EventosInstitucionales;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * EventosInstitucionales controller.
 *
 */
class EventosInstitucionalesController extends Controller
{
    /**
     * Lists all EventosInstitucionales entities.
     *
     */
    public function indexAction(Request $request)
    {
        //get the user_id of the logged in user
        $loggedInUser = $this->get('security.token_storage')->getToken()->getUser();
        $loggedInUserId = $loggedInUser->getId();
        //var_dump($loggedInUserId);die();

        $em = $this->getDoctrine()->getManager();
        //$queryBuilder=null;
        if(!($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))){
            $parameters = array(
                'id' => $loggedInUserId
                //,'departamento' => "San Salvador"
            );
            $queryBuilder = $em->getRepository('AppBundle:EventosInstitucionales')
                                ->createQueryBuilder('e')
                                ->where('e.user = :id')
                                    ->setParameters($parameters)
                                ;

        }else{
            $queryBuilder = $em->getRepository('AppBundle:EventosInstitucionales')
                                ->createQueryBuilder('e');
        }

        /*foreach($queryBuilder->getParameters() as $key=>$value){
           $queryBuilder->setParameter($key,null);
       }*/
       //dump($request->get('search'));die();
       //dump($queryBuilder->getDql());die();//"SELECT e FROM AppBundle\Entity\EventosInstitucionales e WHERE e.user = :id"
       //dump($queryBuilder->getQuery());die();
       list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
       //dump($queryBuilder->getDql());die();
       //dump($queryBuilder->getQuery());die();
       list($eventosInstitucionales, $pagerHtml) = $this->paginator($queryBuilder, $request);

       $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);


        return $this->render('AppBundle::eventosinstitucionales/index.html.twig', array(
            'eventosInstitucionales' => $eventosInstitucionales,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }


    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, $request)
    {
        $filterForm = $this->createForm('AppBundle\Form\EventosInstitucionalesFilterType');
        /*$filterForm->add('hiddenLoggedInUserId', HiddenType::class, array(
                    'data' => $this->get('security.token_storage')->getToken()->getUser()->getId()
                ));*/
        //dump($this->get('security.token_storage')->getToken()->getUser()->getId());
        //dump($queryBuilder->andWhere("departamento = 1"));
        // Bind values from the request
        $filterForm->handleRequest($request);

        if ($filterForm->isValid()) {
            /*$filterForm->add('token', HiddenType::class, array(
                        'data' => $this->get('security.token_storage')->getToken()->getUser()->getId(),
                    ));*/
            //dump($filterForm->get('hiddenLoggedInUserId'));die();
            //dump($queryBuilder->getQuery());
            //dump($filterForm->get('search')->getData());
            // Build the query from the given form object

            $this->get('petkopara_multi_search.builder')->searchForm( $queryBuilder, $filterForm->get('search'));
            if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $queryBuilder->andWhere("e.user = :id");
            }
            /*dump($queryBuilder->getQuery());
            if($filterForm->get('search')->getData() != null){
                $queryBuilder->andWhere("e.user = :id")
                    ->setParameters(array(
                                "id"=>$this->get('security.token_storage')->getToken()->getUser()->getId(),
                                "1"=>$filterForm->get('search')->getData()
                            )
                    );
            }
            dump($queryBuilder->getQuery());
            dump($queryBuilder->getDql());die();*/
        }
        //dump($filterForm);die();
        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //var_dump("PAGINATOR");die();
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        //var_dump($queryBuilder->getDql());die();
        $entities = $pagerfanta->getCurrentPageResults();
        //var_dump($entities);die();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('eventosinstitucionales', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
        ));

        return array($entities, $pagerHtml);
    }



    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Showing $startRecord - $endRecord of $totalOfRecords Records.";
    }



    /**
     * Displays a form to create a new EventosInstitucionales entity.
     *
     */
    public function newAction(Request $request)
    {

        $eventosInstitucionale = new EventosInstitucionales();
        $form   = $this->createForm('AppBundle\Form\EventosInstitucionalesType', $eventosInstitucionale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventosInstitucionale);
            $em->flush();

            $editLink = $this->generateUrl('eventosinstitucionales_edit', array('id' => $eventosInstitucionale->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New eventosInstitucionale was created successfully.</a>" );

            $nextAction=  $request->get('submit') == 'save' ? 'eventosinstitucionales' : 'eventosinstitucionales_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('eventosinstitucionales/new.html.twig', array(
            'eventosInstitucionale' => $eventosInstitucionale,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a EventosInstitucionales entity.
     *
     */
    public function showAction(EventosInstitucionales $eventosInstitucionale)
    {
        $deleteForm = $this->createDeleteForm($eventosInstitucionale);
        return $this->render('eventosinstitucionales/show.html.twig', array(
            'eventosInstitucionale' => $eventosInstitucionale,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing EventosInstitucionales entity.
     *
     */
    public function editAction(Request $request, EventosInstitucionales $eventosInstitucionale)
    {
        $deleteForm = $this->createDeleteForm($eventosInstitucionale);
        $editForm = $this->createForm('AppBundle\Form\EventosInstitucionalesType', $eventosInstitucionale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //var_dump((string)$editForm->get('numeroParticipantes')->getData());die();
            //$eventosInstitucionale->setNumeroParticipantes((string)$editForm->get('numeroParticipantes')->getData());
            $em->persist($eventosInstitucionale);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('eventosinstitucionales_edit', array('id' => $eventosInstitucionale->getId()));
        }
        return $this->render('eventosinstitucionales/edit.html.twig', array(
            'eventosInstitucionale' => $eventosInstitucionale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a EventosInstitucionales entity.
     *
     */
    public function deleteAction(Request $request, EventosInstitucionales $eventosInstitucionale)
    {

        $form = $this->createDeleteForm($eventosInstitucionale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventosInstitucionale);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The EventosInstitucionales was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the EventosInstitucionales');
        }

        return $this->redirectToRoute('eventosinstitucionales');
    }

    /**
     * Creates a form to delete a EventosInstitucionales entity.
     *
     * @param EventosInstitucionales $eventosInstitucionale The EventosInstitucionales entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EventosInstitucionales $eventosInstitucionale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventosinstitucionales_delete', array('id' => $eventosInstitucionale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Delete EventosInstitucionales by id
     *
     */
    public function deleteByIdAction(EventosInstitucionales $eventosInstitucionale){
        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($eventosInstitucionale);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The EventosInstitucionales was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the EventosInstitucionales');
        }

        return $this->redirect($this->generateUrl('eventosinstitucionales'));

    }


    /**
    * Bulk Action
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:EventosInstitucionales');

                foreach ($ids as $id) {
                    $eventosInstitucionale = $repository->find($id);
                    $em->remove($eventosInstitucionale);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'eventosInstitucionales was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the eventosInstitucionales ');
            }
        }

        return $this->redirect($this->generateUrl('eventosinstitucionales'));
    }


}
