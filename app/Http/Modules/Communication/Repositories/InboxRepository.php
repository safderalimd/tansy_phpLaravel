<?php

namespace App\Http\Modules\Communication\Repositories;

use App\Http\Repositories\Repository;

class InboxRepository extends Repository
{
    // public function getModelById($id)
    // {
    //     return $this->select(
    //         'SELECT
    //             product AS product_name,
    //             product_type,
    //             unit_rate,
    //             product_type_entity_id,
    //             product_entity_id,
    //             active
    //          FROM view_prd_lkp_product
    //          WHERE product_entity_id = :id
    //          LIMIT 1;', ['id' => $id]
    //     );
    // }

    /**
     * Get messages, also search in messages
     */
    public function messages($model)
    {
        $procedure = 'sproc_cmu_grid_inbox';

        $iparams = [
            ':iparam_page_number',
            '-iparam_search_text',
            ':iparam_session_id',
            ':iparam_user_id',
            ':iparam_screen_id',
            ':iparam_debug_sproc',
            ':iparam_audit_screen_visit',
        ];

        $oparams = [
            '@oparam_total_rows',
            '@oparam_err_flag',
            '@oparam_err_step',
            '@oparam_err_msg',
        ];

        // $data = $this->procedure($model, $procedure, $iparams, $oparams);
        // return first_resultset($data);

        return [
            [
                "email_id" => 1,
                "sender_name" => "Mr Sysadmin",
                "email_send_datetime" => "2016-07-29 22:28:44",
                "email_subject" => "Test Email 101",
                "email_text" => " Hello!!!",
                "email_read_flag" => 0,
            ]
        ];
    }
}
