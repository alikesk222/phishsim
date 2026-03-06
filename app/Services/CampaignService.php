<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignTarget;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CampaignService
{
    public function launch(Campaign $campaign): void
    {
        $campaign->update(['status' => 'running', 'started_at' => now()]);

        $targets = $campaign->targets()
            ->where('status', 'pending')
            ->with('employee')
            ->get();

        foreach ($targets as $target) {
            try {
                $this->sendPhishingEmail($campaign, $target);
                $target->update(['status' => 'sent', 'sent_at' => now()]);
            } catch (\Throwable $e) {
                Log::error("PhishSim: failed to send to {$target->employee->email}: {$e->getMessage()}");
                $target->update(['status' => 'bounced']);
            }

            if ($campaign->send_delay_seconds > 0) {
                sleep($campaign->send_delay_seconds);
            }
        }

        $campaign->update(['status' => 'completed', 'completed_at' => now()]);
    }

    private function sendPhishingEmail(Campaign $campaign, CampaignTarget $target): void
    {
        $employee = $target->employee;
        $template = $campaign->template;

        $trackBase  = config('app.url');
        $pixelUrl   = "{$trackBase}/t/pixel/{$target->token}";
        $clickUrl   = "{$trackBase}/t/click/{$target->token}";

        $subject    = $template->renderSubject($employee);
        $bodyHtml   = $template->renderBody($employee, $clickUrl, $pixelUrl);

        Mail::html($bodyHtml, function ($message) use ($template, $employee, $subject) {
            $message
                ->to($employee->email, $employee->full_name)
                ->from($template->sender_email, $template->sender_name)
                ->subject($subject);
        });
    }
}
