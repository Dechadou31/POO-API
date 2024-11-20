<?php namespace ComBank\Transactions\Contracts;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:29 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;

interface BankTransactionInterface
{
    public function applyTransaction(BackAccountInterface $account);

    /**
     * Devuelve la información de la transacción.
     *
     * @return string La descripción o información de la transacción.
     */
    public function getTransactionInfo();

    /**
     * Devuelve el monto de la transacción.
     *
     * @return float El monto de la transacción.
     */
    public function getAmount();  
}
