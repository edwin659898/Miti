<?php

namespace App\Console\Commands;

use App\Models\CartOrder;
use Illuminate\Console\Command;
use App\Models\Mtn;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Delights\Mtn\Products\Collection;

class MomoStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MomoStatus';

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
        $collection = new Collection();

        $records = Mtn::whereDay('created_at', '=', Carbon::now()->format('d'))->where('status', 'unverified')->get();
        foreach ($records as $record) {
            $token = $record->access_token;
            $transtatus = $collection->getTransactionStatus($token);
            if ($transtatus['status'] == 'FAILED') {
                  $record->update(['status' => 'failed']);
            } elseif ($transtatus['status'] == 'PENDING') {
                  $record->update(['status' => 'pending']);
            } elseif ($transtatus['status'] == 'SUCCESSFUL') {
                $msisdn_id = isset($transtatus['payer']) ? $transtatus['payer']['partyId'] : null;
                $payment = $record->update(['msisdn_id' => $msisdn_id, 'txncd' => $transtatus['externalId'], 'status' => 'verified']);

                $currency = $record->currency;
                $amount = $record->amount;
                $orderId = $record->reference;
                $user_id = $record->user_id;
                $customer = User::findorFail($record->user_id);

                Order::where('reference', $orderId)->update(['status' => 'verified']);

                Subscription::where('reference', $orderId)->update(['status' => 'paid']);

                CartOrder::where('reference', $orderId)->update(['status' => 'verified']);
            }
        }
    }
}
