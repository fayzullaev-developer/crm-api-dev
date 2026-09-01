<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataFixtures\CompanyFixtures;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetClientsByCompanyAction extends AbstractController
{
    public function __invoke(Request $request, ClientRepository $clientRepository): array
    {
        $companyId = $request->query->getInt('companyId');
        $page = $request->query->getInt('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        if (!$companyId) {
            throw new BadRequestHttpException('companyId kiritish majburiy!');
        }

        return $clientRepository->findBy(['company' => $companyId], limit: 10, offset: --$page * 10);
    }
}
