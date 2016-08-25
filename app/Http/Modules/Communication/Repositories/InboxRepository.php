<?php

namespace App\Http\Modules\Communication\Repositories;

use App\Http\Repositories\Repository;

class InboxRepository extends Repository
{
    public function contacts($model)
    {
        $procedure = 'sproc_cmu_lkp_sender_list';
        $data = $this->procedure($model, $procedure, [], []);
        return first_resultset($data);
    }

    public function userCanSendMessage($model)
    {
        $procedure = 'sproc_cmu_get_compose_permission';

        $iparams = [
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_compose_email_flag',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function deleteMessage($model)
    {
        $procedure = 'sproc_cmu_dml_email_delete';

        $iparams = [
            '-iparam_email_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    /**
     * Both reply and send new message
     */
    public function sendMessage($model)
    {
        $procedure = 'sproc_cmu_dml_email_send_new';

        $iparams = [
            ':iparam_parent_email_id',
            '-iparam_email_subject',
            '-iparam_email_text',
            '-iparam_send_to_entity_id_list',
            '-iparam_cc_to_entity_id_list',
            '-iparam_bcc_to_entity_id_list',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    public function messageDetail($model)
    {
        $procedure = 'sproc_cmu_lst_email_display';

        $iparams = [
            ':iparam_email_id',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }

    /**
     * Get messages, also search in messages
     */
    public function messages($model)
    {
        $procedure = 'sproc_cmu_grid_inbox';

        $iparams = [
            ':iparam_start_row_number',
            '-iparam_search_text',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_lazy_load_batch_size',
            '@oparam_show_lazy_load_search',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        $data = $this->procedure($model, $procedure, $iparams, $oparams);
        return first_resultset($data);
    }
}
