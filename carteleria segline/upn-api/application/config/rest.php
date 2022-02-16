<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| ------------------------------------------------- -------------------------
| Protocolo HTTP
| ------------------------------------------------- -------------------------
|
| Establecer para forzar el uso de HTTPS para llamadas a la API REST
|
*/
$config['force_https'] = FALSE;

/*
| ------------------------------------------------- -------------------------
| Formato de salida REST
| ------------------------------------------------- -------------------------
|
| El formato predeterminado de la respuesta
|
| 'array': estructura de datos de matriz
| 'csv': archivo separado por comas
| 'json': utiliza json_encode (). Nota: si una cadena de consulta GET
| llamada 'callback' se pasa, luego se devuelve jsonp
| HTML 'html' utilizando la biblioteca de tablas en CodeIgniter
| 'php': utiliza var_export ()
| 'serializado': utiliza serializar ()
| 'xml': utiliza simplexml_load_string ()
|
*/
$config['rest_default_format'] = 'json';

/*
| ------------------------------------------------- -------------------------
| REST Formatos de salida soportados
| ------------------------------------------------- -------------------------
|
| La siguiente configuración contiene una lista de los formatos soportados / permitidos.
| Puede eliminar los formatos que no desea usar.
| Si falta el formato predeterminado $ config ['rest_default_format'] dentro
| $ config ['rest_supported_formats'], se agregará en silencio durante
| REST_Inicialización del controlador.
|
*/
$config['rest_supported_formats'] = [
    'json',
    'array',
    'csv',
    'html',
    'jsonp',
    'php',
    'serialized',
    'xml',
];

/*
| ------------------------------------------------- -------------------------
| Nombre de campo de estado REST
| ------------------------------------------------- -------------------------
|
| El nombre de campo para el estado dentro de la respuesta
|
*/
$config['rest_status_field_name'] = 'status';

/*
| ------------------------------------------------- -------------------------
| Nombre de campo del mensaje REST
| ------------------------------------------------- -------------------------
|
| El nombre del campo para el mensaje dentro de la respuesta
*/
$config['rest_message_field_name'] = 'error';

/*

| ------------------------------------------------- -------------------------
| Habilitar solicitud de emulación
| ------------------------------------------------- -------------------------
|
| ¿Deberíamos habilitar la emulación de la solicitud (por ejemplo, utilizada en la solicitud de Mootools)?
|
*/
$config['enable_emulate_request'] = TRUE;

/*
| ------------------------------------------------- -------------------------
| Reino REST
| ------------------------------------------------- -------------------------
|
| Nombre de la API REST protegida por contraseña que se muestra en los cuadros de diálogo de inicio de sesión
|
| Por ejemplo: My Secret REST API
|
*/
$config['rest_realm'] = 'REST API';

/*
| ------------------------------------------------- -------------------------
| REST Login
| ------------------------------------------------- -------------------------
|
| Establecer para especificar que la API REST requiere estar conectado
|
| FALSO No se requiere iniciar sesión
| 'básico' Acceso no seguro
| 'digest' Más seguridad de inicio de sesión
| 'sesión' Compruebe si hay una variable de sesión PHP. Ver 'auth_source' para configurar el
| clave de autorización
|
*/
$config['rest_auth'] = FALSE;

/*
| ------------------------------------------------- -------------------------
| REST Login Source
| ------------------------------------------------- -------------------------
|
| Es necesario iniciar sesión y, de ser así, la tienda de usuario para usar
|
| '' Usar usuarios basados en configuraciones o pruebas de comodines
| 'ldap' Usar autenticación LDAP
| 'library' Usa una biblioteca de autenticación
|
| Nota: Si 'rest_auth' está establecido en 'session', entonces cambie 'auth_source' al nombre de la variable de sesión
|
*/
$config['auth_source'] = 'ldap';

/*
| ------------------------------------------------- -------------------------
| Permitir Autenticación y Claves API
| ------------------------------------------------- -------------------------
|
| Donde desee tener inicio de sesión Básico, Digest o Sesión, pero también desea utilizar las Teclas API (para limitar
| solicitudes, etc.), establecido en TRUE;
|
*/
$config['allow_auth_and_keys'] = TRUE;
$config['strict_api_and_auth'] = TRUE; // force the use of both api and auth before a valid api request is made

/*
| ------------------------------------------------- -------------------------
| Clase y función de inicio de sesión REST
| ------------------------------------------------- -------------------------
|
| Si se utiliza la autenticación de la biblioteca, defina la clase y el nombre de la función
|
| La función debe aceptar dos parámetros: clase-> función ($ nombre de usuario, $ contraseña)
| En otros casos, anule la función _perform_library_auth en su controlador
|
| Para la autenticación resumida, la función de la biblioteca debe devolver ya un almacenamiento
| md5 (username: restrealm: password) para ese nombre de usuario
|
| Por ejemplo: md5 ('admin: REST API: 1234') = '1e957ebc35631ab22d5bd6526bd14ea2'
*/
$config['auth_library_class'] = '';
$config['auth_library_function'] = '';

/*
|--------------------------------------------------------------------------
| Override auth types for specific class/method
|--------------------------------------------------------------------------
|
| Set specific authentication types for methods within a class (controller)
|
| Set as many config entries as needed.  Any methods not set will use the default 'rest_auth' config value.
|
| e.g:
|
|           $config['auth_override_class_method']['deals']['view'] = 'none';
|           $config['auth_override_class_method']['deals']['insert'] = 'digest';
|           $config['auth_override_class_method']['accounts']['user'] = 'basic';
|           $config['auth_override_class_method']['dashboard']['*'] = 'none|digest|basic';
|
| Here 'deals', 'accounts' and 'dashboard' are controller names, 'view', 'insert' and 'user' are methods within. An asterisk may also be used to specify an authentication method for an entire classes methods. Ex: $config['auth_override_class_method']['dashboard']['*'] = 'basic'; (NOTE: leave off the '_get' or '_post' from the end of the method name)
| Acceptable values are; 'none', 'digest' and 'basic'.
|
*/
// $config['auth_override_class_method']['deals']['view'] = 'none';
// $config['auth_override_class_method']['deals']['insert'] = 'digest';
// $config['auth_override_class_method']['accounts']['user'] = 'basic';
// $config['auth_override_class_method']['dashboard']['*'] = 'basic';


// ---Uncomment list line for the wildard unit test
// $config['auth_override_class_method']['wildcard_test_cases']['*'] = 'basic';

/*
|--------------------------------------------------------------------------
| Override auth types for specific 'class/method/HTTP method'
|--------------------------------------------------------------------------
|
| example:
|
|            $config['auth_override_class_method_http']['deals']['view']['get'] = 'none';
|            $config['auth_override_class_method_http']['deals']['insert']['post'] = 'none';
|            $config['auth_override_class_method_http']['deals']['*']['options'] = 'none';
*/

// ---Uncomment list line for the wildard unit test
// $config['auth_override_class_method_http']['wildcard_test_cases']['*']['options'] = 'basic';

/*
|--------------------------------------------------------------------------
| REST Login Usernames
|--------------------------------------------------------------------------
|
| Array of usernames and passwords for login, if ldap is configured this is ignored
|
*/
$config['rest_valid_logins'] = ['admin' => '1234'];

/*
|--------------------------------------------------------------------------
| Global IP White-listing
|--------------------------------------------------------------------------
|
| Limit connections to your REST server to White-listed IP addresses
|
| Usage:
| 1. Set to TRUE and select an auth option for extreme security (client's IP
|    address must be in white-list and they must also log in)
| 2. Set to TRUE with auth set to FALSE to allow White-listed IPs access with no login
| 3. Set to FALSE but set 'auth_override_class_method' to 'white-list' to
|    restrict certain methods to IPs in your white-list
|
*/
$config['rest_ip_whitelist_enabled'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Handle Exceptions
|--------------------------------------------------------------------------
|
| Handle exceptions caused by the controller
|
*/
$config['rest_handle_exceptions'] = TRUE;

/*
|--------------------------------------------------------------------------
| REST IP White-list
|--------------------------------------------------------------------------
|
| Limit connections to your REST server with a comma separated
| list of IP addresses
|
| e.g: '123.456.789.0, 987.654.32.1'
|
| 127.0.0.1 and 0.0.0.0 are allowed by default
|
*/
$config['rest_ip_whitelist'] = '';

/*
|--------------------------------------------------------------------------
| Global IP Blacklisting
|--------------------------------------------------------------------------
|
| Prevent connections to the REST server from blacklisted IP addresses
|
| Usage:
| 1. Set to TRUE and add any IP address to 'rest_ip_blacklist'
|
*/
$config['rest_ip_blacklist_enabled'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST IP Blacklist
|--------------------------------------------------------------------------
|
| Prevent connections from the following IP addresses
|
| e.g: '123.456.789.0, 987.654.32.1'
|
*/
$config['rest_ip_blacklist'] = '';

/*
|--------------------------------------------------------------------------
| REST Database Group
|--------------------------------------------------------------------------
|
| Connect to a database group for keys, logging, etc. It will only connect
| if you have any of these features enabled
|
*/
$config['rest_database_group'] = 'default';

/*
|--------------------------------------------------------------------------
| REST API Keys Table Name
|--------------------------------------------------------------------------
|
| The table name in your database that stores API keys
|
*/
$config['rest_keys_table'] = 'keys';

/*
|--------------------------------------------------------------------------
| REST Enable Keys
|--------------------------------------------------------------------------
|
| When set to TRUE, the REST API will look for a column name called 'key'.
| If no key is provided, the request will result in an error. To override the
| column name see 'rest_key_column'
|
| Default table schema:
|   CREATE TABLE `keys` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `user_id` INT(11) NOT NULL,
|       `key` VARCHAR(40) NOT NULL,
|       `level` INT(2) NOT NULL,
|       `ignore_limits` TINYINT(1) NOT NULL DEFAULT '0',
|       `is_private_key` TINYINT(1)  NOT NULL DEFAULT '0',
|       `ip_addresses` TEXT NULL DEFAULT NULL,
|       `date_created` INT(11) NOT NULL,
|       PRIMARY KEY (`id`)
|   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_keys'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Table Key Column Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'rest_enable_keys', specify the
| column name to match e.g. my_key
|
*/
$config['rest_key_column'] = 'key';

/*
|--------------------------------------------------------------------------
| REST API Limits method
|--------------------------------------------------------------------------
|
| Specify the method used to limit the API calls
|
| Available methods are :
| $config['rest_limits_method'] = 'IP_ADDRESS'; // Put a limit per ip address
| $config['rest_limits_method'] = 'API_KEY'; // Put a limit per api key
| $config['rest_limits_method'] = 'METHOD_NAME'; // Put a limit on method calls
| $config['rest_limits_method'] = 'ROUTED_URL';  // Put a limit on the routed URL
|
*/
$config['rest_limits_method'] = 'ROUTED_URL';

/*
|--------------------------------------------------------------------------
| REST Key Length
|--------------------------------------------------------------------------
|
| Length of the created keys. Check your default database schema on the
| maximum length allowed
|
| Note: The maximum length is 40
|
*/
$config['rest_key_length'] = 40;

/*
|--------------------------------------------------------------------------
| REST API Key Variable
|--------------------------------------------------------------------------
|
| Custom header to specify the API key

| Note: Custom headers with the X- prefix are deprecated as of
| 2012/06/12. See RFC 6648 specification for more details
|
*/
$config['rest_key_name'] = 'X-API-KEY';

/*
|--------------------------------------------------------------------------
| REST Enable Logging
|--------------------------------------------------------------------------
|
| When set to TRUE, the REST API will log actions based on the column names 'key', 'date',
| 'time' and 'ip_address'. This is a general rule that can be overridden in the
| $this->method array for each controller
|
| Default table schema:
|   CREATE TABLE `logs` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `uri` VARCHAR(255) NOT NULL,
|       `method` VARCHAR(6) NOT NULL,
|       `params` TEXT DEFAULT NULL,
|       `api_key` VARCHAR(40) NOT NULL,
|       `ip_address` VARCHAR(45) NOT NULL,
|       `time` INT(11) NOT NULL,
|       `rtime` FLOAT DEFAULT NULL,
|       `authorized` VARCHAR(1) NOT NULL,
|       `response_code` smallint(3) DEFAULT '0',
|       PRIMARY KEY (`id`)
|   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_logging'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST API Logs Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'rest_enable_logging', specify the
| table name to match e.g. my_logs
|
*/
$config['rest_logs_table'] = 'logs';

/*
|--------------------------------------------------------------------------
| REST Method Access Control
|--------------------------------------------------------------------------
| When set to TRUE, the REST API will check the access table to see if
| the API key can access that controller. 'rest_enable_keys' must be enabled
| to use this
|
| Default table schema:
|   CREATE TABLE `access` (
|       `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
|       `key` VARCHAR(40) NOT NULL DEFAULT '',
|       `all_access` TINYINT(1) NOT NULL DEFAULT '0',
|       `controller` VARCHAR(50) NOT NULL DEFAULT '',
|       `date_created` DATETIME DEFAULT NULL,
|       `date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
|       PRIMARY KEY (`id`)
|    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_access'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST API Access Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'rest_enable_access', specify the
| table name to match e.g. my_access
|
*/
$config['rest_access_table'] = 'access';

/*
|--------------------------------------------------------------------------
| REST API Param Log Format
|--------------------------------------------------------------------------
|
| When set to TRUE, the REST API log parameters will be stored in the database as JSON
| Set to FALSE to log as serialized PHP
|
*/
$config['rest_logs_json_params'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Enable Limits
|--------------------------------------------------------------------------
|
| When set to TRUE, the REST API will count the number of uses of each method
| by an API key each hour. This is a general rule that can be overridden in the
| $this->method array in each controller
|
| Default table schema:
|   CREATE TABLE `limits` (
|       `id` INT(11) NOT NULL AUTO_INCREMENT,
|       `uri` VARCHAR(255) NOT NULL,
|       `count` INT(10) NOT NULL,
|       `hour_started` INT(11) NOT NULL,
|       `api_key` VARCHAR(40) NOT NULL,
|       PRIMARY KEY (`id`)
|   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
|
| To specify the limits within the controller's __construct() method, add per-method
| limits with:
|
|       $this->method['METHOD_NAME']['limit'] = [NUM_REQUESTS_PER_HOUR];
|
| See application/controllers/api/example.php for examples
*/
$config['rest_enable_limits'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST API Limits Table Name
|--------------------------------------------------------------------------
|
| If not using the default table schema in 'rest_enable_limits', specify the
| table name to match e.g. my_limits
|
*/
$config['rest_limits_table'] = 'limits';

/*
| ------------------------------------------------- -------------------------
| REST Ignorar HTTP Aceptar
| ------------------------------------------------- -------------------------
|
| Establézcalo en TRUE para ignorar el HTTP Accept y acelerar cada solicitud un poco.
| Solo haga esto si está usando $ this-> rest_format o / format / xml en las URL
|
*/
$config['rest_ignore_http_accept'] = FALSE;

/*
| ------------------------------------------------- -------------------------
| RESTO AJAX solamente
| ------------------------------------------------- -------------------------
|
| Establézcalo en TRUE para permitir solo las solicitudes de AJAX. Establecido en FALSE para aceptar solicitudes HTTP
|
| Nota: si se establece en VERDADERO y la solicitud no es AJAX, una respuesta 505 con el
| mensaje de error 'Solo se aceptan solicitudes AJAX'. Será devuelto.
|
| Sugerencia: esto es bueno para entornos de producción
*/
$config['rest_ajax_only'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Language File
|--------------------------------------------------------------------------
|
| Language file to load from the language directory
|
*/
$config['rest_language'] = 'english';

/*
| ------------------------------------------------- -------------------------
| CORS Check
| ------------------------------------------------- -------------------------
|
| Establézcalo en TRUE para habilitar Compartir recursos de origen cruzado (CORS). Útil si
| están alojando su API en un dominio diferente de la aplicación que
| accederá a él a través de un navegador
*/
$config['check_cors'] = false;

/*
| ------------------------------------------------- -------------------------
| CORS Cabeceras permitidas
| ------------------------------------------------- -------------------------
|
| Si usa las verificaciones de CORS, establezca los encabezados permitidos aquí
|
*/
$config['allowed_cors_headers'] = [
    'Origin',
    'X-Requested-With',
    'Content-Type',
    'Accept',
    'Access-Control-Request-Method'
];

/*
| ------------------------------------------------- -------------------------
| CORS Métodos permitidos
| ------------------------------------------------- -------------------------
|
| Si usa cheques CORS, puede establecer los métodos que desea que se le permitan
|
*/
$config['allowed_cors_methods'] = [
    'GET',
    'POST',
    'OPTIONS',
    'PUT',
    'PATCH',
    'DELETE'
];

/*
| ------------------------------------------------- -------------------------
| CORS Permitir cualquier dominio
| ------------------------------------------------- -------------------------
|
| Establezca en TRUE para habilitar Compartir recursos de origen cruzado (CORS) desde cualquier
| dominio fuente
*/
$config['allow_any_cors_domain'] = false;

/*
| Dominios permitidos CORS
| ------------------------------------------------- -------------------------
|
| Usado si $ config ['check_cors'] está establecido en TRUE y $ config ['allow_any_cors_domain']
| está configurado a FALSO. Establecer todos los dominios permitidos dentro de la matriz
|
| p.ej. $ config ['allowed_origins'] = ['http://www.example.com', 'https://spa.example.com']
|
*/
$config['allowed_cors_origins'] = ['http://localhost:4200/','http://venetronic.com'];

/*
| ------------------------------------------------- -------------------------
| Encabezados forzados CORS
| ------------------------------------------------- -------------------------
|
| Si usa las comprobaciones CORS, siempre incluya los encabezados y valores especificados aquí
| en la opción de verificación previa del cliente OPTIONS.
| Ejemplo:
| $ config ['forced_cors_headers'] = [
| 'Access-Control-Allow-Credentials' => 'verdadero'
| ];
|
| Agregado por la forma en que el marco Sencha Ext JS requiere el encabezado
| Access-Control-Allow-Credentials se establece en verdadero para permitir el uso de
| credenciales en el proxy REST.
| Ver documentación aquí:
| http://docs.sencha.com/extjs/6.5.2/classic/Ext.data.proxy.Rest.html#cfg-withCredentials
|
*/
$config['forced_cors_headers'] = [];