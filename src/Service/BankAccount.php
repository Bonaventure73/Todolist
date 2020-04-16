<?php
namespace App\Service;
class BankAccount
    {
        protected $balance = 0;
        
        
        public function getBalance()
        {
            return $this->balance;
        }
        
        
        protected function setBalance($balance)
        {
            if ($balance >= 0) {
                $this->balance = $balance;
        } else {
            throw new \RuntimeException();
        }
    }
    
    
    public function depositMoney($amount)
    {
        $this->setBalance($this->getBalance() + $amount);
        return $this->getBalance();
    }
    
    
    public function withdrawMoney($amount)
    {
        $this->setBalance($this->getBalance() - $amount);
        return $this->getBalance();
    }
}