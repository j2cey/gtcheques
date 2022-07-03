<?php

namespace App\Http\Requests\ReminderCriterion;

use App\Models\ReminderCriterion;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReminderCriterionRequest extends ReminderCriterionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ReminderCriterion::updateRules($this->remindercriterion);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->reminder = $this->setReminderFromId($this->input('reminder_id'));
        $this->merge([
            'reminder' => $this->reminder,
            'is_start_criterion' => $this->setCheckOrOptionValue($this->is_start_criterion),
            'is_stop_criterion' => $this->setCheckOrOptionValue($this->is_stop_criterion),
            'criteriontype' => $this->setRelevantReminderCriterionType($this->criteriontype, true),
            'modelattribute' => $this->setRelevantModelAttribute($this->modelattribute, true),
        ]);
    }
}
