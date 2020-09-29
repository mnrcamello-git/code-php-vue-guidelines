<?php

namespace App\Repositories\Eloquent\Api;

use App\Model\Freelancer\FreelancerCompany;
use App\Model\Freelancer\Freelancer;
use App\Model\Freelancer\FreelancerProfile;
use App\Model\Gdpr\Gdpr;
use App\Repositories\Contracts\Api\FreelancerInterface;
use Illuminate\Database\Eloquent\Builder;

class FreelancerDataManipulation implements FreelancerInterface
{
    /**
     * Inject model in constructor so that
     * it is only in one place if we have to change the model
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Model that access database using eloquent and interface for standard parameters
     * @param $freelancer
     * @param $input
     * @return mixed
     */
    public function storeFreelancerSkills($freelancer, $input)
    {
        if ($freelancer
            ->skill
            ->contains($input['skill_id'])
        ) {
            $freelancer
                ->skill()
                ->updateExistingPivot($input['skill_id'], $input);
        } else {
            $freelancer
                ->skill()
                ->attach(
                    $input['skill_id'],
                    [
                        'rating' => $input['rating'],
                        'skill_order' => $input['skill_order']
                    ]
                );
        }

        return $freelancer
                ->skill()
                ->get();
    }

}
