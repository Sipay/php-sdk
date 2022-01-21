#  1. Introducción
El siguiente proyecto constituye una SDK en PHP, que simplifica la ejecución de llamadas al servicio Ecommerce de Sipay.

# 2. Quickstart

Con el siguiente ejemplo podrás, en pocos pasos, instalar la SDK y efectuar una venta desde una terminal.
Antes de hacer el quickstart, debemos crear el archivo de configuraciones, tomando como referencia el indicado en la sección de configuración

```bash
  $ git clone https://github.com/sipay/php-sdk
  $ echo '
  <?php
  require_once "php-sdk/src/autoload.php";
  $ecommerce = new \Sipay\Ecommerce("php-sdk/etc/config.ini"); // Configurar el archivo de configuración como se indica en la sección Ecommerce
  $amount = new \Sipay\Amount(100, "EUR");
  $card = new \Sipay\Paymethods\Card("4242424242424242", 2050, 12);
  $options = array(
    "order" => "order-test",
    "reference" => "1234",
    "token" => "new-token"
  );
  $auth = $ecommerce->authorization($card, $amount, $options);
  if($auth->code == 0){
    print("Autorización aceptada, el pago ha sido completado!\n");
  }else{
    print("Error: ".$auth->description."\n");
  }
  ' > quickstart.php
  $ php quickstart.php
```
# 3. Instalación
## 3.1 Pre-requisitos
 PHP >= 7.x

## 3.2 Pasos
Podemos instalarlo de forma manual (Ver "Extracción de código") o utilizando Composer (Ver "Composer").

### 3.2.1 Extracción de código

Este paso se omite si se utiliza la instalación via composer.

  ```bash
    $ git clone https://github.com/sipay/php-sdk.git
  ```

Entonces establecemos la variable "path_autoload" a "<directorio_de_descarga_de_php-sdk>/src/autoload.php"

```php
$path_autoload = "<directorio_de_descarga_de_php-sdk>/src/autoload.php";
```

## 3.2.2 Composer

Este paso se omite si se utiliza el método manual.

```bash
$ composer require sipay/php-sdk

```

Entonces establecemos la variable "path_autoload" a "vendor/autoload.php":

```php
$path_autoload = "vendor/autoload.php";
```

# 4. Configuración
Una vez que se ha instalado la SDK, se deben actualizar los parámetros de configuración asociados a:
* Sistema de trazas.
* Credenciales de acceso (Se gestionan con el departamento de integraciones de Sipay).
* Entorno y versión de la API.
* Tiempo máximo de espera de respuestas (Timeout).
## 4.1. Desde un fichero

  Un ejemplo de configuraciones se muestra a continuación:
  ```ini
  ; **************************************************************
  ; LOGGER
  ; ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  ; Configuración asociada al sistema de trazas.
  ;
  ; path: ruta del directorio de logs (Nota: Aconsejable usar rutas absolutas, en caso contrario los logs estaran dentro del paquete)
  ; level: nivel mínimo de trazas [debug, info, warning, error, critical]
  ; prefix: prefijo
  ; extension: extensión del archivo
  ; date_format: formato de fecha de las trazas
  ; backup_file_rotation: Número de ficheros de backup
  ; ------------------------------------------------------------//

  [logger]
  path=logs
  level=warning
  prefix=logger
  extension=log
  date_format=d/m/Y H:i:s
  backup_file_rotation = 5

  ; **************************************************************
  ; CREDENTIALS
  ; ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  ; Credenciales para obtener acceso al recurso.
  ;
  ; key: Key del cliente
  ; secret: Secret del cliente
  ; resouce: Recurso al que se quiere acceder
  ; ------------------------------------------------------------//

  [credentials]
  key=api-key
  secret=api-secret
  resource=resource

  ; **************************************************************
  ; API
  ; ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  ; Configuracion de la API.
  ;
  ; environment: Entorno al que se deben enviar las peticiones ['sandbox', 'staging', 'live']
  ; version: Versión de la api a usar actualmente solo existe v1
  ; mode: Modo de encriptacion de la firma, [sha256, sha512]
  ; ------------------------------------------------------------//

  [api]
  environment=sandbox
  version=v1
  mode=sha256

  ; **************************************************************
  ; Connection
  ; ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  ; Cofiguracion de la conexión.
  ;
  ; timeout: Tiempo máximo de espera a la respuesta de la petición
  ; ------------------------------------------------------------//

  [connection]
  timeout=30
  ```

## 4.2. Desde una variable
En algunos casos, pudiera interesarnos cargar la configuración desde una variable y no desde un archivo. Este sería un ejemplo:

```php
  <?php
  $config = array(
      'logger' => array(
          'path' => 'logs',  // Nombre del directorio donde se crearan los logs (Nota: si la ruta es relativa se creará en el directorio del paquete)
          'level' => 'warning',  // Nivel mínimo de trazas [debug, info, warning, error, critical]
          'prefix' => 'logger',  // Prefijo del nombre del archivo
          'extension' => 'log',  // Extensión del archivo
          'date_format' => 'd/m/Y H:i:s',  // Formato de fecha de las trazas de log
          'backup_file_rotation' => 5  // Número de ficheros de backup
      ),
      'credentials' => array(
          'key' => 'api-key',  // Key del cliente
          'secret' => 'api-secret',  // Secret del cliente
          'resource' => 'resource' // Recurso al que se quiere acceder
      ),
      'api' => array(
          'environment' => 'sandbox',  // Entorno al que se deben enviar las peticiones ['sandbox', 'staging', 'live']
          'version' => 'v1',  // Versión de la api a usar actualmente solo existe v1
          'mode' => 'sha256'  // Modo de encriptacion de la firma, [sha256, sha512]
      ),
      'connection' => array(
          'timeout' => 30  // Tiempo máximo de respuesta de la petición.
      )
  );

```

# 5. Documentación extendida
A través de peticiones a Sipay mediante Ecommerce, se pueden realizar operativas de:
* Autorizaciones (sección 5.2.1).
* Cancelaciones (sección 5.2.2).
* Devoluciones (sección 5.2.3).
* Búsquedas de operaciones o querys (sección 5.2.4).
* Tokenización* de tarjetas (sección 5.2.5).
* Búsqueda de tarjetas tokenizadas (sección 5.2.6).
* Dar de baja una tarjeta tokenizada (sección 5.2.7).

_* Tokenización_: Es un proceso por el cual el PAN (_Primary Account Number_ – Número Primario de Cuenta) de la tarjeta se sustituye por un valor llamado token. Esta funcionalidad permite que Sipay guarde los datos de la tarjeta del cliente, para agilizar el proceso de pagos y evitar que se deba introducir, cada vez, los datos de tarjeta, en pagos repetitivos. Sipay realiza el almacenamiento de los datos de forma segura, cumpliendo con las normativas PCI.

Para llevar a cabo de forma correcta las operativas Ecommerce, se requiere el dominio de los objetos `Amount`, `Card`, `StoredCard` y `FastPay`, los cuales identifican el importe y el método de pago a utilizar.


## 5.1. Objetos necesarios en las operativas de Ecommerce

### **5.1.1. `Amount(amount,currency)`**

#### Definición
Este objeto representa una cantidad monetaria, por tanto esta cantidad debe ser mayor que cero (0). Para instanciar un objeto de este tipo se necesita una cantidad (amount) y una moneda (currency) en formato ISO4217 (https://en.wikipedia.org/wiki/ISO_4217).
La cantidad se puede especificar de tres formas:
* Con un `string` con la cantidad estandarizada y con el caracter punto (`.`) como separador de decimales (Ejemplo:  `"1.56"`), o
* Con un `string` que represente la cantidad en la unidad básica e indivisible de la moneda (Ejemplo: `"156"`), o
* Con un `int` que represente la cantidad en la unidad básica e indivisible de la moneda, es decir, la moneda Euro sería el céntimo (Ejemplo: `156`).


#### Parámetros
* **`amount`:**  [_obligatorio_] Es la cantidad de dinero a procesar. Se puede representar con un `string` o un `int`. Supongamos que queremos procesar 1.56 €, la cantidad (1.56) como un `string` sería `'1.56'` ó `'156'` ; como un `int` sería `156`.
* **`currency`:** [_obligatorio_] Es un `string` que representa el código de la moneda (ISO4217).

#### Atributos
* **`amount`:** `int` que representa la cantidad de procesamiento. Será este tipo de dato, independientemente de si se ha instanciado con un `string` previamente (`protected`).
* **`currency`:** `string` que representa el código de la moneda (ISO4217) (`protected`).

#### Métodos
* **`set(amount, currency)`:** Asigna un importe y moneda del tipo indicado en la sección de parámetros.
* **`get_amount()`:**  Devuelve el atributo amount.
* **`get_currency()`:** Devuelve el atributo currency.
* **`get_array()`:** Devuelve el amount y el currency como un array asociativo.

#### Ejemplo

```php
  <?php
  require_once $path_autoload;

  // Con string
  $amount = new \Sipay\Amount('1.56', 'EUR');

  print($amount."\n")
  // Imprime 1.56EUR
  print($amount->get_amount()."\n")
  // Imprime 156
  print($amount->get_currency()."\n")
  // Imprime EUR

  // Con unidad indivisible
  $amount = new \Sipay\Amount(156, 'EUR');

  print($amount."\n")
  // Imprime 1.56EUR
  print($amount->get_amount()."\n")
  // Imprime 156
  print($amount->get_currency()."\n")
  // Imprime EUR

  // Con string en unidad indivisible
  $amount = new \Sipay\Amount('156', 'EUR');

  print($amount."\n")
  // Imprime 1.56EUR
  print($amount->get_amount()."\n")
  // Imprime 156
  print($amount->get_currency()."\n")
  // Imprime EUR
```
**Nota:** En el caso de iniciarlo con un `string` que incluya un punto es imprescindible que tenga el número de decimales que indica el estándar ISO4217. Ejemplo: para la moneda euro (€) que establece dos decimales, es correcto indicar un amount de `"1.40"` pero no es correcto `"1.4"`.

### **5.1.2. `Card(card_number, year, month)`**

#### Definición
Este objeto representa una tarjeta que se puede utilizar en las diferentes operativas de Ecommerce. Para obtener una instancia de `Card`, los parámetros se indican a continuación.

#### Parámetros
* **`card_number`:** [_obligatorio_] Es un `string` con  longitud entre 14 y 19 dígitos. Representa el número de la tarjeta.
* **`year`:** [_obligatorio_] Es un `int` de 4 dígitos que indica el año de caducidad de la tarjeta.
* **`month`:** [_obligatorio_] Es un `int` de 2 dígitos con valores entre 1 y 12 que correspondiente al mes de caducidad de la tarjeta.

#### Atributos
* **`card_number`:** Es el número de la tarjeta en una instancia de `Card`. Es un `string` con longitud entre 14 y 19 dígitos (`protected`).
* **`year`:** Es al año de caducidad de la tarjeta en una instancia de `Card`. Es un  `int` de 4 dígitos (`protected`).
* **`month`:** Es el mes de caducidad de la tarjeta en una instancia de `Card`. Es un `int` de 2 dígitos entre 1 y 12 (`protected`).

#### Métodos
* **`set_card_number(card_number)`:** Permite asignar el PAN de la tarjeta
* **`set_expiration_date(year, month)`:** Permite asignar la fecha de caducidad de la tarjeta
* **`get_year()`:** Devuelve el atributo año.
* **`get_month()`:** Devuelve el atributo mes.
* **`get_card_number()`:** Devuelve el atributo card_number.
* **`to_json()`:** Devuelve todos los atributos del objeto.


#### Ejemplo
```php
  <?php
  require_once $path_autoload;

  $card = new \Sipay\Paymethods\Card('4242424242424242', 2018, 12);
```

### **5.1.3. `StoredCard(token)`**
#### Definición
Este objeto representa una tarjeta almacenada en Sipay que puede utilizarse en operativas Ecommerce. Para obtener una instancia de `StoredCard` se requieren los siguiente parámetros.

#### Parámetros
* **`token`:** [_obligatorio_] Es un `string` de longitud entre 6 y 128 caracteres de tipo alfanuméricos y guiones (`protected`).

#### Atributos
* **`token`:** `string` de longitud entre 6 y 128 caracteres.

#### Métoddos
* **`set_token`:**  Permite asignar el token.
* **`get_token`:**  Devuelve el token.

#### Ejemplo
```php
  <?php
  require_once $path_autoload;

  $card = new \Sipay\Paymethods\StoredCard('token-card');
```

### **5.1.4. `FastPay(token)`**

#### Definición
Este objeto representa una tarjeta obtenida mediante el método de pago FastPay. Se utiliza en los consecutivos pasos de la operativas de pago de este método.

#### Parámetros
* **`token`:** [_obligatorio_] Es un `string` de longitud 32 con caracteres de tipo hexadecimal.

#### Atributos
* **`token`:**`string` de longitud 32 caracteres de tipo hexadecimal (`protected`).

#### Métoddos
* **`set_token`:**  Permite asignar el token.
* **`get_token`:**  Devuelve el token.

#### Ejemplo
Ejemplo:
```php
  <?php
  require_once $path_autoload;

  $card = new \Sipay\Paymethods\FastPay('token-fast-pay');
```

## 5.2. Operativas de Ecommerce - `Ecommerce($config_file)` ó `Ecommerce($config_var)`

#### Descripción
Las operativas de Ecommerce forman parte de los métodos definidos en la clase `Ecommerce`. Para instanciar un objeto de este tipo se requiere el archivo de configuración.

#### Ejemplo
```php
  <?php
  require_once $path_autoload;

  $ecommerce = \Sipay\Ecommerce('etc/config.ini');
```

#### Parámetros
* **`config_file`** [_obligatorio_] Es un `string` con la ruta del archivo de configuraciones.

#### Atributos
Los siguientes atributos (`protected`) se asignan en el archivo de configuraciones. Sin embargo, son accesibles en instancias de `Ecommerce`. Se sugiere que sean utilizados en modo de consulta.
* **`key`:** corresponde al key de las credenciales.
* **`secret`:** corresponde al secret de las credenciales.
* **`resource`:** corresponde al resource de las credenciales.
* **`environment`:** corresponde al entorno al cual se está apuntando.
* **`mode`:** corresponde el modo de cifrado de las peticiones.
* **`version`:** corresponde a la versión de la API a la cual se apunta.
* **`timeout`:** Corresponde al tiempo de espera máximo en recibir respuesta contando desde el momento en que se envía la petición.

#### Métodos
Todos los atributos indicados tienen sus métodos de asignación con `set_[nombre_del_atributo]` y sus métodos de consulta con `get_[nombre_del_atributo]`.
* **`authorization(parameters)`:** Permite hacer peticiones de autorización haciendo uso de los diferentes métodos de pago (ver sección 5.2.1).
* **`cancellation(parameters)`:** Permite enviar peticiones de cancelaciones (ver sección 5.2.2).
* **`refund(parameters)`:** Permite hacer devoluciones (ver sección 5.2.3).
* **`query(parameters)`:** Permite hacer peticiones de búsqueda de operaciones (ver sección 5.2.4).
* **`register(parameters)`:** Permite tokenizar una tarjeta (ver sección 5.2.5).
* **`card(parameters)`:** Se utiliza para buscar una tarjeta que fue tokenizada (ver sección 5.2.6).
* **`unregister(parameters)`:** Se utiliza para dar de baja una tarjeta tokenizada (ver sección 5.2.7).

## 5.2.1 **`authorization(Paymethods\Paymethod $paymethod, Amount $amount, array $array_options = array())`**

### Definición
 Este método de `Ecommerce` permite enviar una petición de venta a Sipay.
### Parámetros
* **`paymethod`:**[_obligatorio_] Corresponde a una instancia  `Card`, `StoredCard` o `FastPay` que indica el método de pago a utilizar.
* **`amount `:** [_obligatorio_] Corresponde a una instancia de `Amount` que representa el importe de la operación.
* **`array_options `:**
  * **`order `:** [_opcional_] Es un `string` que representa el ticket de la operación.
  * **`reconciliation `:** [_opcional_] Es un `string` que identifica la conciliación bancaria.
  * **`custom_01` :** [_opcional_] Es un `string` que representa un campo personalizable.
  * **`custom_02` :** [_opcional_] Es un `string` que representa un campo personalizable.
  * **`token`:** [_opcional_] Es un `string` que representa un token a almacenar. Se utiliza cuando el método de pago es de tipo `Card` o `Fpay`, y se desea asignar un token específico a la tarjeta utilizada.

### Salida
El método `authorization` devuelve un objeto `Authorization`.

### Ejemplo
**- Autorización con tarjeta**
```php
  $amount = \Sipay\Amount(100, 'EUR'); // 1€
  $card = \Sipay\Paymethods\Card('4242424242424242', 2050, 2);

  $auth = $ecommerce->authorization($card, $amount);
```
**- Autorización con FastPay**
```php
   $amount = \Sipay\Amount(100, 'EUR'); // 1€
   $fp = \Sipay\Paymethods\FastPay('830dc0b45f8945fab229000347646ca5');

   $auth = $ecommerce->authorization($fp, $amount);
```

## 5.2.2 `cancellation(string $transaction_id)`

### Definición
Este método permite enviar una petición de cancelación a Sipay

### Parámetros
* **`transaction_id`:** [_obligatorio_] Es un `string` con el identificador de la transacción.

### Salida
El método `cancellation` devuelve un objeto `Cancellation`.

### Ejemplo
```php
  $cancel = $ecommerce->cancellation('transaction_id');
```
## 5.2.3 `refund($identificator, Amount $amount, array $array_options = array())`


### Definición
Este método `Ecommerce` permite enviar una petición de devolución a Sipay.
### Parámetros
* **`identificator`:** [_obligatorio_] Es una instancia del método de pago (`Card`, `StoredCard` o `FastPay`) o, un `string` que representa el identificador de transacción.
* **`amount `:** [_obligatorio_] Corresponde a una instancia de `Amount` que representa el importe de la operación.
* **`array_options `:**
  * **`order `:** [_opcional_] Es un `string` que representa el ticket de la operación.
  * **`reconciliation `:** [_opcional_] Es un `string` que identifica la conciliación bancaria.
  * **`custom_01` :** [_opcional_] Es un `string` que representa un campo personalizable.
  * **`custom_02` :** [_opcional_] Es un `string` que representa un campo personalizable.
  * **`token`:** [_opcional_] Es un `string` que representa un token a almacenar. Se utiliza cuando el método de pago es de tipo `Card` o `Fpay`, y se desea asignar un token específico a la tarjeta utilizada.


### Salida
El método `refund` devuelve un objeto `Refund`.

### Ejemplo
**- Devolución con tarjeta**
```php
  $amount = \Sipay\Amount(100, 'EUR'); // 1€
  $card = \Sipay\Paymethods\StoredCard('bd6613acc6bd4ac7b6aa96fb92b2572a');
  $refund = $ecommerce->refund($card, $amount);
```

**- Devolución con transaction_id**
```php
  $amount = \Sipay\Amount(100, 'EUR'); // 1€

  $refund = $ecommerce->refund('transaction_id', $amount);
```

## 5.2.5 `query(array $query)`

### Definición
Este método `Ecommerce` permite enviar una petición a Sipay para buscar de una operación concreta.

### Parámetros
 El método puede tener los siguientes parámetros:
* **`order`:** [_opcional_] `string` que representa el ticket de la operación.
* **`transaction_id`:** [_opcional_]  `string` que representa el identificador de la transacción.

En caso de no enviar ninguno, se devuelven todas las transacciones del cliente.

### Salida
El método `query` devuelve un objeto `Query`.

### Ejemplo
**- Búsqueda de transacciones**

```php
  $query = array('transaction_id' => 'transaction_id');
  $query = $ecommerce->query($query);
```

## 5.2.6 `register(Paymethods\Paymethod $card, string $token)`

### Definición
Este método `Ecommerce` permite enviar una petición de tokenización de tarjeta a Sipay.

### Parámetros
  * **`card`:** [_obligatorio_] Instancia de tipo `Card` con la tarjeta a tokenizar o tipo `FastPay`.
  * **`token`:**[_obligatorio_] `string` que representa el token que se asociará a la tarjeta.

### Salida
    El método `register` devuelve un objeto `Register`.

###  Ejemplo

  **- Registro de tarjeta**
  ```php
    $card = \Sipay\Paymethods\Card('4242424242424242', 2050, 2);

    $masked_card = $ecommerce->register($card, 'newtoken');
  ```

## 5.2.7 `card(string $token)`

### Definición
Este método `Ecommerce` permite enviar una petición a Sipay con la finalidad de obtener información de una tarjeta que está tokenizada.

### Parámetros
* **`token`:**[_obligatorio_] `string` que representa el token asociado a la tarjeta.

### Salida
El método `card` devuelve un objeto `Card` del apartado Responses.

###  Ejemplo
**- Búsqueda de tarjeta**

```php
   $masked_card = $ecommerce->card('newtoken');
```

## 5.2.8 `unregister(string $token)`

### Definición
Este método `Ecommerce` permite enviar una petición a Sipay con la finalidad de dar de baja una tarjeta tokenizada.

### Parámetros
* **`token`:**[_obligatorio_] `string` que representa el token asociado a la tarjeta.

### Salida
El método `unregister` devuelve un objeto `Unregister`.

###  Ejemplo
**- Borrar una tarjeta del registro**
```php
  $unregister = $ecommerce->unregister('newtoken');
```

### 5.3 Responses
Todos los objetos obtenidos como respuestas de operativas `Ecommerce` tienen los siguientes atributos.

#### 5.3.1 Atributos comunes

* **`type`:** Es un `enum[string]` que identifica el tipo de respuesta:
    * success
    * warning
    * error
* **`code`:** Es un `int` con el código identificador del resultado. Es un código orientativo y no está ligado estrictamente con motivo de la respuesta, es decir, el código no identifica unívocamente la respuesta.
    - si `code` es `0`, implica que el resultado es un _success_
    - si `code` es mayor a `0`, implica que el resultado es un _warning_
    - si `code` es menor a `0`, implica que el resultado es un _error_
* **`detail`:**  Es un `string` con el código alfanumérico separado con guiones bajos y sin mayúsculas que identifica unívocamente la respuesta. Útil para la gestión de los diferentes casos de uso de una operación.
* **`description`:** Es un `string` con la descripción literal del mensaje de respuesta.
* **`uuid`:** Es un `string` con el identificador único de la petición, imprescindible para la trazabilidad.
* **`request_id`:** Es un `string` utilizado en la finalización de algunas operaciones. Se indicarán aquellas en las que sea necesario.
* **`request`:** Es un `dictionary` que contiene los datos de la petición que se ha hecho al servidor (`protected`).
* **`response`:** Es un `dictionary` que contiene los datos 'raw' de respuesta (`protected`).

#### 5.3.2 `Authorization`
Este objeto añade los siguientes atributos:
* **`amount`:** Objeto de de tipo `Amount` con el importe de la operación.
* **`order`:** Es un `string` con el ticket de la operación.
* **`card_trade`:** Es un `string` que describe el emisor de la tarjeta.
* **`card_type`:**  Es un `string` con el tipo de la tarjeta.
* **`masked_card`:**  Es un `string` con el número de la tarjeta enmascarado.
* **`reconciliation`:**  Es un `string` identificador para la conciliación bancaria (p37).
* **`transaction_id`:**  Es un `string` identificador de la transacción.
* **`aproval`:**  Es un `string` con el código de aprobación de la entidad.
* **`authorizator`:**  Es un `string` con la entidad autorizadora de la operación.

#### 5.3.3 `Refund`
Este objeto añade los atributos:
* **`amount`** Objeto de tipo `Amount` con el importe de la operación.
* **`order`:** Es un `string` con el ticket de la operación.
* **`card_trade`:** Es un `string` con el emisor de la tarjeta.
* **`card_type`:** Es un `string` con el tipo de la tarjeta.
* **`masked_card`:** Es un `string` con con el número de la tarjeta enmascarado.
* **`reconciliation`:** Es un `string` identificador para la conciliación bancaria (p37).
* **`transaction_id`:** Es un `string` identificador de la transacción.
* **`aproval`:** Es un `string` con el código de aprobación de la entidad.
* **`authorizator`:** Es un `string` con la entidad autorizadora de la operación.


#### 5.3.4 `Query`
Este objeto añade una lista de transacciones, cada objeto transacción tiene:

**`Transaction`**
* **`description`:**  Es un `string` con descripción literal del estado de la operación.
* **`date`:**  Es un `datetime` con fecha y hora de la operación.
* **`order`:** Es un `string` con el ticket de la operación.
* **`masked_card`:** Es un `string` con el número de la tarjeta enmascarado.
* **`operation_name`:** Es un `string` con el nombre literal del tipo de operación.
* **`operation`:** Es un `string` identificador del tipo de operación.
* **`transaction_id`:** Es un `string` identificador de la transacción.
* **`status`:** Es un `string` identificador del estado de la operación.
* **`amount`:** Es un objeto `Amount`  con el importe de la operación.
* **`authorization_id`:** Es un `string`  identificador de la entidad autorizadora.
* **`channel_name`:** Es un `string`  con el nombre literal del canal de pago.
* **`channel`:** Es un `string`  identificador del canal de pago.
* **`method`:** Es un `string`  identificador del método de pago.
* **`method_name`:** Es un `string`  identificador literal del método de pago.

#### 5.3.5 `Register`
Este objeto añade lo atributos:
* **`card_mask`:** Es un `string` con el número de la tarjeta enmascarado.
* **`expired_at`:** Es un `date` con fecha de la expiración.
* **`token`:** Es un `string` identificador de la tarjeta.
* **`card`:** Es un objeto `StoredCard` con la tarjeta asociada.

#### 5.3.6 `Cancellation`
Este objeto no añade nada a lo indicado en los atributos comunes.

#### 5.3.7 `Card`
* **`card_mask`:** Es un `string` con el número de la tarjeta enmascarado.
* **`expired_at`:** Parámetro de tipo `date` con la fecha de expiración de la tarjeta.
* **`token`:** Es un `string` identificador de la tarjeta.
* **`card`:** Objeto de tipo `StoredCard`  con los datos asociados a la tarjeta devuelta.

#### 5.3.8 `Unregister`
Este objeto no añade nada a lo descrito en los atributos comunes.
#### 5.3.9 `Card`
* **`cvv`:** Es un `string` identificador de la tarjeta.