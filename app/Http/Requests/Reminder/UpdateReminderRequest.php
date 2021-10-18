<?php

namespace App\Http\Requests\Reminder;

use App\Models\Reminder;

class UpdateReminderRequest extends ReminderRequest
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
        return Reminder::updateRules($this->reminder);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'reminder' => $this->has('reminder') ? $this->setRelevantReminder($this->input('reminder'), true) : null,
            'title' => $this->has('title') ? $this->title : $this->input('reminder_title'),
            'modeltype' => $this->setRelevantModelType($this->has('modeltype') ? $this->modeltype : $this->input('reminder_modeltype'), true),
            'status' => $this->setRelevantStatusByCode($this->has('status') ? $this->status : $this->input('reminder_status'), true),
        ]);
    }
}
