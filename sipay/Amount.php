<?php

namespace Sipay;

class Amount{
    private $CURRENCIES = array(
        'AED' => array('AED', '2', 'Dírham de los Emiratos Árabes Unidos'),
        'AFN' => array('AFN', '2', 'Afgani'),
        'ALL' => array('ALL', '2', 'Lek'),
        'AMD' => array('AMD', '2', 'Dram armenio'),
        'ANG' => array('ANG', '2', 'Florín antillano neerlandés'),
        'AOA' => array('AOA', '2', 'Kwanza'),
        'ARS' => array('ARS', '2', 'Peso argentino'),
        'AUD' => array('AUD', '2', 'Dólar australiano'),
        'AWG' => array('AWG', '2', 'Florín arubeño'),
        'AZN' => array('AZN', '2', 'Manat azerbaiyano'),
        'BAM' => array('BAM', '2', 'Marco convertible'),
        'BBD' => array('BBD', '2', 'Dólar de Barbados'),
        'BDT' => array('BDT', '2', 'Taka'),
        'BGN' => array('BGN', '2', 'Lev búlgaro'),
        'BHD' => array('BHD', '3', 'Dinar bareiní'),
        'BIF' => array('BIF', '0', 'Franco de Burundi'),
        'BMD' => array('BMD', '2', 'Dólar bermudeño'),
        'BND' => array('BND', '2', 'Dólar de Brunéi'),
        'BOB' => array('BOB', '2', 'Boliviano'),
        'BOV' => array('BOV', '2', 'MVDOL'),
        'BRL' => array('BRL', '2', 'Real brasileño'),
        'BSD' => array('BSD', '2', 'Dólar bahameño'),
        'BTN' => array('BTN', '2', 'Ngultrum'),
        'BWP' => array('BWP', '2', 'Pula'),
        'BYR' => array('BYR', '0', 'Rublo bielorruso'),
        'BZD' => array('BZD', '2', 'Dólar beliceño'),
        'CAD' => array('CAD', '2', 'Dólar canadiense'),
        'CDF' => array('CDF', '2', 'Franco congoleño'),
        'CHE' => array('CHE', '2', 'Euro WIR'),
        'CHF' => array('CHF', '2', 'Franco suizo'),
        'CHW' => array('CHW', '2', 'Franco WIR'),
        'CLF' => array('CLF', '4', 'Unidad de fomento'),
        'CLP' => array('CLP', '0', 'Peso chileno'),
        'CNY' => array('CNY', '2', 'Yuan chino'),
        'COP' => array('COP', '2', 'Peso colombiano'),
        'COU' => array('COU', '2', 'Unidad de valor real'),
        'CRC' => array('CRC', '2', 'Colón costarricense'),
        'CUC' => array('CUC', '2', 'Peso convertible'),
        'CUP' => array('CUP', '2', 'Peso cubano'),
        'CVE' => array('CVE', '2', 'Escudo caboverdiano'),
        'CZK' => array('CZK', '2', 'Corona checa'),
        'DJF' => array('DJF', '0', 'Franco yibutiano'),
        'DKK' => array('DKK', '2', 'Corona danesa'),
        'DOP' => array('DOP', '2', 'Peso dominicano'),
        'DZD' => array('DZD', '2', 'Dinar argelino'),
        'EGP' => array('EGP', '2', 'Libra egipcia'),
        'ERN' => array('ERN', '2', 'Nakfa'),
        'ETB' => array('ETB', '2', 'Birr etíope'),
        'EUR' => array('EUR', '2', 'Euro'),
        'FJD' => array('FJD', '2', 'Dólar fiyiano'),
        'FKP' => array('FKP', '2', 'Libra malvinense'),
        'GBP' => array('GBP', '2', 'Libra esterlina'),
        'GEL' => array('GEL', '2', 'Lari'),
        'GHS' => array('GHS', '2', 'Cedi ghanés'),
        'GIP' => array('GIP', '2', 'Libra de Gibraltar'),
        'GMD' => array('GMD', '2', 'Dalasi'),
        'GNF' => array('GNF', '0', 'Franco guineano'),
        'GTQ' => array('GTQ', '2', 'Quetzal'),
        'GYD' => array('GYD', '2', 'Dólar guyanés'),
        'HKD' => array('HKD', '2', 'Dólar de Hong Kong'),
        'HNL' => array('HNL', '2', 'Lempira'),
        'HRK' => array('HRK', '2', 'Kuna'),
        'HTG' => array('HTG', '2', 'Gourde'),
        'HUF' => array('HUF', '2', 'Forinto'),
        'IDR' => array('IDR', '2', 'Rupia indonesia'),
        'ILS' => array('ILS', '2', 'Nuevo shéquel israelí'),
        'INR' => array('INR', '2', 'Rupia india'),
        'IQD' => array('IQD', '3', 'Dinar iraquí'),
        'IRR' => array('IRR', '2', 'Rial iraní'),
        'ISK' => array('ISK', '0', 'Corona islandesa'),
        'JMD' => array('JMD', '2', 'Dólar jamaiquino'),
        'JOD' => array('JOD', '3', 'Dinar jordano'),
        'JPY' => array('JPY', '0', 'Yen'),
        'KES' => array('KES', '2', 'Chelín keniano'),
        'KGS' => array('KGS', '2', 'Som'),
        'KHR' => array('KHR', '2', 'Riel'),
        'KMF' => array('KMF', '0', 'Franco comorense'),
        'KPW' => array('KPW', '2', 'Won norcoreano'),
        'KRW' => array('KRW', '0', 'Won'),
        'KWD' => array('KWD', '3', 'Dinar kuwaití'),
        'KYD' => array('KYD', '2', 'Dólar de las Islas Caimán'),
        'KZT' => array('KZT', '2', 'Tenge'),
        'LAK' => array('LAK', '2', 'Kip'),
        'LBP' => array('LBP', '2', 'Libra libanesa'),
        'LKR' => array('LKR', '2', 'Rupia de Sri Lanka'),
        'LRD' => array('LRD', '2', 'Dólar liberiano'),
        'LSL' => array('LSL', '2', 'Loti'),
        'LYD' => array('LYD', '3', 'Dinar libio'),
        'MAD' => array('MAD', '2', 'Dírham marroquí'),
        'MDL' => array('MDL', '2', 'Leu moldavo'),
        'MGA' => array('MGA', '2', 'Ariary malgache'),
        'MKD' => array('MKD', '2', 'Denar'),
        'MMK' => array('MMK', '2', 'Kyat'),
        'MNT' => array('MNT', '2', 'Tugrik'),
        'MOP' => array('MOP', '2', 'Pataca'),
        'MRO' => array('MRO', '2', 'Uquiya'),
        'MUR' => array('MUR', '2', 'Rupia de Mauricio'),
        'MVR' => array('MVR', '2', 'Rufiyaa'),
        'MWK' => array('MWK', '2', 'Kwacha'),
        'MXN' => array('MXN', '2', 'Peso mexicano'),
        'MXV' => array('MXV', '2', 'Unidad de Inversión (UDI) mexicana'),
        'MYR' => array('MYR', '2', 'Ringgit malayo'),
        'MZN' => array('MZN', '2', 'Metical mozambiqueño'),
        'NAD' => array('NAD', '2', 'Dólar namibio'),
        'NGN' => array('NGN', '2', 'Naira'),
        'NIO' => array('NIO', '2', 'Córdoba'),
        'NOK' => array('NOK', '2', 'Corona noruega'),
        'NPR' => array('NPR', '2', 'Rupia nepalí'),
        'NZD' => array('NZD', '2', 'Dólar neozelandés'),
        'OMR' => array('OMR', '3', 'Rial omaní'),
        'PAB' => array('PAB', '2', 'Balboa'),
        'PEN' => array('PEN', '2', 'Sol'),
        'PGK' => array('PGK', '2', 'Kina'),
        'PHP' => array('PHP', '2', 'Peso filipino'),
        'PKR' => array('PKR', '2', 'Rupia pakistaní'),
        'PLN' => array('PLN', '2', 'Złoty'),
        'PYG' => array('PYG', '0', 'Guaraní'),
        'QAR' => array('QAR', '2', 'Riyal qatarí'),
        'RON' => array('RON', '2', 'Leu rumano'),
        'RSD' => array('RSD', '2', 'Dinar serbio'),
        'RUB' => array('RUB', '2', 'Rublo ruso'),
        'RWF' => array('RWF', '0', 'Franco ruandés'),
        'SAR' => array('SAR', '2', 'Riyal saudí'),
        'SBD' => array('SBD', '2', 'Dólar de las Islas Salomón'),
        'SCR' => array('SCR', '2', 'Rupia seychelense'),
        'SDG' => array('SDG', '2', 'Dinar sudanés'),
        'SEK' => array('SEK', '2', 'Corona sueca'),
        'SGD' => array('SGD', '2', 'Dólar de Singapur'),
        'SHP' => array('SHP', '2', 'Libra de Santa Elena'),
        'SLL' => array('SLL', '2', 'Leone'),
        'SOS' => array('SOS', '2', 'Chelín somalí'),
        'SRD' => array('SRD', '2', 'Dólar surinamés'),
        'SSP' => array('SSP', '2', 'Libra sursudanesa'),
        'STD' => array('STD', '2', 'Dobra'),
        'SVC' => array('SVC', '2', 'Colon Salvadoreño'),
        'SYP' => array('SYP', '2', 'Libra siria'),
        'SZL' => array('SZL', '2', 'Lilangeni'),
        'THB' => array('THB', '2', 'Baht'),
        'TJS' => array('TJS', '2', 'Somoni tayiko'),
        'TMT' => array('TMT', '2', 'Manat turcomano'),
        'TND' => array('TND', '3', 'Dinar tunecino'),
        'TOP' => array('TOP', '2', 'Paʻanga'),
        'TRY' => array('TRY', '2', 'Lira turca'),
        'TTD' => array('TTD', '2', 'Dólar de Trinidad y Tobago'),
        'TWD' => array('TWD', '2', 'Nuevo dólar taiwanés'),
        'TZS' => array('TZS', '2', 'Chelín tanzano'),
        'UAH' => array('UAH', '2', 'Grivna'),
        'UGX' => array('UGX', '0', 'Chelín ugandés'),
        'USD' => array('USD', '2', 'Dólar estadounidense'),
        'USN' => array('USN', '2', 'Dólar estadounidense (Siguiente día)'),
        'UYI' => array('UYI', '0', 'Peso en Unidades Indexadas (Uruguay)'),
        'UYU' => array('UYU', '2', 'Peso uruguayo'),
        'UZS' => array('UZS', '2', 'Som uzbeko'),
        'VEF' => array('VEF', '2', 'Bolívar'),
        'VND' => array('VND', '0', 'Dong vietnamita'),
        'VUV' => array('VUV', '0', 'Vatu'),
        'WST' => array('WST', '2', 'Tala'),
        'XAF' => array('XAF', '0', 'Franco CFA de África Central'),
        'XAG' => array('XAG', '-1', 'Plata (una onza troy)'),
        'XAU' => array('XAU', '-1', 'Oro (una onza troy)'),
        'XBA' => array('XBA', '-1', 'Unidad compuesta europea (EURCO) (Unidad del mercados de bonos)'),
        'XBB' => array('XBB', '-1', 'Unidad Monetaria europea (E.M.U.-6) (Unidad del mercado de bonos)'),
        'XBC' => array('XBC', '-1', 'Unidad europea de cuenta 9 (E.U.A.-9) (Unidad del mercado de bonos)'),
        'XBD' => array('XBD', '-1', 'Unidad europea de cuenta 17 (E.U.A.-17) (Unidad del mercado de bonos)'),
        'XCD' => array('XCD', '2', 'Dólar del Caribe Oriental'),
        'XDR' => array('XDR', '-1', 'Derechos especiales de giro'),
        'XOF' => array('XOF', '0', 'Franco CFA de África Occidental'),
        'XPD' => array('XPD', '-1', 'Paladio (una onza troy)'),
        'XPF' => array('XPF', '0', 'Franco CFP'),
        'XPT' => array('XPT', '-1', 'Platino (una onza troy)'),
        'XSU' => array('XSU', '-1', 'SUCRE'),
        'XTS' => array('XTS', '-1', 'Reservado para pruebas'),
        'XUA' => array('XUA', '-1', 'Unidad de cuenta BAD'),
        'XXX' => array('XXX', '-1', 'Sin divisa'),
        'YER' => array('YER', '2', 'Rial yemení'),
        'ZAR' => array('ZAR', '2', 'Rand'),
        'ZMW' => array('ZMW', '2', 'Kwacha zambiano'),
        'ZWL' => array('ZWL', '2', 'Dólar zimbabuense')
    );
    private $currency;
    private $amount;

    public function __construct($amount, $currency){
        $this->set($amount, $currency);
    }

    public function get_currency(){
        return $this->currency[0];
    }

    public function get_amount(){
        return $this->amount;
    }

    public function get_array(){
        return array(
            'amount' => $this->amount,
            'currency' => $this->currency[0]
          );
    }

    public function set($amount, $currency){
        if (gettype($currency) != "string"){
            throw new \Exception('$currency must be a string.');
        }

        if(!isset($this->CURRENCIES[$currency])){
            throw new \Exception('$currency don\'t exists.');
        }

        if($this->CURRENCIES[$currency] < 0){
            throw new \Exception('Invalid currency.');
        }

        $this->currency = $this->CURRENCIES[$currency];

        if (gettype($amount) == "string" &&
            preg_match("/^[0-9]+\.[0-9]{".$this->currency[1]."}$/", $amount)){
                $amount = intval(str_replace(".", "", $amount));
        }

        if (gettype($amount) == "string" &&
            preg_match("/^[0-9]+$/", $amount)){
                $amount = intval($amount);
        }

        if (gettype($amount) != "integer"){
            throw new \Exception('$amount must be a integer.');
        }

        if($amount < 0){
            throw new \Exception('Value of $amount is incorrect.');
        }

        $this->amount = $amount;
    }

    public function __toString(){
        $str = str_pad("".$this->amount, $this->currency[1]+1,"0",STR_PAD_LEFT);
        $str = substr_replace($str, '.', strlen($str)-$this->currency[1], 0);
        return $str.$this->currency[0];
    }

}
