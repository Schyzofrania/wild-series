<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
/**
 *  @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{
    /**
     *  Show all rows from Program's entity
     * 
     *  @Route("/", name="index")
     *  @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig', 
            ['programs'=> $programs,]
        );
        
    }
    /**
     * Getting a program by id
     *
     * @Route("/{id}", name="show")
     * @return Response
     */
    public function show(int $id):Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);
        
        $season = $program->getSeasons();    

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons'=> $season,
        ]);
    }

    /**
    * @Route("/{programId}/seasons/{seasonId}", methods={"GET"}, name="season_show")
    */
    public function showSeason(int $programId, int $seasonId):Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId]);

        $episodes = $seasons->getEpisodes();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $seasons,
            'episodes' => $episodes,
        ]);
    }    
}