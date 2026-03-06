<?php

namespace Database\Seeders;

use App\Models\PhishingTemplate;
use Illuminate\Database\Seeder;

class PhishingTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name'         => 'IT Password Reset',
                'category'     => 'it',
                'difficulty'   => 'easy',
                'sender_name'  => 'IT Support',
                'sender_email' => 'it-support@company-helpdesk.com',
                'subject'      => 'Action Required: Your password expires in 24 hours',
                'body_html'    => $this->itPasswordReset(),
                'is_global'    => true,
                'tags'         => ['password', 'urgency', 'it'],
            ],
            [
                'name'         => 'Invoice Payment Required',
                'category'     => 'finance',
                'difficulty'   => 'medium',
                'sender_name'  => 'Accounts Payable',
                'sender_email' => 'invoices@billing-portal.net',
                'subject'      => 'Invoice #{{invoice_num}} - Payment Overdue',
                'body_html'    => $this->invoicePayment(),
                'is_global'    => true,
                'tags'         => ['invoice', 'finance', 'urgency'],
            ],
            [
                'name'         => 'HR Policy Update',
                'category'     => 'hr',
                'difficulty'   => 'medium',
                'sender_name'  => 'Human Resources',
                'sender_email' => 'hr-portal@company-hr.com',
                'subject'      => 'Important: Review and sign updated HR policy',
                'body_html'    => $this->hrPolicyUpdate(),
                'is_global'    => true,
                'tags'         => ['hr', 'document', 'policy'],
            ],
            [
                'name'         => 'Package Delivery Failed',
                'category'     => 'delivery',
                'difficulty'   => 'easy',
                'sender_name'  => 'DHL Express',
                'sender_email' => 'noreply@dhl-delivery-update.com',
                'subject'      => 'Your package could not be delivered - action required',
                'body_html'    => $this->packageDelivery(),
                'is_global'    => true,
                'tags'         => ['delivery', 'package', 'urgency'],
            ],
            [
                'name'         => 'Microsoft 365 Account Suspended',
                'category'     => 'it',
                'difficulty'   => 'medium',
                'sender_name'  => 'Microsoft Account Team',
                'sender_email' => 'account-security@microsoftonline-support.com',
                'subject'      => 'Your Microsoft 365 account has been suspended',
                'body_html'    => $this->microsoftAccount(),
                'is_global'    => true,
                'tags'         => ['microsoft', 'account', 'it'],
            ],
            [
                'name'         => 'CEO Wire Transfer Request',
                'category'     => 'finance',
                'difficulty'   => 'hard',
                'sender_name'  => 'CEO Office',
                'sender_email' => 'ceo@company-office.com',
                'subject'      => 'Urgent: Wire transfer needed today',
                'body_html'    => $this->ceoFraud(),
                'is_global'    => true,
                'tags'         => ['bec', 'ceo-fraud', 'wire-transfer'],
            ],
            [
                'name'         => 'Shared Document - Review Needed',
                'category'     => 'document',
                'difficulty'   => 'easy',
                'sender_name'  => 'SharePoint Notifications',
                'sender_email' => 'sharing-noreply@sharepoint-alerts.com',
                'subject'      => '{{first_name}} shared a file with you',
                'body_html'    => $this->sharedDocument(),
                'is_global'    => true,
                'tags'         => ['sharepoint', 'document', 'office365'],
            ],
            [
                'name'         => 'Salary Slip Available',
                'category'     => 'hr',
                'difficulty'   => 'medium',
                'sender_name'  => 'Payroll Department',
                'sender_email' => 'payroll@company-payslip.com',
                'subject'      => 'Your salary slip for this month is ready',
                'body_html'    => $this->salarySlip(),
                'is_global'    => true,
                'tags'         => ['payroll', 'hr', 'salary'],
            ],
        ];

        foreach ($templates as $t) {
            PhishingTemplate::updateOrCreate(['name' => $t['name'], 'is_global' => true], $t);
        }
    }

    private function itPasswordReset(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#f5f5f5;padding:20px">
  <div style="background:#0078d4;padding:20px;text-align:center">
    <h1 style="color:white;margin:0;font-size:22px">IT Support Portal</h1>
  </div>
  <div style="background:white;padding:30px;border-radius:0 0 4px 4px">
    <p>Dear {{first_name}},</p>
    <p>Our system has detected that your company password will <strong>expire in 24 hours</strong>.</p>
    <p>To avoid losing access to your accounts and files, please update your password immediately by clicking the button below:</p>
    <div style="text-align:center;margin:30px 0">
      <a href="#PHISHING_LINK#" style="background:#0078d4;color:white;padding:12px 30px;text-decoration:none;border-radius:4px;font-weight:bold">Update Password Now</a>
    </div>
    <p style="color:#888;font-size:12px">This link will expire in 24 hours. If you do not update your password, your account will be locked.</p>
    <hr style="border:none;border-top:1px solid #eee;margin:20px 0">
    <p style="color:#888;font-size:11px">IT Support Team &bull; Do not reply to this email</p>
  </div>
</div>
HTML;
    }

    private function invoicePayment(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto">
  <div style="background:#c0392b;padding:15px 20px">
    <h1 style="color:white;margin:0;font-size:18px">PAYMENT OVERDUE NOTICE</h1>
  </div>
  <div style="background:white;padding:25px;border:1px solid #ddd">
    <p>Dear {{first_name}} {{last_name}},</p>
    <p>This is an automated reminder that the following invoice is now <strong>overdue</strong>:</p>
    <table style="width:100%;border-collapse:collapse;margin:20px 0">
      <tr style="background:#f9f9f9"><td style="padding:10px;border:1px solid #ddd"><strong>Invoice #</strong></td><td style="padding:10px;border:1px solid #ddd">INV-2024-08847</td></tr>
      <tr><td style="padding:10px;border:1px solid #ddd"><strong>Amount Due</strong></td><td style="padding:10px;border:1px solid #ddd;color:#c0392b"><strong>$3,450.00</strong></td></tr>
      <tr style="background:#f9f9f9"><td style="padding:10px;border:1px solid #ddd"><strong>Due Date</strong></td><td style="padding:10px;border:1px solid #ddd">Overdue by 7 days</td></tr>
    </table>
    <div style="text-align:center;margin:20px 0">
      <a href="#PHISHING_LINK#" style="background:#c0392b;color:white;padding:12px 25px;text-decoration:none;border-radius:4px">Pay Invoice Now</a>
    </div>
    <p style="color:#888;font-size:11px">To avoid service interruption, please settle this invoice within 48 hours.</p>
  </div>
</div>
HTML;
    }

    private function hrPolicyUpdate(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#fff;border:1px solid #e0e0e0">
  <div style="background:#2c3e50;padding:20px">
    <h1 style="color:white;margin:0;font-size:20px">Human Resources</h1>
  </div>
  <div style="padding:25px">
    <p>Dear {{first_name}},</p>
    <p>We have updated our <strong>Employee Code of Conduct and Remote Work Policy</strong>. All employees are required to review and digitally sign the updated document by <strong>end of this week</strong>.</p>
    <p>Failure to sign within the deadline may affect your employment status.</p>
    <div style="text-align:center;margin:25px 0">
      <a href="#PHISHING_LINK#" style="background:#2c3e50;color:white;padding:12px 28px;text-decoration:none;border-radius:4px;font-weight:bold">Review & Sign Document</a>
    </div>
    <p style="color:#888;font-size:11px">HR Department &bull; This message was sent to {{email}}</p>
  </div>
</div>
HTML;
    }

    private function packageDelivery(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto">
  <div style="background:#ffcc00;padding:15px 20px;display:flex;align-items:center">
    <h1 style="margin:0;font-size:20px;color:#333">DHL Express Notification</h1>
  </div>
  <div style="background:white;padding:25px;border:1px solid #ddd">
    <p>Dear Customer,</p>
    <p>We attempted to deliver your package today but were <strong>unable to complete the delivery</strong>.</p>
    <p><strong>Tracking Number:</strong> 1Z999AA10123456784</p>
    <p>To schedule a redelivery or pick up your package from our depot, please verify your address details:</p>
    <div style="text-align:center;margin:20px 0">
      <a href="#PHISHING_LINK#" style="background:#FFCC00;color:#333;padding:12px 28px;text-decoration:none;border-radius:4px;font-weight:bold">Confirm Delivery Address</a>
    </div>
    <p style="color:#888;font-size:11px">Your package will be returned to sender after 5 business days.</p>
  </div>
</div>
HTML;
    }

    private function microsoftAccount(): string
    {
        return <<<HTML
<div style="font-family:'Segoe UI',Arial,sans-serif;max-width:600px;margin:0 auto;background:#f3f3f3;padding:20px">
  <div style="background:white;border-top:4px solid #0078d4;padding:30px">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/200px-Microsoft_logo.svg.png" height="30" alt="Microsoft" style="margin-bottom:20px">
    <h2 style="color:#1a1a1a">Your account has been suspended</h2>
    <p>Hello {{first_name}},</p>
    <p>We've detected <strong>unusual sign-in activity</strong> on your Microsoft account. To protect your account, we've temporarily suspended access.</p>
    <p>To restore access, you need to verify your identity:</p>
    <div style="margin:25px 0">
      <a href="#PHISHING_LINK#" style="background:#0078d4;color:white;padding:12px 24px;text-decoration:none;border-radius:2px;display:inline-block">Verify my account</a>
    </div>
    <p style="color:#888;font-size:12px">If you don't verify within 24 hours, your account will be permanently suspended.</p>
    <hr style="border:none;border-top:1px solid #eee">
    <p style="color:#888;font-size:11px">Microsoft account team &bull; microsoft.com</p>
  </div>
</div>
HTML;
    }

    private function ceoFraud(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto">
  <p>Hi {{first_name}},</p>
  <p>I need your help with something urgent. I'm in a board meeting right now and can't talk. We need to process a wire transfer of <strong>$24,500</strong> to a new vendor today — it's time-sensitive and must go out before market close.</p>
  <p>Can you handle this? I'll explain everything after the meeting. Please click below to access the payment portal:</p>
  <p><a href="#PHISHING_LINK#">Access Secure Payment Portal</a></p>
  <p>Please keep this confidential for now — I'll explain the details soon.</p>
  <p>Thanks,<br>CEO</p>
  <p style="color:#888;font-size:11px;margin-top:30px">Sent from my iPhone</p>
</div>
HTML;
    }

    private function sharedDocument(): string
    {
        return <<<HTML
<div style="font-family:'Segoe UI',Arial,sans-serif;max-width:600px;margin:0 auto;background:#f5f5f5;padding:20px">
  <div style="background:white;border-radius:4px;padding:25px">
    <div style="margin-bottom:15px"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Microsoft_Office_SharePoint_%282019%E2%80%93present%29.svg/200px-Microsoft_Office_SharePoint_%282019%E2%80%93present%29.svg.png" height="28" alt="SharePoint"></div>
    <p><strong>{{first_name}} {{last_name}}</strong> shared a document with you</p>
    <div style="background:#f9f9f9;border:1px solid #ddd;border-radius:4px;padding:15px;margin:20px 0">
      <p style="margin:0;font-weight:bold">Q4 Budget Review - CONFIDENTIAL.xlsx</p>
      <p style="color:#888;font-size:12px;margin:4px 0">Shared by your manager &bull; View access</p>
    </div>
    <div style="text-align:center;margin:20px 0">
      <a href="#PHISHING_LINK#" style="background:#0078d4;color:white;padding:10px 24px;text-decoration:none;border-radius:4px">Open in SharePoint</a>
    </div>
    <p style="color:#888;font-size:11px">You received this email because {{email}} was granted access.</p>
  </div>
</div>
HTML;
    }

    private function salarySlip(): string
    {
        return <<<HTML
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;background:#f9f9f9;padding:20px">
  <div style="background:#27ae60;padding:15px 20px">
    <h1 style="color:white;margin:0;font-size:18px">Payroll Department</h1>
  </div>
  <div style="background:white;padding:25px;border:1px solid #ddd">
    <p>Dear {{first_name}},</p>
    <p>Your <strong>salary slip for this month</strong> is now available for download. Please review your payslip and contact HR if you have any questions.</p>
    <div style="background:#f5f5f5;border-left:4px solid #27ae60;padding:15px;margin:20px 0">
      <p style="margin:0;font-weight:bold">Monthly Payslip</p>
      <p style="color:#888;font-size:12px;margin:4px 0">Available for secure download</p>
    </div>
    <div style="text-align:center;margin:20px 0">
      <a href="#PHISHING_LINK#" style="background:#27ae60;color:white;padding:12px 28px;text-decoration:none;border-radius:4px">Download Payslip</a>
    </div>
    <p style="color:#888;font-size:11px">Payroll Department &bull; This is an automated notification</p>
  </div>
</div>
HTML;
    }
}
