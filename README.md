# Subreg.cz API client class
###installation with composer

    composer require podnik/subreg

### Init
Class Subreg is under Podnik namespace

    use Podnik\Subreg;
    $subreg = new Subreg('login', 'password');
###Usage
Names of class methods and parameters correspond with subreg.cz API commands (ssid is passed automatically).

    $response = $subreg->Info_Domain('domain.xyz');
    
All optional parameters have to be passed as an array

    $response = Upload_Document($name, $document, ['filetype' => 'value', 'type' => 'value])
    //or with no optional parameters
    $response = Upload_Document($name, $document)