<?php

set_error_handler(array('My_ToStringFixer', 'errorHandler'));
error_reporting(E_ALL | E_STRICT);

class My_ToStringFixer
{
    protected static $_toStringException;

    public static function errorHandler($errorNumber, $errorMessage, $errorFile, $errorLine)
    {
        if (isset(self::$_toStringException))
        {
            $exception = self::$_toStringException;
            // Always unset '_toStringException', we don't want a straggler to be 
            // found later if something came between the setting and the error
            self::$_toStringException = null;
            // echo "-----------".$errorMessage."----------------";
            // solamente apara el metodo __toString y deve ser un problema con el string value.
            if (preg_match('~^Method .*::__toString\(\) must return a string value$~', $errorMessage))
                throw $exception;
        }
        echo "error:".$errorMessage."::".$errorFile." line:".$errorLine."\n<br>";
        return false;
    }
   
    public static function throwToStringException($exception)
    {
        // Should not occur with prescribed usage, but in case of recursion: clean out exception, 
        // return a valid string, and weep
        if (isset(self::$_toStringException))
        {
            self::$_toStringException = null;
            return '';
        }

        self::$_toStringException = $exception;

        return null;
    }
}

/*
// ejemplo:

class My_Class
{
    public function doComplexStuff()
    {
		// genera un error aproposito.
        throw new Exception('UN ERROR!');
    }

    public function __toString()
    {
        try
        {
            // intentar hacer algo que falle.
            return $this->doComplexStuff();
        }
        catch (Exception $e)
        {
            // The 'return' is required to trigger the trick
            // retorna un auliar.
            return My_ToStringFixer::throwToStringException($e);
        }
    }
}

$x = new My_Class();

try
{
    echo $x;
}
catch (Exception $e)
{
    echo 'obtuvimos la exepcion! : '. $e.' con este mensaje' ;
}

?>
*/
