<?php

namespace App\Http\Controllers\Api\v1\Freelancer;

use App\Http\Resources\Freelancer\FreelancerSkillResource;
use App\Mail\WelcomeEmail;
use App\Http\Requests\Freelancer\FreelancerSkillUpdateRequest;
use App\Http\Resources\Freelancer\FreelancerSkillCollection;
use App\Repositories\Contracts\Api\FreelancerInterface;
use App\Container\SkillRelations\SkillRelationsInterface;
use App\Http\Requests\Freelancer\FreelancerSkillRequest;
use App\Http\Requests\Freelancer\RegistrationRequest;
use App\Http\Requests\Freelancer\UpdateRegistrationRequest;
use App\Http\Requests\Freelancer\NextStepRegistrationRequest;
use App\Http\Requests\Freelancer\UpdateProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FreelancerController extends Controller
{
     /**
      * This access user free lancer skills inside database via Laravel model
     * @param Request $request
     * @param FreelancerInterface $repository
     * @param $id
     * @return mixed
     */
    public function freelancerSkills(Request $request, FreelancerInterface $repository, $id)
    {
        if (! ($freelancer = $repository->findViaId($id))) {
            return response([
                'http_code' => 404,
                'message' => 'Freelancer not found'
            ]);
        }

        /** Repository and interface for model */
        $skills = $repository->freelancerSkills($freelancer, $request->all());

        return response(
            FreelancerSkillCollection::make($skills)->setHttpCode()
        );
    }
}
