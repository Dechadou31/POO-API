<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\Bank\Person\Persona;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Bank\NationalBankAccount;
use ComBank\Bank\InternationalBankAccount;

require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account
    $bankAccount1 = new BankAccount('400');
    // close account
    $bankAccount1->closeAccount();
    
    // reopen account
    $bankAccount1->reopenAccount();
    
    
    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());
    
    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());
$bankAccount1->closeAccount();
pl('My account is now closed');



//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    
    $bankAccount2 = new BankAccount('200');
    // show balance account
   $bankAccount2->applyOverdraft(new SilverOverdraft);
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
   
} catch (BankAccountException $e) {
    pl($e->getMessage());
    
}
$bankAccount2->closeAccount();
pl('My account is now closed');

pl('--------- [Start testing national account (No conversion)] --------');
    $nationalAccount = new NationalBankAccount(500.0 );
    echo("My balance:" .  $nationalAccount->getBalance() . " ". $nationalAccount->getCurrency() );

pl('--------- [Start testing international account (Dollar conversion)] --------');
    $internatonalAccount = new InternationalBankAccount(initialBalance: 300.0 );
    echo("Converting balance to Dollars" . $internatonalAccount->getConvertedBalance());

    pl('--------- [Start testing national account] --------');
    $Persona = new Persona("Marc", "12345", "marc@gmail.com");
    $nationalAccount2 = new NationalBankAccount(500.0, $Persona);
    
    pl('--------- [Start testing international account] --------');
    $Persona = new Persona("Pepe", "13456", "pepe@pepe.com");
    $nationalAccount2 = new InternationalBankAccount(500.0, $Persona);
