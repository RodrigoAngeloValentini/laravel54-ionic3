<?php
/**
 * Created by PhpStorm.
 * User: rodrigoangelo
 * Date: 31/07/17
 * Time: 21:01
 */

namespace CodeFlix\Http\Controllers\Api;


use CodeFlix\Repositories\PlanRepository;

class PlansController
{
    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }


}