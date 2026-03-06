<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\PhishingTemplate;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function __construct(private CampaignService $service) {}

    private function org() { return Auth::user()->organization; }

    public function index()
    {
        $campaigns = $this->org()->campaigns()
            ->with(['template', 'targets'])
            ->latest()
            ->paginate(15);
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $templates = PhishingTemplate::where('is_global', true)
            ->orWhere('organization_id', $this->org()->id)
            ->get();
        $employees = $this->org()->employees()->where('is_active', true)->orderBy('first_name')->get();
        return view('campaigns.create', compact('templates', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:150',
            'phishing_template_id'  => 'required|exists:phishing_templates,id',
            'employee_ids'          => 'required|array|min:1',
            'employee_ids.*'        => 'exists:employees,id',
            'scheduled_at'          => 'nullable|date|after:now',
            'track_opens'           => 'boolean',
            'track_clicks'          => 'boolean',
            'capture_credentials'   => 'boolean',
        ]);

        $org = $this->org();
        $campaign = $org->campaigns()->create([
            ...$data,
            'created_by' => Auth::id(),
            'status'     => $request->scheduled_at ? 'scheduled' : 'draft',
        ]);

        // Create targets
        foreach ($request->employee_ids as $empId) {
            // Only employees belonging to this org
            if ($org->employees()->where('id', $empId)->exists()) {
                CampaignTarget::create([
                    'campaign_id' => $campaign->id,
                    'employee_id' => $empId,
                ]);
            }
        }

        return redirect()->route('campaigns.show', $campaign)->with('success', 'Campaign created.');
    }

    public function show(Campaign $campaign)
    {
        abort_if($campaign->organization_id !== $this->org()->id, 403);
        $campaign->load(['template', 'targets.employee']);
        $targets = $campaign->targets;
        return view('campaigns.show', compact('campaign', 'targets'));
    }

    public function launch(Campaign $campaign)
    {
        abort_if($campaign->organization_id !== $this->org()->id, 403);
        abort_unless($campaign->isEditable(), 422, 'Campaign cannot be launched in its current state.');

        $this->service->launch($campaign);
        return back()->with('success', 'Campaign launched! Emails are being sent.');
    }

    public function destroy(Campaign $campaign)
    {
        abort_if($campaign->organization_id !== $this->org()->id, 403);
        $campaign->delete();
        return redirect()->route('campaigns.index')->with('success', 'Campaign deleted.');
    }
}
