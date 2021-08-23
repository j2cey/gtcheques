<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use App\Rules\StepCanExpire;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CleanRequestTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\WorkflowStep\CreateWorkflowStepRequest;
use App\Http\Requests\WorkflowStep\UpdateWorkflowStepRequest;

class WorkflowStepController extends Controller
{
    use CleanRequestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowStep[]|Collection
     */
    public function index()
    {
        $workflowsteps = WorkflowStep::orderBy('posi','ASC')->get();
        $workflowsteps->load(['approvers','actions']);

        return $workflowsteps;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWorkflowStepRequest $request
     * @return WorkflowStep
     */
    public function store(CreateWorkflowStepRequest $request)
    {
        /*$request->validate([
            'expire_hours' => [ new StepCanExpire($request->can_expire,$request->expire_hours,$request->expire_days) ],
            'expire_days' => [ new StepCanExpire($request->can_expire,$request->expire_hours,$request->expire_days) ],
        ]);*/
        $user = auth()->user();

        $formInput = $request->all();

        $workflow = Workflow::where('id', $formInput['workflow_id'])->first();
        //$titre, $description, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null
        $new_workflowstep = WorkflowStep::createNew($formInput['titre'], $formInput['description'], $workflow, null, $formInput['transitionpassstep'], $formInput['transitionrejectstep'])
            ->setApproversStatic($formInput['role_static'],$formInput['approvers'],true)
            ->setProfileDynamic($formInput['role_dynamic'], $formInput['role_dynamic_label'], $formInput['role_dynamic_previous_label'],true)
            ->setProfilePrevious($formInput['role_previous'],true)
            //->setExpiration($formInput['can_expire'], $formInput['transitionexpirestep'], "", "", $formInput['expire_hours'], $formInput['expire_days'],true)
            ->setNotifyToProfile($formInput['notify_to_approvers'], true)
            ->setNotifyToOthers($formInput['notify_to_others'], $formInput['otherstonotify'], true)
            ->setStepParent($formInput['stepparent'], true)
        ;

        return $this->returnStepLoaded($new_workflowstep);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function show(WorkflowStep $workflowstep)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function edit(WorkflowStep $workflowstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkflowStepRequest $request
     * @param WorkflowStep $workflowstep
     * @return WorkflowStep|WorkflowStep[]|Collection
     */
    public function update(UpdateWorkflowStepRequest $request, WorkflowStep $workflowstep)
    {
        $user = auth()->user();

        $formInput = $request->all();

        if ($request->has('oldIndex') && $request->has('newIndex')) {
            // Déplacement de l'étape
            $this->reorder($workflowstep, $formInput['oldIndex'], $formInput['newIndex']);
            $workflowsteps = WorkflowStep::where('workflow_id',$formInput['workflow_id'])->orderBy('posi','ASC')->get();
            return $workflowsteps->load(['actions','approvers']);
        } else {
            // Modification simple

            $workflowstep->update([
                'titre' => $formInput['titre'],
                'description' => $formInput['description'],
                'workflow_id' => $formInput['workflow_id'],
            ]);

            $workflowstep->setApproversStatic($formInput['role_static'],$formInput['approvers'],true)
                ->setProfileDynamic($formInput['role_dynamic'], $formInput['role_dynamic_label'], $formInput['role_dynamic_previous_label'],true)
                ->setProfilePrevious($formInput['role_previous'],true)
                //->setExpiration($formInput['can_expire'], $formInput['transitionexpirestep'], $formInput['expire_hours'], $formInput['expire_days'],true)
                ->setNotifyToProfile($formInput['notify_to_approvers'], true)
                ->setNotifyToOthers($formInput['notify_to_others'], $formInput['otherstonotify'], true)
                ->setStepParent($formInput['stepparent'], true)
            ;

            return $this->returnStepLoaded($workflowstep);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowStep $workflowstep
     * @return Response
     */
    public function destroy(WorkflowStep $workflowstep)
    {
        //TODO: Supprimer l'étape de Workflow
    }

    public function reorder(WorkflowStep $workflowstep, $oldIndex, $newIndex) {
        if ( ($newIndex - $oldIndex) < 0) {
            DB::table('workflow_steps')
                ->where('workflow_id', $workflowstep->workflow_id)
                ->where('posi', '>=', $newIndex)
                ->where('posi', '<=', $oldIndex)
                ->increment('posi', 1);
        } else {
            DB::table('workflow_steps')
                ->where('workflow_id', $workflowstep->workflow_id)
                ->where('posi', '>=', $oldIndex)
                ->where('posi', '<=', $newIndex)
                ->decrement('posi', 1);
        }
        $workflowstep->update([
            'posi' => $newIndex,
        ]);
    }

    public function fetchbyworkflow($id) {
        if ($id == 0) {
            return WorkflowStep::all();
        } else {
            $steps = WorkflowStep::where('workflow_id', $id)->orWhere('code', "step_end")
                ->orderBy('id', 'desc')
                ->get();
            return $steps;
        }
    }

    private function returnStepLoaded(WorkflowStep $step) {
        return $step->load([
            'actions',
            'approvers',
            'stepparent',
            'actionspass',
            'actionsreject',
            'actionsexpire',
            'otherstonotify',
            'transitionpassstep',
            'transitionrejectstep',
            'transitionexpirestep'
        ]);
    }
}
