<?php

namespace App\Repositories\Contracts\Api;

interface FreelancerInterface
{
    /**
     * Employers list of collection
     */
    public function collection();


    public function storeFreelancerSkills($freelancer, $input);
}
