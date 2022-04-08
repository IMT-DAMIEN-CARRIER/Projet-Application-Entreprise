<?php

namespace App\Controller;

use App\Repository\ElementFormationRepository;
use App\Service\BreadcrumbsService;
use App\Service\CurlCallService;
use http\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
class HomeController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="homepage"
     * )
     *
     * @param CurlCallService $curlCallService
     *
     * @return Response
     */
    public function index(CurlCallService $curlCallService): Response
    {
        $elementFormations = [];

        $arrayResults = $curlCallService->getElementFormationById(1);

        if (empty($arrayResults)) {
            throw new NotFoundHttpException('Il y a eu une erreur.');
        }

        $elementFormations[] = $arrayResults;

        return $this->render(
            'homepage/index.html.twig',
            [
                'elementFormations' => $elementFormations,
                'sons' => $arrayResults['sons'],
            ]
        );
    }

    /**
     * @Route(
     *     "/get_element_formation_by_id/{id}",
     *     name="get_element_formation_by_id"
     * )
     *
     * @param BreadcrumbsService $breadcrumbsService
     * @param int                $id
     *
     * @return Response
     */
    public function getElementFormationById(BreadcrumbsService $breadcrumbsService, int $id): Response
    {
        $results = $breadcrumbsService->generateArrayBreadcrumbs($id);
        $elementFormations = $results['elementFormations'];
        $sons = $results['sons'];

        if (empty($elementFormations)) {
            throw new InvalidArgumentException('Une erreur est survenue.');
        }

        return $this->render(
            'homepage/index.html.twig',
            [
                'elementFormations' => $elementFormations,
                'sons' => $sons,
            ]
        );
    }
}
