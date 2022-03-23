<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckCNP implements Rule
{

    public $data_nastere;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $matches = false;
        $controlDigits = [2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9];
        $sum = false;
        $rest = false;


        // verific formatul S AA LL ZZ  JJ NNN C
        if (preg_match('/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{2})(\d{3})(\d{1})$/i', $value, $matches))
        {
            list ($CNP, $S, $AA, $LL, $ZZ, $JJ, $NNN, $C) = $matches;

            // verific $S diferit de 0 si setez secolul
            switch ((int) $S) {
                case 0:
                    return false;  
                    break;
                case 3: case 4: 
                    (int) $AA += 1800; 
                    break;    
                case 5: case 6: 
                    (int) $AA += 2000;  
                    break;
                default: (int) $AA += 1900;
            }

            // verific daca avem o data invalida sau e mai mare decat NOW => return FALSE
            if(!checkdate($LL, $ZZ, $AA) || (date('Y-m-d') < "$AA-$LL-$ZZ")) return false;

            $this->data_nastere = "$AA-$LL-$ZZ";
            
            // verific daca $JJ este incorect => return FALSE
            if(((int) $JJ > 46 && (int) $JJ < 51) || (int) $JJ > 52) return false;
        
            // inmultesc cifrele de control cu corspondentele lor din CNP si le adun in $controlSum
            foreach ($controlDigits as $key => $val) {
                $sum += $val * (int) $CNP[$key];
            }

            // setez valoarea lui $rest
            $rest = (($sum % 11) == 10) ? 1 : ($sum % 11);

            // verific daca $C este diferit cu $rest => return FALSE
            if($rest !== (int) $C) return false;
            
            // CNP este valid => return TRUE
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CNP invalid!';
    }

    public function getDataNastere()
    {
        return $this->data_nastere;
    }
}