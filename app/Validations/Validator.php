<?php
namespace App\Validations;
use Respect\Validation\Validatior as Respect;
use Respect\Validation\Exceptions\AllOfException as Exception;
class Validator
{
    protected $errors;
    public function validate($request, array $rules)
    {
        foreach($rules as $field => $rule)
        {
            try {
                
                $rule->setName(ucfirst(str_replace(['re_new_','new_'], "", $field)))->assert($request->getParam($field));
            
            } catch (Exception $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;
        
        return $this;
    }
    public function failed()
    {
        return !empty($this->errors);
    }
}