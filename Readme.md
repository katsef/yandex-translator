# <img src="https://storage.yandexcloud.net/webazon/github/Yandex_Translate_icon.svg.png" width="5%" height="5%" /> yandex-translator

[![License: MIT](https://img.shields.io/github/license/katsef/yandex-translator)](https://opensource.org/licenses/MIT) ![GitHub Release](https://img.shields.io/github/v/release/katsef/yandex-translator) ![GitHub Downloads (all assets, all releases)](https://img.shields.io/github/downloads/katsef/yandex-translator/total)

------

### Неофициальная API PHP библиотека  [Яндекс.Переводчика](https://yandex.cloud/ru/services/translate). **Версия 2**.

Для начала реализации необходимо настроить сервисный аккаунт на [Яндекс.Облаке](https://cloud.yandex.ru), определить ID каталога и получить сервисный API-ключ.

------

### Установка

Можно установить используя менеджер пакетов [Composer](https://getcomposer.org)

```bash
$ composer require webazon/yandex-translator
```

или скачать пакет с [GitHub](https://github.com/katsef/yandex-translator)

### Инициализация и использование

```php
require __DIR__ . '/vendor/autoload.php';
$translator = new Translator(["folder_id"=> "<ID каталога>", "ApiKey"=>'<API-ключ>']);
$translate = $translator->Translate('Hello, World','en-ru');
$text = $translate -> text;
```

------

Список поддерживаемых языков можно получить командой:

```php
$translate = $translator->listLanguages();
```

или в файле [JSON](https://github.com/katsef/yandex-translator/blob/main/languages.json) в корне проекта.

------

------

### Unofficial PHP API library  [Yandex.Translate](https://yandex.cloud/ru/services/translate). **Version 2**.

To start the implementation, you need to set up a service account on [Yandex.Cloud](https://cloud.yandex.ru), determine the folder ID and get the service API key.

------

### Installation

Can be installed using the package manager [Composer](https://getcomposer.org)

```bash
$ composer require webazon/yandex-translator
```

or download the package from [GitHub](https://github.com/katsef/yandex-translator)

### Initialization and usage

```php
require __DIR__ . '/vendor/autoload.php';
$translator = new Translator(["folder_id"=> "<Catalog ID>", "ApiKey"=>'<API-key>']);
$translate = $translator->Translate('Hello, World','en-ru');
$text = $translate -> text;
```

------

The list of supported languages can be obtained using the command:

```php
$translate = $translator->listLanguages();
```

or in the file [JSON](https://github.com/katsef/yandex-translator/blob/main/languages.json) at the root of the project.

------

------



