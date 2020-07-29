<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    const COMMISSION = 0.015;

    /**
     * Return all transactions
     *
     * @return Transaction[]|Collection
     */
    public function all()
    {
        return Transaction::all();
    }


    /**
     * @param TransferRequest $request
     * @return array|bool[]
     * @throws \Throwable
     */
    public function transfer(TransferRequest $request)
    {
        $amount = $request->post('amount');
        $sender = $request->post('sender_wallet_id');
        $destination = $request->post('destination_wallet_id');

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
            DB::beginTransaction();
            $this->makeTransfer($sender, $destination, $amount);

            $transaction->status = Transaction::STATUS_COMMITTED;
            $transaction->save();
            DB::commit();

            return ['success' => true];
        } catch (\Exception $exception) {
            DB::rollBack();
            $transaction->status = Transaction::STATUS_CANCELED;
            $transaction->save();

            return ['error' => $exception->getMessage()];
        }
    }

    /**
     * @param int $sender
     * @param int $destination
     * @param float $amount
     * @throws \Throwable
     */
    private function makeTransfer(int $sender, int $destination, float $amount)
    {
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
