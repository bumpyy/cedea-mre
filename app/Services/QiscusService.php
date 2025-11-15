<?php

namespace App\Services;

use App\Exceptions\WhatsAppException;
use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class QiscusService
{
    protected PendingRequest $client;

    protected string $url;

    protected array $templates;

    protected array $defaultLanguage;

    /**
     * Load dependencies via the constructor.
     */
    public function __construct(
        PendingRequest $client,
        string $baseUrl,
        string $appId,
        string $channelId,
        array $templates,
        array $defaultLanguage
    ) {
        $this->client = $client;
        $this->templates = $templates;
        $this->defaultLanguage = $defaultLanguage;
        $this->url = "{$baseUrl}/whatsapp/v1/{$appId}/{$channelId}/messages";
    }

    /**
     * Send an OTP message to the user.
     *
     * @throws \App\Exceptions\WhatsAppException
     */
    public function sendOtp(User $user, string $otp): void
    {
        $config = $this->getTemplateConfig('otp');

        $template = $this->buildOtpTemplatePayload(
            $config['namespace'],
            $config['name'],
            $otp
        );

        $this->sendTemplateMessage($user->phone_formatted, $template);
    }

    /**
     * Send a notification message to the user.
     *
     * @param  string  $type  ('welcome', 'submission.accepted', 'submission.rejected')
     * @param  array  $headerParams  A list of strings for header parameters.
     * @param  array  $bodyParams  A list of strings for body parameters.
     *
     * @throws \App\Exceptions\WhatsAppException
     */
    public function sendNotification(User $user, string $type, array $headerParams = [], array $bodyParams = []): void
    {
        $config = $this->getTemplateConfig($type);

        $template = $this->buildNotificationTemplatePayload(
            $config['namespace'],
            $config['name'],
            $headerParams,
            $bodyParams
        );

        $this->sendTemplateMessage($user->phone_formatted, $template);

        Log::info("Qiscus notification '{$type}' sent to user: ".$user->id);
    }

    /**
     * Helper to safely get template config.
     */
    private function getTemplateConfig(string $key): array
    {
        $config = $this->templates[$key] ?? null;

        if (! $config) {
            throw new \InvalidArgumentException("Invalid Qiscus template key: {$key}");
        }
        if (empty($config['namespace']) || empty($config['name'])) {
            throw new \InvalidArgumentException("Template '{$key}' is missing namespace or name in config.");
        }

        return $config;
    }

    /**
     * A generic method to send any template message.
     */
    private function sendTemplateMessage(string $phoneNumber, array $templatePayload): void
    {
        $payload = [
            'to' => $phoneNumber,
            'type' => 'template',
            'template' => $templatePayload,
        ];

        try {
            $response = $this->client->post($this->url, $payload);

            if (! $response->successful()) {
                $this->handleError($response);
            }

        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Qiscus API RequestException: '.$e->getMessage());

            throw new WhatsAppException('Could not connect to the messaging service. Please try again later.');
        } catch (\Exception $e) {
            Log::error('Qiscus general error: '.$e->getMessage());
            throw new WhatsAppException('An unexpected error occurred while sending your message.');
        }
    }

    /**
     * Build the Qiscus OTP template payload.
     */
    private function buildOtpTemplatePayload(string $namespace, string $name, string $otp): array
    {
        return [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $this->defaultLanguage,
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
        ];
    }

    /**
     * Build the Qiscus notification template payload.
     */
    private function buildNotificationTemplatePayload(string $namespace, string $name, array $headerParams, array $bodyParams): array
    {
        $components = [];

        if (! empty($headerParams)) {
            $components[] = [
                'type' => 'header',
                'parameters' => $this->buildTextParameters($headerParams),
            ];
        }

        if (! empty($bodyParams)) {
            $components[] = [
                'type' => 'body',
                'parameters' => array_values($this->buildTextParameters($bodyParams)),
            ];
        }

        return [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $this->defaultLanguage,
            'components' => $components,
        ];
    }

    /**
     * Helper to format text parameters.
     */
    private function buildTextParameters(array $params): array
    {
        return array_map(function ($param) {
            return ['type' => 'text', 'text' => (string) $param];
        }, array_values($params));
    }

    /**
     * Handle an unsuccessful API response.
     */
    private function handleError(Response $response): void
    {
        Log::error("Qiscus API error: {$response->status()} - {$response->body()}");

        $data = $response->json();
        $error = $data['error'] ?? [];
        $errorMessage = $error['error_data']['details'] ?? $error['message'] ?? 'Failed to send verification code.';

        throw new WhatsAppException($errorMessage);
    }
}
