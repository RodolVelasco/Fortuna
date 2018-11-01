<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return new Response("RMA");
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function statsAction(Request $request)
    {
        $daterange = $request->get('daterange');
        $statsHandler = $this->get('app.stats_handler')->setDateRange($daterange);
        $availableWidgets = ['meds', 'stock', 'cnss', 'consultations_demande', 'consultations_demande_gender', 'consultations_demande_resident',
                         'consultations_demande_resident_gender', 'consultations_systematique_resident', 'consultations_systematique_resident_gender',
                          'consultations_visual_issue', 'consultations_special', 'consultations_special_gender', 'consultations_chronic',
                          'consultations_not_chronic', 'consultations_structures'];
        $widgets = $request->get('widgets');
        $stats = [];
        if (isset($widgets)) {
            foreach ($widgets as $key => $val) {
                if(in_array($key, $availableWidgets))
                    $stats[$key] = $statsHandler->setDataColumn($key)->processData();
            }
        }

        return $this->render('AppBundle:Default:ajaxStats.html.twig', array(
            'stats' => $stats));
    }

    /**
     * @Secure(roles="ROLE_USER")
     */
    public function estadisticasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sorteos = $em->getRepository('AppBundle:Sorteo')->createQueryBuilder('s')
           ->select('count(s)')
           ->getQuery()
           ->getSingleScalarResult();

        $ganadores = $em->getRepository('AppBundle:Sorteo')->createQueryBuilder('s')
           ->select('count(s)')
           ->where('s.ganador is not null')
           ->getQuery()
           ->getSingleScalarResult();

        $numerosVendidos = $em->getRepository('AppBundle:Participa')->createQueryBuilder('p')
           ->select('count(p)')
           ->where('p.user is not null')
           ->getQuery()
           ->getSingleScalarResult();

        $usuarios = $em->getRepository('AppBundle:User')->createQueryBuilder('u')
           ->select('count(u)')
           ->getQuery()
           ->getSingleScalarResult();

        return $this->render('AppBundle:Default:estadisticas.html.twig', array(
            'sorteos' => $sorteos,
            'ganadores' => $ganadores,
            'numerosVendidos' => $numerosVendidos,
            'usuarios' => $usuarios));
    }
}
