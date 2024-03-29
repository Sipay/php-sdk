<?php
namespace Sipay\Paymethods;

class Card implements Paymethod
{
    private $card_number;
    private $year;
    private $month;
    private $cvv;

    public function __construct(string $card_number, int $year, int $month, int $cvv = null)
    {
        $this->set_card_number($card_number);
        $this->set_expiration_date($year, $month);

        if(!is_null($cvv)) {
            $this->set_cvv($cvv);
        }        
    }

    public function set_cvv(string $cvv)
    {
        return $this->cvv = $cvv;
    }

    public function get_cvv()
    {
	return $this->cvv;
    }

    public function get_card_number()
    {
        return $this->card_number;
    }

    public function set_card_number(string $card_number)
    {
        if(!preg_match("/^[0-9]{14,19}$/", $card_number)) {
            throw new \Exception('$card_number don\'t match with pattern.');
        }

        $this->card_number = $card_number;
    }

    public function get_year()
    {
        return $this->year;
    }

    public function get_month()
    {
        return $this->month;
    }

    public function set_expiration_date(int $year, int $month)
    {
        if($year < 1000 or $year >9999) {
            throw new \Exception('$year doesn\'t have a correct value.');
        }

        $this->year = $year;

        if($month < 1 or $month > 12) {
            throw new \Exception('$month doesn\'t have a correct value.');
        }

        $this->month = $month;

        if($this->is_expirate()) {
            throw new \Exception('Card is expired.');
        }

    }

    private function is_expirate()
    {
        $year = intval(date('Y'));
        $month = intval(date('m'));
        return $this->year < $year or ($this->year == $year and $this->month < $month);
    }

    public function to_json()
    {
        if(is_null($this->cvv)){
            return array(
                'pan' => $this->card_number,
                'year' => $this->year,
                'month' => $this->month,
              );
            } else {
            return array(
              'pan' => $this->card_number,
              'year' => $this->year,
              'month' => $this->month,
              'cvv' => $this->cvv
            );
        }
    }
}
