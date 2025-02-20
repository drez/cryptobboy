<?php

namespace App;


/**
 * Skeleton subclass for representing a service for the ImportForm entity.
 *
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    GoatCheese.
 */
class ImportFormWrapper extends ImportForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     * @param array $data
     * @param Import $dataObj
     * @return void
    **/

    public function afterFormObj( array $data, Import &$dataObj){
         $this->hookFormReadyJs = "
            $('.sw-header .default-controls').append( $('<a>').html('Import').addClass('button-link-blue header-controls').attr('href', 'Javascript:;').attr('id', 'import') );

            $('#import').click(()=>{
                sw_message('Synchronizing...', false, 'sync_load', true);
                $.post('" . _SITE_URL . $this->virtualClassName . "/import/'+$('#formImport #idPk').val(), {ui:'list'}, (data)=>{
                    $('#editPopupDialog').html(data);
                    $('#editPopupDialog').dialog('open');
                    sw_message(true, false, 'sync_load');
                });
            });
        ";
    }
}
