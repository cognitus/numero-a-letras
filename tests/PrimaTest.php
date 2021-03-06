<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Xarenisoft\NumberToWords\Esp\NumeroALetras;
 

final class PrimaTest extends TestCase {

    public function setup(){
        
    }
    public function testIntegerWithourThousandSeparator(){
       $number=12345;
      $output= NumeroALetras::convertir($number);
      $this->assertEquals('DOCE MIL TRESCIENTOS CUARENTA Y CINCO',
      $output);
    }
    public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosYCentimosVacioDemo(){
        $output= NumeroALetras::convertir("121,311,321.21",'PESOS','','',NumeroALetras::FORZAR_CENTIMOS|NumeroALetras::SUFFIX_SIEMPRE);
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS 21/100',
        $output);
     }
    public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosYCentimosVacio(){
       $output= NumeroALetras::convertir("121,311,321.21",'PESOS','');
       $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS 21/100',
       $output);
    }
    public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosYCentimosCentavos(){
       $output= NumeroALetras::convertir("121,311,321.21",'PESOS','CENTAVOS');
       $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS CON VENTIUN CENTAVOS',
       $output);
    } 
    public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosCentimosVacioYSuffix(){
        $output= NumeroALetras::convertir("121,311,321.45",'PESOS','','M.N.');
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS 45/100 M.N.',
        $output);
     }
     public function testCantidadConSeparadorComaDecimalValorCero1PosicionForzandoPuntoMonedaPesosCentimosVacioYSuffix(){
        $output= NumeroALetras::convertir("121,311,321.0",'PESOS','','M.N.',NumeroALetras::FORZAR_CENTIMOS);
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS 00/100 M.N.',
        $output);
     }
     public function testCantidadConSeparadorComaDecimalValorCero2PosicionesForzandoPuntoMonedaPesosCentimosVacioYSuffix(){
        $output= NumeroALetras::convertir("121,311,321.00",'PESOS','','M.N.',NumeroALetras::FORZAR_CENTIMOS);
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS 00/100 M.N.',
        $output);
     }
    
     public function testCantidadConSeparadorComaDecimalValorCeroPuntoMonedaPesosCentimosVacio(){
        $output= NumeroALetras::convertir("121,311,321.00",'PESOS','','M.N.');
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS',
        $output);
     }
     public function testCantidadConSeparadorComaDecimalValorCeroPuntoMonedaPesosCentimosVacioSuffixAlways(){
        $output= NumeroALetras::convertir("121,311,321.00",'PESOS','CENTAVOS','M.N.',NumeroALetras::SUFFIX_SIEMPRE);
        $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS M.N.',
        $output);
     }
     public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosYCentimosConbitwiseEnFlags(){
      $output= NumeroALetras::convertir("121,311,321.21",'PESOS','CENTAVOS','MXN',NumeroALetras::FORZAR_CENTIMOS|NumeroALetras::SUFFIX_SIEMPRE);
      $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS CON VENTIUN CENTAVOS MXN',
      $output);
   }
   public function testCantidadConSeparadorComaDecimalPuntoMonedaPesosYCentimosConbitwiseEnFlagsUseLocal(){
      NumeroALetras::$decimalSeparator=',';#debe ser ignorado por el punto

      $output= NumeroALetras::convertir("121,311,321.21",'PESOS','CENTAVOS','',NumeroALetras::USE_LOCAL);
      $this->assertEquals('CIENTO VENTIUN MILLONES TRESCIENTOS ONCE MIL TRESCIENTOS VENTIUN PESOS CON VENTIUN CENTAVOS',
      $output);
      NumeroALetras::$thousandSeparator='.';

   }
     public function testUsandoConfiguracionDeMoneda(){
         NumeroALetras::$currencySymbol='€';
		   NumeroALetras::$thousandSeparator='.';
		   NumeroALetras::$decimalSeparator=',';
         $output=NumeroALetras::convertir("12.345,67 €",'EUROS','','EUR');
         $this->assertEquals("DOCE MIL TRESCIENTOS CUARENTA Y CINCO EUROS 67/100 EUR",$output); 		 
     }
     /**
      * @expectedException InvalidArgumentException
      *
      * 
      */
     public function testMismoSeparadorException(){
         NumeroALetras::$currencySymbol='MXN';
         NumeroALetras::$decimalSeparator='.';
         NumeroALetras::$thousandSeparator='.';
         $output= NumeroALetras::convertir("-12131321.21 MXN",'PESOS','CENTAVOS');
         
         
     }
     public function testValorNegativoConSimboloMasDeUnCaracter(){
         NumeroALetras::$currencySymbol='MXN';
         NumeroALetras::$decimalSeparator='.';
         NumeroALetras::$thousandSeparator=',';
         $output= NumeroALetras::convertir("-12131321.21 MXN",'PESOS','CENTAVOS');
         $expected="MENOS DOCE MILLONES CIENTO TREINTA Y UN MIL TRESCIENTOS VENTIUN PESOS CON VENTIUN CENTAVOS";         
         $this->assertEquals($expected,$output); 		 
         
     }
     
    
}