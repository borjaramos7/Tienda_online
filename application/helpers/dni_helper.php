<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Funciones para el trabajo con DNI, NIE, CIF
 *
 */

/**
 * Devuelve la letra que le corresponde al NIF a un DNI
 * @param string $dni
 */
function dni_LetraNIF($dni)
{
	return mb_substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($dni, 0, 8) % 23, 1);
}

/**
 * Muestra el dni sin la letra
 * Enter description here ...
 * @param unknown_type $nif
 */
function dni_QuitaLetra($nif)
{
	return mb_substr($nif, 0,8);
}

/**
 * Devuelve true si el número es un DNI o NIF
 * @param string $dni
 * @return boolean
 */
function dni_NIF_NIE_Ok($dni)
{
	$res=dni_valida_nif_cif_nie($dni);
	return ($res==1 || $res==3);
}

/**
 * 	Función para validar códigos NIF, CIF y NIE 
 * 	Esta función clasifica y valida perfectamente todos* los códigos fiscales que se usan en España. 
 *  Analiza una variable de 9 carácteres alfanuméricos y devuelve un valor numérico para cada tipo de código
 *  analizado donde todos los valores positivos (mayores que cero) indican que el código fiscal es correcto.
 *  
 *  Los valores devueltos son:
 *  
 *  Tipo:		???	NIF	CIF	NIE
 *  Correcto:		 1 	2  	3
 *  Incorrecto:	0  	-1 	-2 	-3
 *  
 * 	La función cumple con todas las especificaciones de las leyes españolas:
 * 	Decreto 2423/1975, de 25 de septiembre.
 * 	Real Decreto 338/1990, de 9 de marzo.
 * 	Real Decreto 1624/1992, de 29 de diciembre que modifica el 338/1990.
 * 	Real Decreto 155/1996, de 2 de febrero.
 * 	Orden de 3 de julio de 1998, por la que se modifica el Anexo del Decreto 2423/1975.
 * 	Real Decreto 1065/2007, de 27 de julio.
 * 	Orden EHA/451/2008, de 20 de febrero de 2008.
 * 	Orden INT/2058/2008, de 14 de julio de 2008.
 * 
 * 	Que es, actualmente, todo lo aprobado respecto con los Códigos de Identificación Fiscal, 
 *  Número de Identificación Fiscal y Número de Identificación de Extranjeros.
 * 
 * 
 * @param string $cif
 */
function dni_valida_nif_cif_nie($cif) {
//Copyright ©2005-2011 David Vidal Serra. Bajo licencia GNU GPL.
//Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
//puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
//Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
//con la condicion de que el autor jamas sera responsable de su uso.
//Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
         $cif = strtoupper($cif);
         for ($i = 0; $i < 9; $i ++)
         {
                  $num[$i] = mb_substr($cif, $i, 1);
         }
//si no tiene un formato valido devuelve error
         if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
                  return 0;
         }
//comprobacion de NIFs estandar
         if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
                  if ($num[8] == mb_substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
                  {
                           return 1;
                  }
                  else
                  {
                           return -1;
                  }
         }
//algoritmo para comprobacion de codigos tipo CIF
         $suma = $num[2] + $num[4] + $num[6];
         for ($i = 1; $i < 8; $i += 2)
         {
                  $suma += mb_substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]), 1, 1);
         }
         $n = 10 - mb_substr($suma, strlen($suma) - 1, 1);
//comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
         if (preg_match('/^[KLM]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == mb_substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
                  {
                           return 1;
                  }
                  else
                  {
                           return -1;
                  }
         }
//comprobacion de CIFs
         if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == mb_substr($n, mb_strlen($n) - 1, 1))
                  {
                           return 2;
                  }
                  else
                  {
                           return -2;
                  }
         }
//comprobacion de NIEs
//T
         if (preg_match('/^[T]{1}/', $cif))
         {
                  if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $cif))
                  {
                           return 3;
                  }
                  else
                  {
                           return -3;
                  }
         }
//XYZ
         if (preg_match('/^[XYZ]{1}/', $cif))
         {
                  if ($num[8] == mb_substr('TRWAGMYFPDXBNJZSQVHLCKE', mb_substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
                  {
                           return 3;
                  }
                  else
                  {
                           return -3;
                  }
         }
//si todavia no se ha verificado devuelve error
         return 0;
}



