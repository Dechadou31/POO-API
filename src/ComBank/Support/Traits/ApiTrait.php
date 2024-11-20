<?php 

namespace ComBank\Support\Traits;

trait ApiTrait{
    public function convertBalance(float $amount): float{
        $ch = curl_init();
        $api = 'https://api.fxfeed.io/v1/latest?base=EUR&api_key=fxf_o7APoVnudiOHDTUpPfOH';

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true,);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, associative: true);
        if (isset($data['rates']['USD'])) {
            $convertedAmount = $amount * $data['rates']['USD'];
            return $convertedAmount;
        }else{
            return 0;
        }
    }

    public function validateEmail($email):bool{
        $ch = curl_init();
        $api = "https://api.usercheck.com/email/{$email}?key=bjDgVIRLIfvAMaJH4c1PNJFOrknrdZ38";

        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true,);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($result, associative: true);
        if (isset($data['mx'])&& isset($data['disposable'])) {
            if ($data['mx'] && !$data['disposable']) {
                return true; 
            }else{
                return false;
            }
            
        }else{
            return false;
        }
        
    }

}