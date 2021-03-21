<?php

namespace Api\Domain\Controllers;

use Infrastructure\Http\Controller;
use Api\Domain\Requests\DomainSignupRequest;
use Api\PostponedAction\Services\PostponedActionService;
use Api\Domain\Requests\DomainSignupVerificationLinkRequest;
use Api\PostponedAction\Requests\PostponedActionExecuteRequest;

/**
 * @OA\Schema()
 */
class DomainController extends Controller
{
    /**
     * Create a domain
     *
     * # General notes
     *
     * When creating a domain you must provide at least one admin user (`is_admin` option in `users->user` object ).
     *
     * All admins will be emailed to confirm domain creation.
     *
     * # Domain settings
     *
     * You can override default domain settings
     *
     * See [Default Settings](https://docs.fusionpbx.com/en/latest/advanced/default_settings.html#default-settings)
     * and [Override a Default Setting for one domain](https://docs.fusionpbx.com/en/latest/advanced/domains.html#override-a-default-setting-for-one-domain)
     * to understand how override works.
     *
     * Check examples as well.
     *
    @OA\Post(
        tags={"Domain"},
        path="/domain/signup",
        @OA\RequestBody(
            description="Domain information",
            required=true,
            @OA\JsonContent(
                allOf={
                    @OA\Schema(ref="#/components/schemas/DomainCreateSchema"),
                },
                examples={
                    "Create domain all fields": {},
                    "Create domain basic example": {
                        "summary" : "`TODO example`",
                        "value": {
                            "code": 403,
                            "message": "登录失败",
                            "data": null
                        }
                    },
                }
            ),
        ),
        @OA\Response(
            response=200,
            description="Domain created response",
            @OA\JsonContent(
                allOf={
                    @OA\Schema(ref="#/components/schemas/DomainCreateSchema"),
                },
                examples={
                    "Create domain basic example1": {
                        "summary": "Create domain with language settings",
                        "value": {
                            "code": 403,
                            "message": "登录失败",
                            "data": null
                        }
                    },
                }
            ),
        ),
        @OA\Response(
            response=400,
            description="`TODO Stub` Could not created domain",
            @OA\JsonContent(
                example={
                    "messages": {
                        "Missing admin user",
                        "No password for email",
                    },
                },
            ),
        ),
    )
     */
    public function signup(DomainSignupRequest $request, PostponedActionService $postponedActionService)
    {
        return $this->response($postponedActionService->create($request->all()), 201);
    }

    /**
     * Activate user by email link. In cases it's and admin user, activate domain as well
     *
     * Whom to send activation link is determined by configuration [`TODO` Implement this logic ]: 
     * * Main domain admin user
     * * A email determined by laravel configuration
     * * The users mentioned as admin users when creating domain signup (passed with the signup request)
     * * All FPBX users which have permission to create domain
     * * All above
     *
     * Depending on configuration, 
     *
    @OA\Get(
        tags={"Domain"},
        path="/domain/activate/{hash}/{email}",
        @OA\Parameter(
            name="hash",
            in="path",
            required=true,
            @OA\Schema(
                type="string",
                format="uuid",
                example="541f8e60-5ae0-11eb-bb80-b31e63f668c8",
            )
        ),
        @OA\Response(response=200, description="`TODO Stub` Success ..."),
        @OA\Response(response=400, description="`TODO Stub` Could not ..."),
    )
    */
    public function activate($hash, $email, DomainSignupVerificationLinkRequest $request, PostponedActionService $postponedActionService)
    {
        return $this->response($postponedActionService->executeByHash($hash, $email), 201);
    }

    /**
     * Resend domain signup verification link
     *
    @OA\Get(
        tags={"Domain"},
        path="/domain/resend/{hash}",
        @OA\Parameter(
            name="hash",
            in="path",
            required=true,
            @OA\Schema(
                type="string",
                format="uuid",
                example="541f8e60-5ae0-11eb-bb80-b31e63f668c8",
            )
        ),
        @OA\Response(response=200, description="`TODO Stub` Success ..."),
        @OA\Response(response=400, description="`TODO Stub` Could not ..."),
    )
    */
    public function resend($hash, PostponedActionExecuteRequest $request, PostponedActionService $postponedActionService)
    {
        return $this->response($postponedActionService->executeByHash($hash), 201);
    }

    /**
     * Update a domain `TODO Implement`
     *
     * Depending on permissions will allow or not updating certain values
     *
    @OA\Put(
        tags={"Domain"},
        path="/domain/{domain_uuid}",
        @OA\Parameter(ref="#/components/parameters/domain_uuid"),
        @OA\RequestBody(
            description="Domain information",
            required=true,
            @OA\JsonContent(
                allOf={
                    @OA\Schema(ref="#/components/schemas/DomainSchema"),
                },
                examples={
                    "Domain all fields": {},
                    "Create domain basic example": {
                        "summary" : "`TODO example`",
                        "value": {
                            "code": 403,
                            "message": "登录失败",
                            "data": null
                        }
                    },
                }
            ),
        ),
        @OA\Response(
            response=200,
            description="Domain created response",
            @OA\JsonContent(
                allOf={
                    @OA\Schema(ref="#/components/schemas/Domain"),
                },
            ),
        ),
        @OA\Response(
            response=400,
            description="`TODO Stub` Could not created domain",
            @OA\JsonContent(
                example={
                    "messages": {
                        "Missing admin user",
                        "No password for email",
                    },
                },
            ),
        ),
    )
    */

    /**
     * Delete a domain `TODO descendant delete with users, extensions etc`
     *
     * Not implemented yet
     *
    @OA\Delete(
        tags={"Domain"},
        path="/domain/{domian_uuid}",
        @OA\Parameter(ref="#/components/parameters/domain_uuid"),
        @OA\Response(response=200, description="`TODO Stub` Success ..."),
        @OA\Response(response=400, description="`TODO Stub` Could not ..."),
    )
    */
}
