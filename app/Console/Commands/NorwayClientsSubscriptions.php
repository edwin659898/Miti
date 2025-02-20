<?php

namespace App\Console\Commands;

use App\Models\Magazine;
use App\Models\MagazineUser;
use App\Models\SelectedIssue;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NorwayClientsSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issue-awarded';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Award issue to Norway clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('user_type', true)->get();
        $magazines = Magazine::whereYear('created_at', date('Y'))->select('id', 'issue_no')->get();

        foreach ($users as $user) {
            foreach ($magazines as $magazine) {
                $can_access = MagazineUser::where('user_id', $user->id)->where('magazine_id', $magazine->id)->first();
                if ($can_access == null) {

                    $subscription = Subscription::where('user_id', $user->id)->where('status', 'paid')->first();
                    if ($subscription == null) {
                        $subscription_plan = SubscriptionPlan::where('quantity', 1)->first();
                        $subscription = Subscription::create([
                            'user_id' => $user->id,
                            'subscription_plan_id' => $subscription_plan->id,
                            'status' => 'paid',
                            'reference' => Carbon::now()->timestamp,
                            'type' => 'digital',
                            'quantity' => 1,
                        ]);
                    }
                    SelectedIssue::create([
                        'user_id' => $user->id,
                        'issue_no' => $magazine->issue_no,
                        'subscription_id' => $subscription->id
                    ]);

                    MagazineUser::create(['user_id' => $user->id, 'magazine_id' => $magazine->id]);
                }
            }
        }
    }
}
