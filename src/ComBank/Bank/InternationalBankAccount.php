<?php namespace ComBank\Bank;


class InternationalBankAccount extends BankAccount{
   
    public function getConvertedBalance(): float{
        return $this->convertBalance($this->getBalance());
    }
    public function getConvertedCurrency() {

        return "USD"; 
    }
}