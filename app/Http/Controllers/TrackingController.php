<?php

namespace App\Http\Controllers;

use App\Models\CampaignTarget;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Tracking pixel — 1x1 transparent GIF, marks email as opened.
     */
    public function pixel(string $token)
    {
        $target = CampaignTarget::where('token', $token)->first();
        if ($target && $target->campaign->track_opens) {
            $target->markOpened(request()->ip(), request()->userAgent() ?? '');
        }

        // Return 1x1 transparent GIF
        return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'), 200, [
            'Content-Type'  => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }

    /**
     * Click tracker — records the click and redirects to landing page.
     */
    public function click(string $token)
    {
        $target = CampaignTarget::with('campaign.landingPage')->where('token', $token)->first();

        if (!$target) {
            abort(404);
        }

        if ($target->campaign->track_clicks) {
            $target->markClicked(request()->ip(), request()->userAgent() ?? '');
        }

        // Show landing page
        $campaign = $target->campaign;
        if ($campaign->landingPage) {
            return view('tracking.landing', [
                'html'                => $campaign->landingPage->html,
                'capture_credentials' => $campaign->capture_credentials && $campaign->landingPage->capture_credentials,
                'token'               => $token,
            ]);
        }

        return view('tracking.default-landing', ['token' => $token]);
    }

    /**
     * Credential submission — records that credentials were entered (NOT the actual values).
     */
    public function submit(string $token, Request $request)
    {
        $target = CampaignTarget::with('campaign')->where('token', $token)->first();

        if ($target && $target->campaign->capture_credentials) {
            // Only store field names and whether they were filled — NOT values
            $fields = $request->except(['_token', '_method']);
            $target->markSubmitted(request()->ip(), request()->userAgent() ?? '', $fields);
        }

        return view('tracking.awareness', ['token' => $token]);
    }

    /**
     * Report — employee reports the email as suspicious.
     */
    public function report(string $token)
    {
        $target = CampaignTarget::where('token', $token)->first();
        if ($target) {
            $target->markReported();
        }
        return view('tracking.reported');
    }
}
