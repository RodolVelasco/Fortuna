<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use AppBundle\Entity\User;
use AppBundle\Form\userType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use AppBundle\Pagination\Paginator;


class AdminCustomController extends Controller
{
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('AppBundle:User')->counter();
        return $this->render('AppBundle:Admin:index.html.twig', array(
                'entitiesLength' => $entitiesLength[1]));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('AppBundle:User')->search($searchParam);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('AppBundle:Admin:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $entity = new User();
        $form = $this->createForm(new userType(), $entity);
        return $this->render('AppBundle:Admin:new.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction(Request $request)
    {
        $em = $this->get('fos_user.user_manager');
        $entity = new User();
        $form = $this->createForm(new userType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em->updateUser($entity, false);
            $entity->getImage()->upload();

            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('info', "Se añadió el usuario correctamente.");
            return $this->redirect($this->generateUrl('app_show_user', array('id' => $entity->getId())));
        }
        $this->get('session')->getFlashBag()->add('danger', "Hay errores en el formulario presentado !");

        return $this->render('AppBundle:Admin:new.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:user')->find($id);
        if (!$entity) throw $this->createNotFoundException('No se pudo encontrar a este usuario.');

        return $this->render('AppBundle:Admin:show.html.twig', array('entity' => $entity));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction(User $entity)
    {
        $form = $this->createForm(new userType(), $entity);
        return $this->render('AppBundle:Admin:edit.html.twig', array('entity' => $entity, 'form' => $form->createView()));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction(Request $request, User $user) {
        $em = $this->get('fos_user.user_manager');
        $form = $this->createForm(new userType(), $user);
        $form->bind($request);

        $userLoggedIn = $this->container->get('security.context')->getToken()->getUser();
        /* check if user has admin role */
        if (in_array('ROLE_ADMIN', $user->getRoles()) && $user->getId() != $userLoggedIn->getId()){
            $this->get('session')->getFlashBag()->add('danger', "Imposible editar la información de un administrador en esta interfaz");
            return $this->redirect($this->generateUrl('app_users'));
        }
        if ($form->isValid()) {
            $em->updateUser($user, false);
            $user->getImage()->manualRemove($user->getImage()->getAbsolutePath());
            $user->getImage()->upload();

            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Sus cambios han sido guardados.");
            return $this->redirect($this->generateUrl('app_edit_user', array('id' => $user->getId())));
        }
        $this->get('session')->getFlashBag()->add('danger', "Hay errores en el formulario presentado !");

        return $this->render('AppBundle:Admin:edit.html.twig', array('entity' => $user, 'form' => $form->createView()));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($user)
    {
    	$entity = array();
        return $this->render('AppBundle:Admin:new.html.twig', array('entity' => $entity));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeUsersAction(Request $request)
    {
        $loginUser = $this->container->get('security.context')->getToken()->getUser();
        $users = $request->get('users');
        $userManager = $this->get('fos_user.user_manager');
        foreach( $users as $id){
            $user = $userManager->findUserBy(array('id' => $id));
            if($loginUser == $user) return new Response('No se puede eliminar este usuario');
            $userManager->deleteUser($user);
        }
        return new Response('Usuario(s) eliminado(s) exitosamente');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function enableUsersAction(Request $request, $etat)
    {
        $users = $request->get('users');
        $userManager = $this->get('fos_user.user_manager');
        $etat = ($etat==1);
        foreach( $users as $id){
            $user = $userManager->findUserBy(array('id' => $id));
            $user->setEnabled($etat);
            $userManager->updateUser($user);
        }
        return new Response('1');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function setRoleAction(Request $request, $role)
    {
        $role = (in_array($role, ['ADMIN', 'MANAGER'])) ? 'ROLE_'.$role : 'ROLE_USER';
        $users = $request->get('users');
        $userManager = $this->get('fos_user.user_manager');
        foreach( $users as $id){
            $user = $userManager->findUserBy(array('id' => $id));
            $user->removeRole('ROLE_ADMIN');
            $user->addRole($role);
            $userManager->updateUser($user);
        }
        return new Response('1');
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function exportAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AppBundle:user')->getUsers();
        $response = $this->render('AppBundle:Admin:list.csv.twig',array(
                    'entities' => $entities,
                    ));
         $response->headers->set('Content-Type', 'text/csv');
         $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

        return $response;
    }


    /**
     * Displays a form to edit an existing profil entity.
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function editMeAction() {
        $entity = $this->container->get('security.context')->getToken()->getUser();
        $isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
        $form = $this->createForm(new UserType(false, $isAdmin), $entity);
        return $this->render('AppBundle:myProfile:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }


    /**
     * Edits an existing profil entity.
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     */
    public function updateMeAction(Request $request, \AppBundle\Entity\User $entity) {
        $em = $this->getDoctrine()->getManager();
        $isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
        $form = $this->createForm(new UserType(false, $isAdmin), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $entity->getImage()->manualRemove($entity->getImage()->getAbsolutePath());
            $entity->getImage()->upload();

            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Sus cambios han sido guardados.");
            return $this->redirect($this->generateUrl('app_profile_edit', array('name' => $entity->getId())));
        }
        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario presentado !");

        return $this->render('AppBundle:myProfile:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }
}
