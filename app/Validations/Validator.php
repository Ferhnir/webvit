<?php

namespace App\Validations;

use Respect\Validation\Validatior as Respect;
use Respect\Validation\Exceptions\AllOfException as Exception;

class Validator
{

    protected $errors;

    public function validate($request, array $rules)
    {

        // var_dump($rules);
        // die();

        foreach($rules as $field => $rule)
        {
            try {
                
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            
            } catch (Exception $e) {

                $this->errors[$field] = $e->getMessages();

            }
        }

        $_SESSION['errors'] = $this->errors;

        // var_dump($this->errors);
        // die();

        return $this;

    }

    public function failed()
    {
        return !empty($this->errors);

    }

}