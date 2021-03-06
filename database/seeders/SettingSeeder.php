<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // groupe app_name
        $this->createNew("app_name", null, "Gestion-Cheques", "string", ",", "Application Name.");
        // groupe roles
        $group = $this->createNew("roles", null, null, "string", ",", "settings Roles.");
        $this->createNew("default", $group->id, "1", "integer", ",", "Role par défaut à la création d un utilisateur dont le role n est pas explicitement déterminé.");
        // groupe files
        $group = $this->createNew("files", null, null, null, ",", "settings Files.");
        // sub groupe files.uploads
        $group = $this->createNew("uploads", $group->id, null, null, ",", "Uploads.");
        // sub groupe files.uploads.max_size
        $group = $this->createNew("max_size", $group->id, null, null, ",", "Max Size.");
        $this->createNew("any", $group->id, "10", "integer", ",", "Any file Max size.");
        $this->createNew("image", $group->id, "5", "integer", ",", "Image file Max size.");
        $this->createNew("video", $group->id, "10", "integer", ",", "Video file Max size.");

        // groupe ldap
        $group = $this->createNew("ldap", null, null, "string", ",", "settings LDAP.");
        // value ldap.liste_sigles
        $this->createNew("liste_sigles", $group->id, "gt,rh,si,it,sav,in,bss,msan,rva,erp,dr", "array", ",", "liste des sigles (à prendre en compte dans l importation LDAP).");

        // groupe workflowstep
        $workflowstep_group = $this->createNew("workflowstep", null, null, "string", ",", "workflowstep settings.");
        // sub group workflowstep.roledynamic
        $group = $this->createNew("roledynamic", $workflowstep_group->id, null, null, ",", "role_dynamic .");
        $this->createNew("default_label", $group->id, "Agence", "string", ",", "Role Dynamic Default Label.");
        $this->createNew("default_previous_label", $group->id, "Agence Précédente", "string", ",", "Role Dynamic Default Previous Label.");
        // sub group workflowstep.canexpire
        $group = $this->createNew("canexpire", $workflowstep_group->id, null, null, ",", "can expire .");
        $this->createNew("default_hours", $group->id, 0, "integer", ",", "Can expire Default Hours.");
        $this->createNew("default_days", $group->id, 2, "integer", ",", "Can expire Default Days.");

        // groupe workflowexec
        $workflowexec_group = $this->createNew("workflowexec", null, null, "string", ",", "workflowexec settings.");
        $this->createNew("unrequired_failed_action_can_pass", $workflowexec_group->id, "false", "boolean", ",", "Start node Default Width.");

        // group flowchart
        $flowchart_group = $this->createNew("flowchart", null, null, "string", ",", "flowchart settings.");
        // sub group flowchart.startnode
        $group = $this->createNew("startnode", $flowchart_group->id, null, null, ",", "Start node.");
        $this->createNew("default_width", $group->id, "100", "integer", ",", "Start node Default Width.");
        $this->createNew("default_height", $group->id, "40", "integer", ",", "Start node Default Height.");
        $this->createNew("default_x", $group->id, "10", "integer", ",", "Start node Default positon x.");
        $this->createNew("default_y", $group->id, "20", "integer", ",", "Start node Default position y.");
        $this->createNew("default_name", $group->id, "Début Traitement", "string", ",", "Start node Default Name.");
        $this->createNew("default_description", $group->id, "Etape marquant le début du Workflow", "string", ",", "Start node Default Description.");

        // sub group flowchart.endnode notification_interval
        $group = $this->createNew("endnode", $flowchart_group->id, null, null, ",", "End node.");
        $this->createNew("default_width", $group->id, "100", "integer", ",", "End node Default Width.");
        $this->createNew("default_height", $group->id, "40", "integer", ",", "End node Default Height.");
        $this->createNew("default_x", $group->id, "640", "integer", ",", "End node Default positon x.");
        $this->createNew("default_y", $group->id, "420", "integer", ",", "End node Default position y.");
        $this->createNew("default_name", $group->id, "Fin Traitement", "string", ",", "End node Default Name.");
        $this->createNew("default_description", $group->id, "Etape marquant la fin du Workflow", "string", ",", "End node Default Description.");

        // group reminder
        $reminder_group = $this->createNew("reminder", null, null, "string", ",", "reminder settings.");
        // sub group reminder.notification
        $group = $this->createNew("notification", $reminder_group->id, null, null, ",", "notification");
        $this->createNew("default_interval", $group->id, "8", "integer", ",", "Default interval between notifications.");
    }

    private function createNew($name, $group_id = null, $value = null, $type = null, $array_sep = ",", $description = null)
    {
        $data = ['name' => $name, 'array_sep' => $array_sep];
        if (!is_null($group_id)) {
            $data['group_id'] = $group_id;
        }
        if (!is_null($value)) {
            $data['value'] = $value;
        }
        if (!is_null($type)) {
            $data['type'] = $type;
        }
        if (!is_null($description)) {
            $data['description'] = $description;
        }
        return Setting::create($data);
    }
}
