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

    'accepted' => 'El :attribute tiene que se aceptado.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute tiene que ser una fecha después de :date.',
    'after_or_equal' => 'El :attribute tiene que ser después o igual a :date.',
    'alpha' => 'El :attribute podría solo contener letras.',
    'alpha_dash' => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute solo puede contener letras y números.',
    'array' => 'El :attribute debe ser un array.',
    'before' => 'El :attribute debe ser una fecha antes :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute tiene que estar entre :min y :max.',
        'file' => 'El :attribute tiene que estar entre :min and :max kilobytes.',
        'string' => 'El :attribute tiene que estar entre :min and :max carácteres.',
        'array' => 'El :attribute tiene que tener :min and :max elementos.',
    ],
    'boolean' => 'El :attribute campo debe ser verdadero o falso.',
    'confirmed' => 'El :attribute de confirmación no coincide.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser igual a  :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'different' => 'El :attribute y :other tienen que ser distintos.',
    'digits' => 'El :attribute tiene que ser :digits dígitos.',
    'digits_between' => 'El :attribute tiene que estar entre :min and :max dígitos.',
    'dimensions' => 'El :attribute posee dimensiones de imagen inválidas.',
    'distinct' => 'El :attribute field has a duplicate value.',
    'email' => 'El :attribute debe ser un correo válido.',
    'ends_with' => 'El :attribute debe terminar con lo siguiente: :values.',
    'exists' => 'El seleccionado :attribute es inválido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'file' => 'El :attribute debe ser mayor que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor que :value carácteres.',
        'array' => 'El :attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser mayor que o igual :value.',
        'file' => 'El :attribute debe ser mayor que o igual :value kilobytes.',
        'string' => 'El :attribute debe ser mayor que o igual :value carácteres.',
        'array' => 'El :attribute debe tener :value elementos o más.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El selected :attribute es inválido.',
    'in_array' => 'El :attribute campo no existe en :other.',
    'integer' => 'El :attribute debe ser un entero.',
    'ip' => 'El :attribute debe ser a dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser una dirección cadena JSON.',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor que :value.',
        'file' => 'El :attribute debe ser menor que :value kilobytes.',
        'string' => 'El :attribute debe ser menor que :value carácteres.',
        'array' => 'El :attribute debe tener menor que :value elementos.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor que o igual :value.',
        'file' => 'El :attribute debe ser menor que o igual :value kilobytes.',
        'string' => 'El :attribute debe ser menor que o igual :value carácteres.',
        'array' => 'El :attribute must not have more than :value elementos.',
    ],
    'max' => [
        'numeric' => 'El :attribute no puede ser mayor que than :max.',
        'file' => 'El :attribute no puede ser mayor que than :max kilobytes.',
        'string' => 'El :attribute no puede ser mayor que than :max carácteres.',
        'array' => 'El :attribute podría no tener más de :max elementos.',
    ],
    'mimes' => 'El :attribute debe ser un archivo of type: :values.',
    'mimetypes' => 'El :attribute debe ser un archivo of type: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file' => 'El :attribute debe ser al menos :min kilobytes.',
        'string' => 'El :attribute debe ser al menos :min carácteres.',
        'array' => 'El :attribute debe tener al menos :min elementos.',
    ],
    'not_in' => 'El selected :attribute es inválido.',
    'not_regex' => 'El :attribute format es inválido.',
    'numeric' => 'El :attribute debe ser un número.',
    'password' => 'El password es incorrecto.',
    'presente' => 'El :attribute field debe ser presente.',
    'regex' => 'El :attribute format es inválido.',
    'required' => 'El :attribute es un campo requerido.',
    'required_if' => 'El :attribute field es requerido cuando :other es :value.',
    'required_unless' => 'El :attribute es un campo requerido excepto :other es en :values.',
    'required_with' => 'El :attribute field es requerido cuando :values es present.',
    'required_with_all' => 'El :attribute field es requerido cuando :values son presente.',
    'required_without' => 'El :attribute field es requerido cuando :values es not presente.',
    'required_without_all' => 'El :attribute field es requerido cuando ninguno of :values son presentes.',
    'same' => 'El :attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El :attribute debe ser :size.',
        'file' => 'El :attribute debe ser :size kilobytes.',
        'string' => 'El :attribute debe ser :size carácteres.',
        'array' => 'El :attribute debe contener :size elementos.',
    ],
    'starts_with' => 'El :attribute debe iniciar con lo siguiente: :values.',
    'string' => 'El :attribute debe ser un string.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => 'El :attribute ya ha sido tomado.',
    'uploaded' => 'El :attribute falló en la subida.',
    'url' => 'El formato :attribute es inválido.',
    'uuid' => 'El :attribute debe ser un UUID válido.',

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

    'attributes' => [
        'E-Mail Address'=> 'Correo',
        'Password' => 'Contraseña',
        'Login' => 'Iniciar sesión',
        'Remember Me' => 'Recuerdame',
        'Forgot Your Password?'=> '¿Olvidaste la contraseña?'

    ],

];
