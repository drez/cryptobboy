<?php

namespace App;

/**
 * Skeleton subclass for representing a services for the TemplateForm entity.
 *
 * User
 *
 * You should add additional methods/hooks to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.GoatCheese.
 */
class TemplateFormWrapper extends TemplateForm
{
    public function __construct($request, $args)
    {
        parent::__construct($request, $args);
    }

    /**
     * Hook form after the data getter
     *
     * @param AuthyForm $obj
     * @param array $data
     * @param Template $dataObj
     * @return void
     */
    public function afterFormObj(array $data, Template &$dataObj)
    {
        $this->hookFormReadyJs = "
        $('" . addslashes(button(span("View variables"), "id='viewVarNg' class='ac-button ac-light-red' style='    border-left: 1px solid #008bc5;'")) . "').insertAfter( $('.default-controls') );
        $('#viewVarNg').click(function (){
            $.get('" . _SITE_URL . "Template/viewVar', {'ui':'editDialog'}, function (data){
                $('#editDialog').html(data);
                $('#editDialog').dialog({modal : false}).dialog('open');
            }); 
        });
        ";
    }

    public function startChildListRowTemplateFile(&$altValue, $data, $i, $param, $Template, $hookListColumnsTemplateFile, $actionRow)
    {
        $altValue['File'] = div(href(img(_SITE_URL . 'public/img/remix/input-cursor-move.svg'), "Javascript:;", "title='Insert image at cursor' j='insertToCursor' f='" . _SITE_URL . $data->getFile() . "'"), '', "style='position: absolute;top: -1px;'")
            . div($data->getFile(), '', "style='margin-left:35px;'");
    }
    public function beforeChildListTemplateFile($q, $filterKey, $param)
    {
        $this->hookListReadyJsFirstTemplateFile .= "
            $('[j=insertToCursor]').click(function (e){
                var fileUrl = $(this).attr('f');
                var currentInstance = null;
                for ( var i in CKEDITOR.instances ){
                    if(CKEDITOR.instances[i].focusManager.hasFocus){
                        var currentInstance = i;
                        break;
                    }
                }
                if(currentInstance){
                    CKEDITOR.instances[currentInstance].insertHtml(\"<img src='\"+fileUrl+\"'>\");
                }else{
                    alertb('Warning', 'Put the cursor where you want to insert the image.');
                }
                return false;
            });
        ";
    }
    public function afterList(&$request, &$pmpoData){}
    public function beforeListTr(&$altValue, $data, $i, $param, &$hookListColumns){}
    public function beforeListSearch(&$q, &$search){}
    public function afterListSearch(&$q, &$search){}
    public function beforeChildSearchTemplateFile(&$q){}
    public function beginSelectbox(&$pcDataO, &$q){}
}
