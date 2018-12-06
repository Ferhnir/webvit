<?php
namespace App\Validations;
use Respect\Validation\Validatior as Respect;
use Respect\Validation\Exceptions\AllOfException as Exception;
class Validator
{
    protected $errors;
    public function validate($request, array $rules)
    {

        // if($request->getParam('new_password') !== $request->)
        // {
        //     $this->errors['no_match'] = "Passwords doesn't match";
        // }

        foreach($rules as $field => $rule)
        {
            try {
                
                $rule->setName(ucfirst(str_replace('new_', '', $field)))->assert($request->getParam($field));
            
            } catch (Exception $e) {
                
                $this->errors['passwords'] = $e->findMessages([
                    'equals' => "Passwords doesn't match"
                ]);
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