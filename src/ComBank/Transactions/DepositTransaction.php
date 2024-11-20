<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    use AmountValidationTrait;
    public function __construct(float $amount)
    {
        $this->validateAmount($amount);
        $this->amount = $amount;
        
    }
    
    public function applyTransaction(BackAccountInterface $account)
    {
        // Obtener el saldo actual
        $currentBalance = $account->getBalance();

        // Sumar el monto del depósito al saldo actual
        $newBalance = $currentBalance + $this->amount;

        // Establecer el nuevo saldo en la cuenta
        $account->setBalance($newBalance);

        // Devolver el nuevo saldo
        return $newBalance;
    }

    /**
     * Devuelve la información de la transacción de depósito.
     *
     * @return string
     */
    public function getTransactionInfo()
    {
        return 'DEPOSIT_TRANSACTION';
    }

    /**
     * Devuelve el monto del depósito.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

   
}
