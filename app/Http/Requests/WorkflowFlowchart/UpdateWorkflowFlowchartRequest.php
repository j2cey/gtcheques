<?php

namespace App\Http\Requests\WorkflowFlowchart;



class UpdateWorkflowFlowchartRequest extends WorkflowFlowchartRequest
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
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            //'nodes' => $this->decodeJsonField($this->input('nodes')),
            //'connections' => $this->decodeJsonField($this->input('connections')),
        ]);
    }
}
