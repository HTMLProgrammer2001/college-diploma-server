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

    'accepted' => ':attribute должен быть принятым.',
    'active_url' => ':attribute не валидная ссылка.',
    'after' => ':attribute должен быть датой после :date.',
    'after_or_equal' => ':attribute должен быть датой после или равной :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute может содержать только буквы, цифры, тире и подчеркивания.',
    'alpha_num' => ':attribute может содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должен быть датой перед :date.',
    'before_or_equal' => ':attribute должен быть датой перед или равной :date.',
    'between' => [
        'numeric' => ':attribute должен быть в пределах от :min до :max.',
        'file' => ':attribute должен иметь размер от :min до :max КБ.',
        'string' => ':attribute должен быть от :min до :max символов.',
        'array' => ':attribute должен иметь от :min до :max элементов.',
    ],
    'boolean' => ':attribute должен иметь булев тип.',
    'confirmed' => ':attribute не совпадает.',
    'date' => ':attribute не валидная дата.',
    'date_equals' => ':attribute должен быть равен :date.',
    'date_format' => ':attribute не совпадает по формату с :format.',
    'different' => ':attribute и :other должны отличаться.',
    'digits' => ':attribute должен состоять с :digits цифр.',
    'digits_between' => ':attribute должен иметь от :min до :max цифр.',
    'dimensions' => ':attribute имеет недопустимые размеры.',
    'distinct' => ':attribute является дупликатом.',
    'email' => ':attribute должен быть валидной почтой.',
    'ends_with' => ':attribute должен заканчиватся на: :values.',
    'exists' => 'Выбранный :attribute не валидный.',
    'file' => ':attribute должен быть файлом.',
    'filled' => ':attribute должен быть заполнен.',
    'gt' => [
        'numeric' => ':attribute должен быть больше чем :value.',
        'file' => ':attribute должен иметь размер больше чем :value КБ.',
        'string' => ':attribute должен содержать больше чем :value символов.',
        'array' => ':attribute должен иметь больше чем :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute должен быть больше или равен :value.',
        'file' => ':attribute должен иметь размер больше или равный :value КБ.',
        'string' => ':attribute должна содержать больше или ровно :value символов.',
        'array' => ':attribute должен содержать :value или более элементов.',
    ],
    'image' => ':attribute должен быть картинкой.',
    'in' => 'Выбранное значение :attribute не валидно.',
    'in_array' => ':attribute не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть IP адресом.',
    'ipv4' => ':attribute должен быть IPv4 адресом.',
    'ipv6' => ':attribute должен быть IPv6 адресом.',
    'json' => ':attribute должен быть валидной JSON строкой.',
    'lt' => [
        'numeric' => ':attribute должен быть меньше чем :value.',
        'file' => ':attribute должен иметь размер меньше чем :value КБ.',
        'string' => ':attribute должен содержать менне :value символов.',
        'array' => ':attribute должен содержать менее :value элементов.',
    ],
    'lte' => [
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'file' => ':attribute должен иметь размер меньше или равный :value КБ.',
        'string' => ':attribute должен содержать :value или меньше символов.',
        'array' => ':attribute должен содержать :value или меньше элементов.',
    ],
    'max' => [
        'numeric' => ':attribute должен не быть больше :max.',
        'file' => ':attribute должен иметь размер не больше :max КБ.',
        'string' => ':attribute должна иметь не больше :max символов.',
        'array' => ':attribute должен иметь не более :max элементов.',
    ],
    'mimes' => ':attribute должен иметь тип: :values.',
    'mimetypes' => ':attribute должен иметь тип: :values.',
    'min' => [
        'numeric' => ':attribute должен не быть менее :min.',
        'file' => ':attribute должен иметь размер не менее :min КБ.',
        'string' => ':attribute должна иметь не менее :min символов.',
        'array' => ':attribute должен иметь не менее :min элементов.',
    ],
    'multiple_of' => ':attribute должен что-то) :value',
    'not_in' => 'Выбранное значение поля :attribute не валидно.',
    'not_regex' => ':attribute формат не валидный.',
    'numeric' => ':attribute должен быть числом.',
    'password' => 'Пароль неверный.',
    'present' => ':attribute должно быть.',
    'regex' => ':attribute формат неверен.',
    'required' => ':attribute обязательное поле.',
    'required_if' => ':attribute обязательно когда :other равен :value.',
    'required_unless' => ':attribute обязательно когда :other не равен :values.',
    'required_with' => ':attribute обязателен когда :values существуют.',
    'required_with_all' => ':attribute обязательно когда поля :values сушествуют.',
    'required_without' => ':attribute обязательно когда :values не существует.',
    'required_without_all' => ':attribute обязательно когда :values не существует.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'numeric' => ':attribute должен содержать :size цифр.',
        'file' => ':attribute должен быть равен :size КБ.',
        'string' => ':attribute должен иметь :size символов.',
        'array' => ':attribute должен содержать :size элементов.',
    ],
    'starts_with' => ':attribute должен начинаться с: :values.',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть временной зоной.',
    'unique' => ':attribute уже занят.',
    'uploaded' => ':attribute не загружен.',
    'url' => ':attribute формат неверен.',
    'uuid' => ':attribute должен быть UUID.',

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
