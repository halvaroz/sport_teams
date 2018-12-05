<?php
namespace Calendar;

require '../src/Calendar/Validator.php';

use App\Validator;

class EventValidator extends Validator {

    /**
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {
        parent::validates($data);
        $this->validate('teamId', 'selectChosen');
        $this->validate('teams', 'minLength', 3);
        $this->validate('date', 'date');
        $this->validate('start', 'beforeTime', 'end');
        return $this->errors;
    }

}
