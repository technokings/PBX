<?php

namespace App\Testing\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Testing\TestCase;
use App\Testing\TestRequestTrait;
use App\Models\PostponedAction;
use Carbon\Carbon;

class DomainActivateRequestTest extends TestCase
{
    use TestRequestTrait;

    public function validationProvider()
    {
        $this->app = $this->createApplication();

        list($request, $response) = $this->simulateDomainSignup();

        $model = PostponedAction::first();

        $second = $model->replicate();
        $second->hash = Str::uuid()->toString();
        $second->created_at = Carbon::now()->subCentury();
        $second->save();

        $hash = $model->hash;
        $emails = Arr::get($request, 'users');
        $emails = collect($emails)->pluck('user_email');
        $address = $emails[0];

        $return = [
            'no_hash_fails' => [
                'passed' => false,
                'data' => ['email' => $address],
            ],
            'no_email_fails' => [
                'passed' => false,
                'data' => ['hash' => $hash],
            ],
            'bad_hash_not_uuid_fails' => [
                'passed' => false,
                'data' => ['hash' => '1'],
            ],
            'bad_hash_not_found_fails' => [
                'passed' => false,
                'data' => ['hash' => Str::uuid()->toString()],
            ],
            'not_uuid_hash' => [
                'passed' => false,
                'data' => [
                    'hash' => $second->hash . '111',
                    'email' => $address,
                ],
            ],
            'expired_link_fails' => [
                'passed' => false,
                'data' => [
                    'hash' => $second->hash,
                    'email' => $address,
                ],
            ],
            'pass' => [
                'passed' => true,
                'data' => function() {
                    $this->simulateDomainSignup();
                    $model = PostponedAction::last();
                    $emails = Arr::get($model->request, 'users');
                    $emails = collect($emails)->pluck('user_email');
                    $address = $emails[0];

                    return [
                        'hash' => $model->hash,
                        'email' => $address,
                    ];
                },
            ],
        ];

        return $return;
    }
}