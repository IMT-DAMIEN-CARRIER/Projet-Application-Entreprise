<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BreadcrumbsService.
 */
class BreadcrumbsService
{
    /**
     * @var CurlCallService
     */
    private CurlCallService $curlCallService;

    /**
     * BreadcrumbsService constructor.
     *
     * @param CurlCallService $curlCallService
     */
    public function __construct(CurlCallService $curlCallService)
    {
        $this->curlCallService = $curlCallService;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function generateArrayBreadcrumbs(int $id): array
    {
        $elementFormations = [];

        $result = $this->curlCallService->getElementFormationById($id);
        $sons = $result['sons'];

        if (empty($result)) {
            throw new NotFoundHttpException('Il y a eu un soucis avec l\'id : '.$id);
        }

        $elementFormations[] = $result;

        while (null !== $result['father']) {
            $result = $this->curlCallService->getElementFormationById($result['father']['id']);

            if (empty($result)) {
                throw new NotFoundHttpException('Il y a eu un soucis avec l\'id du père :'.$result['father']);
            }

            $elementFormations[] = $result;
        }

        return [
            'elementFormations' => array_reverse($elementFormations),
            'sons' => $sons,
        ];
    }
}
