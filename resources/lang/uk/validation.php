<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute має бути принятим.',
    'active_url' => ':attribute неправильне посилання.',
    'after' => ':attribute має бути датою більшою ніж :date.',
    'after_or_equal' => ':attribute має бути датою більшою ніж або рівною :date.',
    'alpha' => ':attribute має складатися лише з букв.',
    'alpha_dash' => ':attribute може містити лише букви, цифри, дефіс та підкреслювання.',
    'alpha_num' => ':attribute може містити лише букви та цифри.',
    'array' => ':attribute має бути масивом.',
    'before' => ':attribute має бути датою перед :date.',
    'before_or_equal' => ':attribute має бути датою перед або рівною до :date.',
    'between' => [
        'numeric' => ':attribute має бути в межах від :min до :max.',
        'file' => ':attribute має мати розмір від :min до :max КБ.',
        'string' => ':attribute повинен мать від :min до :max символів.',
        'array' => ':attribute повинен мати від :min до :max елементів.',
    ],
    'boolean' => ':attribute повинен бути булевого типу.',
    'confirmed' => ':attribute не співпадає.',
    'date' => ':attribute невалідна дата.',
    'date_equals' => ':attribute має бути :date.',
    'date_format' => ':attribute повинен бути у форматі :format.',
    'different' => ':attribute і :other мають бути різні.',
    'digits' => ':attribute має складатися з :digits цифр.',
    'digits_between' => ':attribute повинен мати від :min до :max цифр.',
    'dimensions' => ':attribute має неправильні розміри.',
    'distinct' => ':attribute є дуплікатом.',
    'email' => ':attribute має бути поштою.',
    'ends_with' => ':attribute повинен закінчуватися на: :values.',
    'exists' => ':attribute невалідний.',
    'file' => ':attribute має бути файлом.',
    'filled' => ':attribute має бути заповнене.',
    'gt' => [
        'numeric' => ':attribute має бути більше ніж :value.',
        'file' => ':attribute має мати розмір більше ніж :value КБ.',
        'string' => ':attribute має мати більше ніж :value символів.',
        'array' => ':attribute має мати більше ніж :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute має бути більше або рівним :value.',
        'file' => ':attribute має мати розмір більше або рівним :value КБ.',
        'string' => ':attribute має мати більше або рівно :value символів.',
        'array' => ':attribute має мати більше або рівно :value элементов.',
    ],
    'image' => ':attribute має бути зображенням.',
    'in' => ':attribute невалідне.',
    'in_array' => ':attribute не існує в :other.',
    'integer' => ':attribute має бути цілим числом.',
    'ip' => ':attribute має бути IP адресою.',
    'ipv4' => ':attribute має бути IPv4 адресою.',
    'ipv6' => ':attribute має бути IPv6 адресою.',
    'json' => ':attribute має бути валідною JSON рядком.',
    'lt' => [
        'numeric' => ':attribute має бути менше ніж :value.',
        'file' => ':attribute повинен мати розмір менше ніж :value КБ.',
        'string' => ':attribute повинен мати менше :value символів.',
        'array' => ':attribute повинен мати менше :value елементів.',
    ],
    'lte' => [
        'numeric' => ':attribute має бути менше ніж :value.',
        'file' => ':attribute повинен мати розмір менше ніж :value КБ.',
        'string' => ':attribute повинен мати менше :value символів.',
        'array' => ':attribute повинен мати менше :value елементів.',
    ],
    'max' => [
        'numeric' => ':attribute повинен бути не більше :max.',
        'file' => ':attribute повинен мати розмір не більше :max КБ.',
        'string' => ':attribute повинен мати не більше :max символів.',
        'array' => ':attribute повинен мати не більше :max елементів.',
    ],
    'mimes' => ':attribute повинен мати тип: :values.',
    'mimetypes' => ':attribute повинен мати тип: :values.',
    'min' => [
        'numeric' => ':attribute повинен бути не менше :min.',
        'file' => ':attribute повинен мати розмір не менше :min КБ.',
        'string' => ':attribute повинен мати не менше :min символів.',
        'array' => ':attribute повинен мати не менше :min елементів.',
    ],
    'multiple_of' => ':attribute должен что-то) :value',
    'not_in' => ':attribute невалідне.',
    'not_regex' => ':attribute формат невалідний.',
    'numeric' => ':attribute має бути числом.',
    'password' => 'Пароль неправильний.',
    'present' => ':attribute має бути.',
    'regex' => ':attribute формат неправильний.',
    'required' => ':attribute обов\'язкове поле.',
    'required_if' => ':attribute обов\'язкове коли :other рівне :value.',
    'required_unless' => ':attribute обов\'язкове коли :other не рівне :values.',
    'required_with' => ':attribute обов\'язкове коли існує :values.',
    'required_with_all' => ':attribute обов\'язкове коли існують поля: :values.',
    'required_without' => ':attribute обов\'язкове коли :values не існує.',
    'required_without_all' => ':attribute обов\'язкове коли поля :values не існують.',
    'same' => ':attribute і :other мають бути рівні.',
    'size' => [
        'numeric' => ':attribute повинен мати :size цифр.',
        'file' => ':attribute повинен мати розмір :size КБ.',
        'string' => ':attribute повинен мати :size символів.',
        'array' => ':attribute повинен мати :size елементів.',
    ],
    'starts_with' => ':attribute має починатися з: :values.',
    'string' => ':attribute має бути рядком.',
    'timezone' => ':attribute має бути часовою зоною.',
    'unique' => ':attribute вже занятий.',
    'uploaded' => ':attribute не завантажено.',
    'url' => ':attribute формат невірний.',
    'uuid' => ':attribute має бути UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
