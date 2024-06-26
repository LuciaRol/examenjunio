<?php

namespace Models;
use DateTime;

class Validacion {

    public static function validar($titulo, $descripcion, $categoria, $fecha) {
        // Inicializamos un array para almacenar mensajes de error
        $errores = [];
    
        // Comprobamos si el título está vacío o contiene solo espacios en blanco
        if (empty($titulo) || trim($titulo) === '') {
            $errores['titulo'] = "Es obligatorio introducir el título.";
        } 
    
        // Comprobamos si la descripción está vacía o contiene solo espacios en blanco
        if (empty($descripcion) || trim($descripcion) === '') {
            $errores['descripcion'] = "Es obligatorio introducir la descripción.";
        } 
    
        // Comprobamos si la categoría está vacía o contiene solo espacios en blanco
        if (empty($categoria) || trim($categoria) === '') {
            $errores['categoria'] = "Es obligatorio introducir la categoría.";
        } 
    
        // Comprobamos si la fecha no es válida o está vacía
        if (empty($fecha) || !strtotime($fecha)) {
            $errores['fecha'] = "La fecha no es válida.";
        }
    
        // Si hay errores, devolvemos un array con los mensajes de error
        return $errores;
    }

    public static function sanearCampos($titulo, $descripcion, $categoria, $fecha): array {
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $titulo = trim($titulo);
        $descripcion = trim($descripcion);
        $categoria = trim($categoria);
        $fecha = trim($fecha);
    
        // Sanear el titulo: filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        $titulo = self::sanearString($titulo);
    
        // Sanear la descripcion
        $descripcion = self::sanearString($descripcion);
    
        // Sanear la categoria
        $categoria = self::sanearString($categoria);
    
        // Sanear la fecha
        $fecha = self::sanearFecha($fecha);
    
        return ['titulo' => $titulo, 'descripcion' => $descripcion, 'categoria' => $categoria, 'fecha' => $fecha];
    }
    

    public static function validarDatosUsuario($nombre, $apellidos, $rol) {
        $errores = [];

        // Validar campos de usuario usando las funciones de validación ya existentes en la clase Validacion
        
        if (empty($nombre) || trim($nombre) === '') {
            $errores['nombre'] = "El nombre es obligatorio.";
        }

        if (empty($apellidos) || trim($apellidos) === '') {
            $errores['apellidos'] = "Los apellidos son obligatorios.";
        }

        if (empty($rol) || !in_array($rol, ['admin', 'usur'])) {
            $errores['rol'] = "El rol no es válido.";
        }

        return $errores;
    }

    public static function sanearCamposUsuario($nombre, $apellidos, $rol): array {
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $nombre = trim($nombre);
        $apellidos = trim($apellidos);
        $rol = trim($rol);
    
        
        // Sanear el nombre
        $nombre = self::sanearString($nombre);
    
        // Sanear los apellidos
        $apellidos = self::sanearString($apellidos);
    
        
        return ['nombre' => $nombre, 'apellidos' => $apellidos, 'rol' => $rol];
    }
    
    // Función para sanear strings
    public static function sanearString(string $texto): string {
        // Filtrar solo letras (mayúsculas y minúsculas), números, ñ, vocales acentuadas y espacios, eliminando otros caracteres
        return preg_replace('/[^A-Za-z0-9\sáéíóúÁÉÍÓÚñÑÁÉÍÓÚáéíóú.,]+/u', '', $texto);
    }

    public static function sanearUsuario(string $texto): ?string {
        // Filtrar solo letras (mayúsculas y minúsculas) y números, eliminando otros caracteres y espacios
        $texto_saneado = preg_replace('/[^A-Za-z0-9]+/', '', $texto);
    
        // Verificar si el texto saneado es igual al texto original
        if ($texto_saneado === $texto && ctype_alnum($texto_saneado)) {
            return $texto_saneado;
        } else {
            // El texto contiene caracteres no permitidos
            return null;
        }
    }

    public static function sanearTelefono(string $telefono): string {
        // Filtrar solo números, + y -, eliminando otros caracteres
        $telefonoLimpio = preg_replace('/[^0-9+\-]+/', '', $telefono);
    
        // Verificar longitud y ajustar si es necesario
        $longitudMinima = 9;
        $longitudMaximaConMas = 12;
        
        // Verificar si hay un signo + al principio
        $tieneMas = strpos($telefonoLimpio, '+') === 0;
    
        // Ajustar la longitud máxima según la presencia del signo +
        $longitudMaxima = $tieneMas ? $longitudMaximaConMas : $longitudMinima;
    
        // Recortar o ajustar la longitud del teléfono si es mayor a la máxima permitida
        if (strlen($telefonoLimpio) > $longitudMaxima) {
            $telefonoLimpio = substr($telefonoLimpio, 0, $longitudMaxima);
        }
    
        return $telefonoLimpio;
    }
    
    
    public static function sanearNumero($numero): float{
        // Sanear el importe: eliminar todos los caracteres excepto los dígitos y el signo de puntuación para permitir números decimales
        $numero = filter_var($numero, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $numero = floatval($numero);
        return $numero;
    }


    public static function validarContrasena(string $contrasena): bool {
        // Verificar longitud mínima y presencia de al menos una letra mayúscula, un dígito y un carácter especial
        if (strlen($contrasena) >= 7 &&
            preg_match('/[A-Z]/', $contrasena) &&
            preg_match('/\d/', $contrasena) &&
            preg_match('/[#!@*$]/', $contrasena)) {
            return true;
        } else {
            return false;
        }
    }    
    public static function sanearFecha($fecha): ?string {
        // Verificamos si la fecha tiene el formato correcto ('dd/mm/yyyy' o 'dd-mm-yyyy')
        if (preg_match('/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/', $fecha, $matches)) {
            // Intentamos convertir la fecha a un formato UNIX timestamp
            $dia = $matches[1];
            $mes = $matches[2];
            $anio = $matches[3];
            
            // Verificamos si la fecha es válida
            if (checkdate($mes, $dia, $anio)) {
                // Creamos un objeto DateTime utilizando el timestamp
                $timestamp = strtotime("$anio-$mes-$dia");
                $fecha_parseada = new DateTime();
                $fecha_parseada->setTimestamp($timestamp);
        
                // Devolvemos la fecha formateada como 'd-m-Y'
                return $fecha_parseada->format('d-m-Y');
            }
        }
        
        // Si la fecha no tiene el formato correcto o no es válida, devolvemos null
        return null;
    }

      // Nueva función para sanear nombre de la categoría
      public static function saneamientoString($nombreCategoria): string {
        // Aplicar trim para eliminar espacios en blanco al inicio y al final
        $nombreCategoria = trim($nombreCategoria);
        // Sanear el nombre de la categoría
        return self::sanearString($nombreCategoria);
    }

    
}