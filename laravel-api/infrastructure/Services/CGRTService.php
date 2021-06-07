<?php

namespace Infrastructure\Services;

use GuzzleHttp\Client;
use Api\User\Models\User;
use Infrastructure\Events\CGRTFailedEvent;

/**
 * ^api/ ^ login/ [name='login']
 * ^api/ ^ logout/ [name='logout']
 * ^api/ ^users/add_credit_balance$ [name='add_credit_balance']
 * ^api/ ^users/add_sipaccount|users/add_sipendpoint$ [name='add_sipaccount']
 * ^api/ ^users/add_user_to_group$ [name='add_user_to_group']
 * ^api/ ^users/agent_add$ [name='agent_add']
 * ^api/ ^users/agent_clients_list$ [name='agent_clients_list']
 * ^api/ ^users/agent_invoices_list$ [name='agent_invoices_list']
 * ^api/ ^users/agent_update$ [name='agent_update']
 * ^api/ ^users/billing_profile_add$ [name='api_billingprofile_add']
 * ^api/ ^users/billing_profile_delete$ [name='api_billingprofile_delete']
 * ^api/ ^users/billing_profile_list$ [name='api_billingprofile_list']
 * ^api/ ^users/billing_profile_update$ [name='api_billingprofile_update']
 * ^api/ ^users/blocked_number_add$ [name='blocked_number_add']
 * ^api/ ^users/blocked_number_delete$ [name='blocked_number_delete']
 * ^api/ ^users/blocked_number_list$ [name='blocked_number_list']
 * ^api/ ^users/blocked_number_update$ [name='blocked_number_update']
 * ^api/ ^users/call_detail_summary$ [name='call_detail_summary']
 * ^api/ ^users/callerid_add$ [name='api_callerid_add']
 * ^api/ ^users/callerid_delete$ [name='api_callerid_delete']
 * ^api/ ^users/callerid_list$ [name='api_callerid_list']
 * ^api/ ^users/callerid_update$ [name='api_callerid_update']
 * ^api/ ^users/card_capture_stripe$ [name='card_capture_stripe']
 * ^api/ ^users/card_payment_stripe$ [name='card_payment_stripe']
 * ^api/ ^users/card_refund_stripe$ [name='card_refund_stripe']
 * ^api/ ^users/charge_item_add$ [name='api_charge_item_add']
 * ^api/ ^users/charge_item_list$ [name='api_charge_item_list']
 * ^api/ ^users/charge_item_update$ [name='api_charge_item_update']
 * ^api/ ^users/check_call_rate$ [name='check_call_rate']
 * ^api/ ^users/client_add$ [name='client_add']
 * ^api/ ^users/client_update$ [name='client_update']
 * ^api/ ^users/create_group$ [name='create_group']
 * ^api/ ^users/create_user$ [name='create_user']
 * ^api/ ^users/delete_sipaccount|users/delete_sipendpoint$ [name='delete_sipaccount']
 * ^api/ ^users/delete_user$ [name='delete_user']
 * ^api/ ^users/did_add$ [name='did_add']
 * ^api/ ^users/did_assign$ [name='did_assign']
 * ^api/ ^users/did_available$ [name='did_available']
 * ^api/ ^users/did_call_detail_summary$ [name='did_call_detail_summary']
 * ^api/ ^users/did_call_usage_details$ [name='did_call_usage_details']
 * ^api/ ^users/did_cancel$ [name='did_cancel']
 * ^api/ ^users/did_delete$ [name='did_delete']
 * ^api/ ^users/did_inventory$ [name='did_inventory']
 * ^api/ ^users/did_order$ [name='did_order']
 * ^api/ ^users/did_reserve$ [name='did_reserve']
 * ^api/ ^users/did_suspend$ [name='did_suspend']
 * ^api/ ^users/did_update$ [name='did_update']
 * ^api/ ^users/gateway_enable_disable$ [name='gateway_enable_disable']
 * ^api/ ^users/get_balance_history$ [name='get_balance_history']
 * ^api/ ^users/get_cdr_client$ [name='get_cdr_client']
 * ^api/ ^users/get_cdr_summary$ [name='get_cdr_summary']
 * ^api/ ^users/get_client_account$ [name='get_client_account']
 * ^api/ ^users/get_client_did$ [name='get_client_did']
 * ^api/ ^users/get_client_invoices$ [name='get_client_invoices']
 * ^api/ ^users/get_client_package_details$ [name='get_client_package_details']
 * ^api/ ^users/get_client_sipaccount|users/get_client_sipendpoint$ [name='get_client_sipaccount']
 * ^api/ ^users/get_clients$ [name='get_clients']
 * ^api/ ^users/get_credit_balance$ [name='get_credit_balance']
 * ^api/ ^users/get_did_details$ [name='get_did_details']
 * ^api/ ^users/get_groups$ [name='get_groups']
 * ^api/ ^users/get_rates$ [name='get_rates']
 * ^api/ ^users/get_sipaccount_details|users/get_sipendpoint_details$ [name='get_sipaccount_details']
 * ^api/ ^users/get_tariffplan_list$ [name='get_tariffplan_list']
 * ^api/ ^users/get_tax_report$ [name='get_tax_report']
 * ^api/ ^users/get_tenants_list$ [name='get_tenants_list']
 * ^api/ ^users/get_token$ [name='get_token']
 * ^api/ ^users/get_users$ [name='get_users']
 * ^api/ ^users/lnp_lookup$ [name='lnp_lookup']
 * ^api/ ^users/make_invoice_payment$ [name='make_invoice_payment']
 * ^api/ ^users/most_expensive_calls$ [name='api_most_expensive_calls']
 * ^api/ ^users/order_add$ [name='api_order_add']
 * ^api/ ^users/order_item_add$ [name='api_order_item_add']
 * ^api/ ^users/order_item_delete$ [name='api_order_item_delete']
 * ^api/ ^users/order_item_list$ [name='api_order_item_list']
 * ^api/ ^users/order_item_update$ [name='api_order_item_update']
 * ^api/ ^users/order_list$ [name='api_order_list']
 * ^api/ ^users/order_update$ [name='api_order_update']
 * ^api/ ^users/outbound_call_usage_details$ [name='outbound_call_usage_details']
 * ^api/ ^users/package_assign$ [name='package_assign']
 * ^api/ ^users/package_cancel$ [name='package_cancel']
 * ^api/ ^users/reset_balance_all$ [name='reset_balance_all']
 * ^api/ ^users/reset_balance$ [name='reset_balance']
 * ^api/ ^users/reset_password$ [name='reset_password']
 * ^api/ ^users/sipendpoint_group_add$ [name='sipendpoint_group_add']
 * ^api/ ^users/sipendpoint_group_delete$ [name='sipendpoint_group_delete']
 * ^api/ ^users/sipendpoint_group_update$ [name='sipendpoint_group_update']
 * ^api/ ^users/tariffplan_assign$ [name='tariffplan_assign']
 * ^api/ ^users/tariffplan_remove$ [name='tariffplan_remove']
 * ^api/ ^users/tax_add$ [name='api_tax_add']
 * ^api/ ^users/tax_delete$ [name='api_tax_delete']
 * ^api/ ^users/tax_list$ [name='api_tax_list']
 * ^api/ ^users/tax_update$ [name='api_tax_update']
 * ^api/ ^users/tenant_add$ [name='tenant_add']
 * ^api/ ^users/tenant_disable$ [name='tenant_disable']
 * ^api/ ^users/tenant_enable$ [name='tenant_enable']
 * ^api/ ^users/tenant_update$ [name='tenant_update']
 * ^api/ ^users/top_destinations$ [name='api_top_destinations']
 * ^api/ ^users/update_client_package$ [name='update_client_package']
 * ^api/ ^users/update_sipaccount|users/update_sipendpoint$ [name='update_sipaccount']
 * ^api/ ^users/user_auth$ [name='user_auth']
 * ^api/ ^users/voicemail_msg_delete$ [name='api_voicemail_msg_delete']
 * ^api/ ^users/voicemail_msgs_list$ [name='api_voicemail_msgs_list']
 */

class CGRTService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct($base_url, $username, $password)
    {
        $client = new Client(['base_uri' => $base_url]);

        try {
            $request = [
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ]
            ];
            $response = $client->post('users/get_token',  $request);
        } catch (\Throwable $th) {
            event(new CGRTFailedEvent($request, $th->getMessage()));
            return false;
        }


        $token = json_decode($response->getBody()->getContents())->token;

        $this->client = new Client([
            'base_uri' => $base_url,
            'headers' => ['Authorization' => 'Token ' . $token]
        ]);

        return $this;
    }

    public function getTenants(): array
    {
        try {
            $r = $this->client->post('users/get_tenants_list');
        } catch (\Throwable $th) {
            event(new CGRTFailedEvent(null, $th->getMessage()));
            return [];
        }

        $results = json_decode($r->getBody()->getContents())->results;

        return $results;
    }

    public function getReferenceCodes(): array
    {
        $tenants = $this->getTenants();

        $reseller_codes = [];

        foreach ($tenants as $key => $tenant) {
            $request = ['json' => ['tenant' => $tenant]];
            try {
                $clients = json_decode($this->client->post('users/get_clients', $request)->getBody()->getContents())->results;
            } catch (\Throwable $th) {
                event(new CGRTFailedEvent($request, $th->getMessage()));
                return [];
            }

            $clients = collect($clients);
            $account_codes = $clients->pluck('account_code')->toArray();
            $reseller_codes = array_merge($reseller_codes, $account_codes);
        }

        return $reseller_codes;
    }

    private function getTenant($domain_name)
    {
        $tenants = $this->getTenants();

        $tenant = config('fpbx.default.domain.mothership_domain');

        if (in_array($domain_name, $tenants)) {
            $tenant = $domain_name;
        }
        if (empty($tenant)) {
            $tenants = $tenants[0];
        }


        return $tenant;
    }

    public function addClient(User $user)
    {
        $data = [];

        // $contact = $user->contacts()->first();
        $reseller_code = $user->reseller_code;

        $name = optional($user->extensions()->first())->getAttribute('effective_caller_id_name');
        if (!$name) {
            $name = $user->username;
        }

        // $cgrt_username = $user->username . '@' . $user->domain_name;
        // $cgrt_username = $user->user_uuid;
        $cgrt_username = $user->username;
        $cgrt_username = \Str::substr(uniqid() . ' '  . $user->username, 0, 29);

        $data = array_merge(config('fpbx.cgrt.default.client_add'), [
            "tenant" => $this->getTenant($user->domainName),
            // "country" => "US",
            // "account_code" => "3847623914",
            // "account_alias" => null,
            "name" => $name,
            "cgrt_username" => $cgrt_username,
            // "company_name" => "Test Company",
            // "address_line_1" => "49 Any Street",
            "address_line_2" => $reseller_code ? 'Reseller code: ' . $reseller_code : null,
            // "city" => "New York",
            // "state_province" => "New York",
            // "postcode_zip" => null,
            // "telephone_number" => "5666556",
            // "tax_id" => null,
            "main_email" => $user->user_email,
            // "billing_email" => null,
            // "invoice_email_cc" => null,
            // "noc_email" => null,
            // "rates_email" => null,
        ]);

        $request = ['json' => $data];

        try {
            $response = $this->client->post('users/client_add', $request);
        } catch (\Throwable $th) {
            event(new CGRTFailedEvent($request, $th->getMessage()));
            return false;
        }

        $responseJson = json_decode($response->getBody()->getContents())->results;

        return $responseJson;
    }

    public function addSIPAccount(User $user, $client_added)
    {
        $extensions = $user->extensions()->get();

        $responses = [];

        foreach ($extensions as $extension) {
            $data = [];
            $data = array_merge(config('fpbx.cgrt.default.add_sipaccount'), [
                "client_account_code" => $client_added->account_code,
                "username" => $extension->getAttribute('extension'),
            ]);
            $request = ['json' => $data];

            try {
                $response = $this->client->post('users/add_sipaccount', $request);
                $responseJson = json_decode($response->getBody()->getContents())->results;
                $responses[] = $responseJson;
            } catch (\Throwable $th) {
                event(new CGRTFailedEvent($request, $th->getMessage()));
                return false;
            }
        }

        return $responses;
    }

    private function getTariffplanName($tenant)
    {
        return strtoupper(str_replace('.', '_', $tenant));
    }

    private function getRoutingplanName($tenant)
    {
        return strtoupper(str_replace('.', '_', $tenant));
    }

    public function assignTariffPlan($client_added)
    {
        $data = [];
        $data = array_merge(config('fpbx.cgrt.default.tariffplan_assign'), [
            "client_account_code" => $client_added->account_code,
            "tariffplan_name" => $this->getTariffplanName($client_added->tenant),
            "routingplan_name" => $this->getRoutingplanName($client_added->tenant),
        ]);

        $request = ['json' => $data];

        try {
            $response = $this->client->post('users/tariffplan_assign', $request);
            $responseJson = json_decode($response->getBody()->getContents())->results;
        } catch (\Throwable $th) {
            event(new CGRTFailedEvent($request, $th->getMessage()));
            return false;
        }

        return $responseJson;
    }

    public function getBalance($account_code) {
        $data = [
            "client_account_code" => $account_code,
        ];

        $request = ['json' => $data];

        try {
            $response = $this->client->post('users/get_credit_balance', $request);
            $responseJson = json_decode($response->getBody()->getContents())->results;
        } catch (\Throwable $th) {
            event(new CGRTFailedEvent($request, $th->getMessage()));
            return false;
        }

        $balance = optional(\Arr::get($responseJson, '0', new \stdClass))->credit_balance;

        return $balance;
    }
}
