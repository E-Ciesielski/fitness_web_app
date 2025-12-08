<?php

namespace App\Controller;

use App\Entity\DailyLog;
use App\Entity\DailyLogMeals;
use App\Repository\DailyLogMealsRepository;
use App\Repository\DailyLogRepository;
use App\Repository\MealRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calories')]
class DailyLogController extends AbstractController
{
    #[Route('', name: 'app_daily_log_index', methods: ['GET'])]
    public function index(MealRepository               $mealRepository,
                          DailyLogMealsRepository      $dailyLogMealsRepository,
                          DailyLogRepository           $dailyLogRepository,
                          #[MapQueryParameter] ?string $date = null,
                          #[MapQueryParameter] string  $search = ''): Response
    {
        if ($date === null) {
            $date = new DateTimeImmutable('now');
        } else {
            $date = DateTimeImmutable::createFromFormat('Y-m-d', $date);
            if ($date === false) {
                $date = new DateTimeImmutable('now');
            }
        }
        $mealsSearch = $mealRepository->searchByName($search);
        $dailyLog = $dailyLogRepository->findOneBy(['date' => $date]);
        $dailyLogMeals = [];

        if ($dailyLog !== null) {
            $dailyLogMeals = $dailyLogMealsRepository->findBy(['dailyLog' => $dailyLog]);
        }

        return $this->render('daily_log/index.html.twig', [
            'date' => $date->format('Y-m-d'),
            'mealsSearch' => $mealsSearch,
            'search' => $search,
            'dailyLogMeals' => $dailyLogMeals,
        ]);
    }

    #[Route('', name: 'app_daily_log_new_meal', methods: ['POST'])]
    public function new(Request                $request,
                            EntityManagerInterface $em,
                            DailyLogRepository     $dailyLogRepository,
                            MealRepository         $mealRepository): Response
    {
        $body = $request->getPayload();
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $body->get('date'));

        $dailyLog = $dailyLogRepository->findOneBy(['date' => $date]);
        if ($dailyLog === null) {
            $dailyLog = new DailyLog();
            $dailyLog->setDate($date)->setMaxCalories(2000); //TODO: set max calories for user settings data
            $em->persist($dailyLog);
        }

        $mealId = $body->get('meal');
        $meal = $mealRepository->find($mealId);
        if ($meal === null) {
            throw $this->createNotFoundException('Meal not found');
        }

        $dailyLogMeal = new DailyLogMeals();
        $dailyLogMeal->setDailyLog($dailyLog)->setMeal($meal);

        $em->persist($dailyLogMeal);
        $em->flush();

        return $this->redirectToRoute('app_daily_log_index', ['date' => $date->format('Y-m-d')], Response::HTTP_SEE_OTHER);
    }
}
