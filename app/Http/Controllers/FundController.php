<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundController extends Controller
{

    const COMMISSION = 0.015;

    /**
     * @param Request $request
     * @return array|bool[]
     * @throws \Throwable
     */
    public function fund(Request $request)
    {
        $amount = $request->post('amount');
        $sender = $request->post('sender_wallet_id');
        $destination = $request->post('destination_wallet_to');

        $transaction = new Transaction(
            [
                'sender_wallet_id' => $sender,
                'destination_wallet_id' => $destination,
                'amount' => $amount,
                'status' => Transaction::STATUS_PENDING,
            ]
        );
        $transaction->save();

        try {
            $this->transfer($sender, $destination, $amount);

            $transaction->status = Transaction::STATUS_COMMITTED;
            $transaction->save();

            return ['success' => true];
        } catch (\Exception $exception) {
            $transaction->status = Transaction::STATUS_CANCELED;
            DB::rollBack();
            return ['error' => $exception->getMessage()];
        }
    }

    /**
     * @param int $sender
     * @param int $destination
     * @param float $amount
     * @throws \Throwable
     */
    private function transfer(int $sender, int $destination, float $amount)
    {
        DB::beginTransaction();
        $senderWallet = Wallet::findOrFail($sender);
        // Maybe need to be saved somewhere
        $commission = $this->calculateCommission($amount);
        $amountToWithdraw = $amount + $commission;

        if ($senderWallet->balance < $amountToWithdraw) {
            throw new \Exception('Do not have enough money.');
        }

        $senderWallet->balance -= $amountToWithdraw;
        $senderWallet->save();

        $destinationWallet = Wallet::findOrFail($destination);
        $destinationWallet->balance += $amount;
        $destinationWallet->save();
        DB::commit();
    }

    /**
     * @param float $amount
     * @return float
     */
    private function calculateCommission(float $amount): float
    {
        return $amount * self::COMMISSION;
    }
}
