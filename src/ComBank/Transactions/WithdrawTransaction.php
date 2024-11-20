<?php namespace ComBank\Transactions;

/**
 * Creado por VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;  
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface 
{
    use AmountValidationTrait;

    public function __construct(float $amount)
    {
        $this->validateAmount($amount);
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $account): float
    {
        $withdraw = $account->getBalance() - $this->amount;
        $overdraft = $account->getOverdraft()->isGrantOverdraftFunds($withdraw);

        if ($withdraw < 0) {
            if ($overdraft) {
                return $withdraw;

            }else{
                throw new InvalidOverdraftFundsException("");
            }
        } else {
            return $withdraw;
        }
    }


    /**
     * Devuelve la información de la transacción de retiro.
     *
     * @return string Información sobre el retiro.
     */
    public function getTransactionInfo(): string
    {
        return 'WITHDRAW_TRANSACTION';
    }

    /**
     * Devuelve el monto del retiro.
     *
     * @return float El monto del retiro.
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
