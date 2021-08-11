<?php

namespace App\Controller;

use App\Repository\DayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(DayRepository $repo, EntityManagerInterface $em): Response
    {
        $days_bdd = $repo->findAll();
        $beginDate = new \DateTime('2021-08-02');
        $endDate = new \DateTime('2021-08-07');

        //calendrier avec créneaux par jour
        $daterange = new \DatePeriod($beginDate, new \DateInterval('P1D'), $endDate);
        $dates = array();
        foreach ($daterange as $date) {
            $slots = array();
            $beginSlot = new \DateTime('09:00');
            $endSlot = new \DateTime('18:00');
            $slotRange = new \DatePeriod($beginSlot, new \DateInterval('PT1H'), $endSlot);
            foreach ($slotRange as $slot) {
                if ($slot->format("H:i") == "13:00") {
                    continue;
                }
                array_push($slots, $slot->format("H:i"));
            }
            $dates[$date->format("Y-m-d")] = $slots;
        }

        //gestion des créneaux disponibles
        $dates_bdd = array();
        foreach ($days_bdd as $not_available) {
            $key = $not_available->getDate()->format("Y-m-d");
            $dates_bdd[$key] = [$not_available->getSlot9h(), $not_available->getSlot10h(), $not_available->getSlot11h(), $not_available->getSlot12h(), $not_available->getSlot14h(), $not_available->getSlot15h(), $not_available->getSlot16h(), $not_available->getSlot17h()];
        }

        return $this->render('session/session.html.twig', [
            'sessions' => $days_bdd,
            'dates' => $dates,
            'dates_bdd' => $dates_bdd,
        ]);
    }
}
