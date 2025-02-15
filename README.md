# DTO Package

Этот пакет предоставляет простую реализацию Data Transfer Object (DTO) для PHP, позволяющую автоматически преобразовывать вложенные массивы в DTO-объекты. Основные возможности:

- **Автоматический кастинг вложенных DTO по типизации:** Если свойство имеет тип, являющийся подклассом `BaseDTO`, и переданы данные в виде массива, то происходит автоматическое преобразование в DTO.
- **Явный кастинг через атрибуты:** Для свойств, представляющих массивы вложенных DTO, можно использовать атрибут `[Cast]` с флагом `isArray`.

## Установка

Добавьте пакет в ваш проект через Composer:

```bash
composer require sinersis/simple-dto
```

## Применение

```php
<?php
namespace SimleDto\DTO;

use SimleDto\BaseDTO;
use SimleDto\Attributes\Cast;

class UserDTO extends BaseDTO
{
    public string $name;

    /**
    * Автоматический кастинг по типизации: 
    * если данные представлены в виде массива, 
    * будет создан объект AddressDTO
    */
    public AddressDTO $address;

    /**
    * Для массива вложенных объектов используем атрибут Cast
    */
    #[Cast(AddressDTO::class, true)]
    public array $addresses;
}

class AddressDTO extends BaseDTO
{
    public string $city;
    public string $street;
}

$data = [
    'name' => 'Ivan',
    'address' => [
        'city' => 'Moscow',
        'street' => 'Lenina'
    ],
    'addresses' => [
        [
            'city' => 'Moscow',
            'street' => 'Lenina'
        ],
        [
            'city' => 'Saint-Petersburg',
            'street' => 'Nevsky'
        ]
    ]
];

$user = new UserDTO($data);

echo $user->name;            // Выведет: Ivan
echo $user->address->city;   // Выведет: Moscow

foreach ($user->addresses as $address) {
    echo $address->city . PHP_EOL;
}
```