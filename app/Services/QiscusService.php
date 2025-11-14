<?php

namespace App\Services;

use App\Exceptions\WhatsAppException;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QiscusService
{
    protected string $baseUrl;

    protected string $appId;

    protected string $secretKey;

    protected string $channelId;

    protected string $otpNamespace;

    protected string $otpTemplateName;

    /**
     * Load all config values from the constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('qiscus.base_url');
        $this->appId = config('qiscus.app_id');
        $this->secretKey = config('qiscus.secret_key');
        $this->channelId = config('qiscus.channel_id');
        $this->otpNamespace = config('qiscus.otp_namespace');
        $this->otpTemplateName = config('qiscus.otp_template_name');
    }

    /**
     * Send an OTP message to the user.
     *
     * @throws \App\Exceptions\WhatsAppException
     */
    public function sendOtp(User $user, string $otp): void
    {
        $url = "{$this->baseUrl}/whatsapp/v1/{$this->appId}/{$this->channelId}/messages";
        $payload = $this->buildTemplatePayload($user->phone_formatted, $otp);

        try {
            $response = Http::withHeaders([
                'Qiscus-App-Id' => $this->appId,
                'Qiscus-Secret-Key' => $this->secretKey,
            ])->post($url, $payload);

            if (! $response->successful()) {
                $this->handleError($response);
            }

            // Log::info('Qiscus OTP sent successfully to user: '.$user->id);

        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Handle connection errors (e.g., DNS, timeout)
            Log::error('Qiscus API RequestException: '.$e->getMessage());
            throw new WhatsAppException('Could not connect to the messaging service. Please try again later.');
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            Log::error('Qiscus general error: '.$e->getMessage());
            throw new WhatsAppException('An unexpected error occurred while sending your code.');
        }
    }

    /**
     * Build the Qiscus template payload.
     */
    private function buildTemplatePayload(string $phoneNumber, string $otp): array
    {
        return [
            'to' => $phoneNumber,
            'type' => 'template',
            'template' => [
                'namespace' => $this->otpNamespace,
                'name' => $this->otpTemplateName,
                'language' => [
                    'policy' => 'deterministic',
                    'code' => 'id',
                ],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otp],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            ['type' => 'text', 'text' => $otp],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Handle an unsuccessful API response.
     *
     * @throws \App\Exceptions\WhatsAppException
     */
    private function handleError(Response $response): void
    {
        Log::error("Qiscus API error: {$response->status()} - {$response->body()}");

        // Try to parse the error for a user-friendly message
        $data = $response->json();
        $error = $data['error'] ?? [];
        $errorMessage = $error['error_data']['details'] ?? $error['message'] ?? 'Failed to send verification code.';

        throw new WhatsAppException($errorMessage);
    }
}
