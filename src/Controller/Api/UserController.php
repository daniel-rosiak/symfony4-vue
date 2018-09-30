<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package App\Controller\Api
 */
class UserController extends ApiController
{
    /**
     * @Route("/api/users", methods={"GET"})
     *
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $users = $userRepository->getAll($this->prepareParameters($request->query->all()));
        return $this->response(
            $users['body'],
            $users['header']['code']
        );
    }
}
