<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Message' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class MessageForm extends Message
{

    use Helper;
    use \ApiGoat\ACL\AuthyACL;

    /**
    *   Virtual name of the object (class)
    */
    public $request = null;
    public $args = null;
    public $model_name = '';
    public $isChild;
    public $IdPk;
    public $in;
    public $TableName;
    public $tableDescription;
    public $uiTabsId;
    public $maxPerPage;
    public $childMaxPerPage;
    public $VirtualClassName;
    public $virtualClassName;
    public $listActionCell = '';

    public $setReadOnly;
    public $forceInlineEdit;
    public $forcePopUpEdit;
    public $arrayData;

    public $searchAr;
    public $searchMs;
    public $searchOrder;

    public $hookFormTop;
    public $hookFormInnerTop;
    public $hookFormBottom;
    public $hookFormInnerBottom;

    public $hookFormReadyJsFirst;
    public $hookFormReadyJs;
    public $hookFormIncludeJs;

    public $hookFormRoTop;
    public $hookFormRoBottom;

    public $hookChildListRoTop;
    public $hookChildListRoBottom;

    public $hookListTop;
    public $hookListBottom;
    public $hookListColumns;
    public $hookListSearchTop;
    public $hookListSearchButton;
    public $hookListReadyJs;
    public $hookListReadyJsFirst;
    public $setListRemoveDelete;
    public $hookSwHeader;
    public $printLink;
    public $formTitle;
    public $ccStdFormOptions;
    public $cCMainTableHeader;
    public $cCmoreColsHeader;
    public $hookLogin;

    public $canDelete;


    
    /**
    *   Ressource object for the database
    *   @type object
    **/
    public $pmpoData;

    /**
     * Constructor
     *
     * @param Request|array|null $request
     * @param array $args
     */
    function __construct(Request|array|null $request, array $args)
    {
        $this->request = $request;
        $this->args = $args;
        $this->model_name = 'Message';
        $this->virtualClassName = 'Message';
        $this->childMaxPerPage = (defined('app_child_max_per_page')) ? app_child_max_per_page : 30;
        $this->maxPerPage = (defined('app_max_per_page')) ? app_max_per_page : 50;
        $this->hookFormBottom = '';
        $this->hookFormReadyJs = '';
        
    }

    /**
     * function getListSearch
     * @param integer $IdParent
     * @param array $search
     * @return type
     */
    public function getListSearch($IdParent='', $search='')
    {
        $this->in = 'getListSearch';

        $q = new MessageQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                ;

        if( isset($this->searchMs['Label']) ) {
            $criteria = \Criteria::LIKE;


            $value = $this->setCriteria($this->searchMs['Label'], $criteria);

            $q->filterByLabel($value, $criteria);
        }
                
        }else{
            
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                ;
                
            }
        }

        
            if(!empty($this->searchOrder)){
                $f=0;
                foreach($this->searchOrder as $order){
                    foreach($order as $col => $sens){
                        if($sens){
                            $tOrd = explode('.',$col);
                            if($tOrd[1]){
                                $q->join($tOrd[0]." order".$f);
                                $orderBy = "use".$tOrd[0]."Query";
                                $q->$orderBy("order".$f, 'left join')->orderBy($tOrd[1], $sens)->endUse();
                            }else{
                                $q->orderBy($col,$sens);
                            }
                            $this->orderReadyJsOrder .="
                                $(\"#MessageListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
                                    .attr('order', 'on').addClass('sorted');
                            ";
                        }
                        $f++;
                    }
                }
            }
            
        
        

        $this->pmpoData = $q;
        

        return $this->pmpoData;
    }

    /**
     * function getListHeader
     * @param string $act
     * @return string
     */
    public function getListHeader($act)
    {
        $this->in = 'getListHeader';
        $trSearch = '';
        $trHeadMod = '';

        switch($act) {
            case 'head':
                $trHead = th(_("Label"), " th='sorted' c='Label' title='" . _('Label')."' ")
.th(_("Texte en_US"), " th='sorted' c='MessageI18n_Text_en_US' title='" . _('Texte en_US')."' ")
. $this->cCmoreColsHeader;
                if(!$this->setReadOnly){
                    $trHead .= th('&nbsp;',' class="actionrow delete" ');
                }
                $trHead = thead(tr($trHead));
                return $trHead;

            case 'list-button':
                $listButton = '';
                
                
                return $listButton;

            case 'search':
                
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(input('text', 'Label', $this->searchMs['Label'], '  title="'._('Label').'" placeholder="'._('Label').'"',''),'','class="ac-search-item"').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msMessageBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msMessageBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsMessage'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('Message', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addMessage' title='"._('Add')."' class='button-link-blue add-button'");
            }

            return $this->listAddButton;
            break;
            case 'quickadd':
                return $trHeadMod;
        }
    }

    /**
     * produce a list of table items
     * @param	string $uiTabsId	html destination container Id
     * @param	string $page		nbr. of line per pages
     * param	string $IdParent	Parent id (if necessary)
     * param	obj $pmpoDataIn	PropelModelPager reference to show instead of default search OR a standard propel collection
     * @param	array $search		search params for custom search query
     * 						[ms]	pre set with progXform/search_items behavior
     *					custom search
     *						[f]	filter	[v]	value	use by progXform/child_menu_query
     *						[u]	use		[f]	filter	[uv] use filter value
     * @return string
     */
    public function getList( $request, $uiTabsId = 'tabsContain', $IdParent = null , $pmpoDataIn = null)
    {
        $HelpDivJs = '';
        $HelpDiv = '';
        $this->in = 'getList';
        $this->isChild = '';
        $this->TableName = 'Message';
        $altValue = array (
  'IdMessage' => '',
  'Label' => '',
  'MessageI18n_Text_en_US' => '',
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Message/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Message/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Message/');

        
        
        
        
        
        

        $maxPerPage = $this->maxPerPage;

        if(empty($pmpoDataIn)) {
            $pmpoData = $this->getListSearch($IdParent, $search);
            $pmpoData = $pmpoData->paginate($search['page'], $maxPerPage);
            $resultsCount = $pmpoData->getNbResults();

        }else{
            $pmpoData = $pmpoDataIn;
        }

        $trHead = $this->getListHeader('head');

        if( $pmpoData->isEmpty() ) {
            $tr .= tr(	td(p(span(_("Nothing here at the moment")),'class="no-results"'), "t='empty' colspan='100%' "));

        }else{
            if( get_class($pmpoData) == 'PropelModelPager' ) {
                $pcData = $pmpoData->getResults();
            }else{
                $pcData = $pmpoData;
            }

            $this->arrayData = $pcData->toArray();

            /**
            *	Main list loop
            **/
            $i=0;
            
            if(!$this->setReadOnly && !$this->setListRemoveDelete){
                if($_SESSION[_AUTH_VAR]->hasRights('Message', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteMessage' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                

try{
    $data->getTranslation('en_US');
}catch (Exception $e){
    $mt = new MessageI18n();
    $mt->setLocale('en_US')->setText('');
    $data->addMessageI18n($mt)->save();
}
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Label']) ? $altValue['Label'] : $data->getLabel()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Label' class=''  j='editMessage'") . 
                td(span((($altValue['MessageI18n_Text_en_US']) ? $altValue['MessageI18n_Text_en_US'] : $data->getTranslation('en_US')->getText()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='MessageI18n_Text_en_US' class=''  j='editMessage'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='MessageRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountMessage', $i);
        }

        

        ## @Paging
        $pagerRow = $this->getPager($pmpoData, $resultsCount, $search);
        $bottomRow = div($pagerRow,'bottomPagerRow', "class='tablesorter'");

        

        $controlsContent = $this->getListHeader('list-button');

        $return['html'] =
            $this->hookListTop
            .div(
                href(span(_('Open/close menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                .$this->getListHeader('add')
                
                .div($controlsContent,'MessageControlsList', "class='custom-controls'")
                .$this->hookSwHeader.$HelpDiv
            ,'','class="sw-header"')

            .$this->getListHeader('search')
            /*.div(
                $this->getListHeader('add')
                .button('', 'class="scroll-top" type="button"')
            , '' ,'class="ac-list-form-header ac-show-scroll"')*/
            .div(
                input('hidden', 'rowCount', $i, "s='d'")
                .input('hidden', 'ip', $IdParent, "s='d'")
                 .div(
                     div(
                        table($trHead.$tr, "id='MessageTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'MessageListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#MessageListForm td[j='editMessage']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#MessageListForm [j='deleteMessage']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#MessagePager').bindPaging({
            tableName:'Message'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msMessageBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msMessageBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsMessage').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsMessage .js-select-label').SelectBox();
            $('#formMsMessage input[type=text]').first().focus();
            $('#formMsMessage input[type=text]').first().putCursorAtEnd();
            $('#msMessageBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsMessage').keydown(function(e) {
        if(e.which == 13) {
            $('#msMessageBt').click();
        }
    });

    $('#msMessageBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsMessage input[type=text]:first-of-type').focus().putCursorAtEnd();
                sw_message_remove('search-reset');
        });

        return false;
    });
        
        
        $('#tabsContain .js-select-label').SelectBox();
        ".$this->hookListReadyJsFirst.$editEvent."
       $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'".$this->virtualClassName."',
            destUi:'".$uiTabsId."'
        });

        if($('#addMessageAutoc').length > 0) {
            $('#addMessageAutoc').bind('click', function () {
                $.post('"._SITE_URL."GuiManager', {a:'ixmemautoc', p:'{$this->virtualClassName}',}, function(data) {
                    document.location = '"._SITE_URL.$this->virtualClassName."/edit/';
                });
            });
        }
        
        
        ".$this->orderReadyJsOrder."
        ".$this->hookListReadyJs;
        $return['js'] .= "";
        return $return;
    }
    /*
    *	Make sure default value are set before save
    */
    public function setCreateDefaultsMessage($data)
    {

        unset($data['IdMessage']);
        $e = new Message();
        
        
        $e->fromArray($data );

        #
        
        #
        
        return $e;
    }

    /*
    *	Make sure default value are set before save
    */
    public function setUpdateDefaultsMessage($data)
    {

        
        $e = MessageQuery::create()->findPk(json_decode($data['i']));
        
        
        $e->fromArray($data );

        
        
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Message
     * @param	string $id			PrimaryKey of the record to show
     * @param	string $uiTabsId	Present everywhere, javascript id of the html container
     * @param	string $data 		If present, will skip the query and show the data
     * @param	array $error			Error to display
     * @param	array $jsElement		container to append new event results
     * @param	array $jsElementType	container type to append new event results
     * @return	array standard html retrun array
    */

    public function getEditForm($id, $uiTabsId = 'tabsContain', $data=[], $error=[], $jsElement='', $jsElementType='')
    {
        $this->in = "getEditForm";

        $HelpDivJs = '';
        $HelpDiv = '';
        $childTable = [];
        $script_autoc_one = '';
        $ongletf = '';
        $mceInclude = '';
        $ip_save = '';
        $ip_save = '';
        $IdParent = 0;
        $editDialog = ( $data['dialog'] ) ? $data['dialog'] : 'editDialog';
        $uiTabsId = ( $uiTabsId === null ) ? 'tabsContain' : $uiTabsId;
        $jet = 'tr';

        $je = "MessageTable";

        if($jsElement)	{
            $je = $jsElement;
        }

        if($jsElementType)	{
            $jet = $jsElementType;
        }

        if($data['data']['ip']){
            $data['ip'] = $data['data']['ip'];
            $data['pc'] = $data['data']['pc'];
            $data['tp'] = $data['data']['tp'];
        }

        if($data['pc']) {
            switch($data['pc']){
                
            }
            $IdParent = $data['ip'];
        }

        if($error == ''){
            unset($error);
        }

        

        // save button and action
        $this->SaveButtonJs = "";
        if(($_SESSION[_AUTH_VAR]->hasRights('Message', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Message', 'w') and $id) || $this->setReadOnly) {
            $this->SaveButtonJs = "
            $('#form" . $this->virtualClassName . " #save" . $this->virtualClassName . "').bindSave({
                modelName: '" . $this->virtualClassName . "',
                destUi: '" . $uiTabsId . "',
                pc:'" . $data['pc'] . "',
                ip:'" . $IdParent . "',
                je:'" . $jsElement . "',
                jet:'" . $jsElementType . "',
                tp:'" . $data['tp'] . "',
                dialog:'" . $editDialog . "'
            });
        ";
        }else{
            $this->SaveButtonJs = "
                $('#formMessage #saveMessage').unbind('click.saveMessage');
                $('#formMessage #saveMessage').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Message', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addMessage' title='"._('Add')."' class='button-link-blue add-button'");
            $this->bindEditJs = "$('.sw-header #add" . $this->virtualClassName . "').bindEdit({
                modelName: '" . $this->virtualClassName . "',
                destUi: '" . $uiTabsId . "',
                pc:'" . $data['pc'] . "',
                ip:'" . $IdParent . "',
                je:'" . $jsElement . "',
                jet:'" . $jsElementType . "'
            });";
        }

        if($id && !$data['reload']) {
            

            $q = MessageQuery::create()
            
            ;
            


            $dataObj = $q->filterByIdMessage($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Message['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Message();
            $this->Message['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Message['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


try{
    $dataObj->getTranslation('en_US');
}catch (Exception $e){
    $mt = new MessageI18n();
    $mt->setLocale('en_US')->setText('');
    $dataObj->addMessageI18n($mt)->save();
}

        
        
        
        
        
        
        
$this->fields['Message']['Label']['html'] = stdFieldRow(_("Label"), input('text', 'Label', htmlentities($dataObj->getLabel()), "   placeholder='".str_replace("'","&#39;",_('Label'))."' size='35'  v='LABEL' s='d' class='req'  ")."", 'Label', "", $this->commentsLabel, $this->commentsLabel_css, '', ' ', 'no');
$this->fields['Message']['MessageI18n_Text_en_US']['html'] = stdFieldRow(_("Texte en_US"), textarea('MessageI18n_Text_en_US', htmlentities($dataObj->getTranslation('en_US')->getText()) ,"placeholder='".str_replace("'","&#39;",_('Texte en_US'))."' cols='35' v='MESSAGEI18N_TEXT_EN_US' s='d'  class=' ' style=''  spellcheck='false'"), 'MessageI18n_Text_en_US', "", $this->commentsMessageI18n_Text_en_US, $this->commentsMessageI18n_Text_en_US_css, '', ' ', 'no');


        $this->lockFormField(array(0=>'Label',), $dataObj);

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }

        
        $ongletf =
            div(
                ul(li(htmlLink(_('Message'),'#ogf_Message',' j="ogf" p="Message" class="ui-tabs-anchor" '))
                    .li(htmlLink(_('en_US'),'#ogf_MessageI18n_Text_en_US',' j="ogf" class="ui-tabs-anchor" p="Message" ')))
            ,'cntOngletMessage',' class="cntOnglet"')
        ;
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveMessage', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedMessage','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdMessage', $dataObj->getIdMessage(), " s='d' pk")
                            .$this->hookListSearchButton
                        ,"", " class='divtd' colspan='2' style='text-align:right;'"),""," class='divtr divbut' ");
        }
        
        

        //Form header
        $header_top = div(
                            div(href(span(_('Display/Hide menu')),'javascript:','class="toggle-menu button-link-blue trigger-menu"')
                        .$this->formAddButton,'','class="default-controls"')
                        .$this->printLink
                            .$this->hookSwHeader.$HelpDiv
                        , '', 'class="sw-header"');
        $header_top_onglet = $this->formTitle.$ongletf;

        /*if(!isMobile()) {
            $jqueryDatePicker = " $(\"#formMessage [j='date']\").attr('type', 'text');
            $(\"#formMessage [j='date']\").each(function(){
                $(this).datepicker({dateFormat: 'yy-mm-dd ',changeYear: true, changeMonth: true, yearRange: '1940:2040', showOtherMonths: true, selectOtherMonths: true});
            });";
        }*/

        // Form
        $return['html'] =
        $this->hookFormTop
        .$mceInclude
        .$header_top
        .form(

            div(
                div('Message', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
                    '<div id="ogf_Message">'.
$this->fields['Message']['Label']['html']
.'</div><div id="ogf_MessageI18n_Text_en_US"  class=" ui-tabs-panel">'
.$this->fields['Message']['MessageI18n_Text_en_US']['html'].'</div>'
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntMessage", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formMessage' class='mainForm formContent' ")
        .$this->hookFormBottom;


        

        if($id and $_SESSION['mem']['Message']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Message']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Message']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Message']['ixmemautocapp'];
            unset($_SESSION['mem']['Message']['ixmemautocapp']);
        }

        $return['data'] .= $data;
        $return['js'] .= $childTable['js']
        . script($this->hookFormIncludeJs) ."
        ";

        $return['onReadyJs'] =
        $this->hookFormReadyJsFirst.
        "
        
        ".$jqueryDatePicker."
        $('#ui-datepicker-div').css('font-size', '12px');
        ".$this->bindEditJs."
        ".$this->SaveButtonJs."
        $('.cntOnglet').parent().tabs();
        ".$childTable['onReadyJs']."
        ".$error['onReadyJs']."
        if($('#form" . $this->virtualClassName . "').inDialog()){
            $('.ui-dialog .sw-header').remove();
        }
        if($('#loader').css('display') == 'block') {
            $('#loader').hide();
        }
        ".$tabs_act."
        ".$this->hookFormReadyJs
        .$script_autoc_one
        .$HelpDivJs."

        setTimeout(function() {
            $(\"#formMessage [s='d'], #formMessage .js-select-label, #formMessage [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formMessage .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Message']['Label']['html'] = stdFieldRow(_("Label"), div( $dataObj->getLabel(), 'Label_label' , "class='readonly' s='d'")
                .input('hidden', 'Label', $dataObj->getLabel(), "s='d'"), 'Label', "", $this->commentsLabel, $this->commentsLabel_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Message']['MessageI18n_Text_en_US']['html'] = stdFieldRow(_("Texte en_US"), div( $dataObj->getTranslation('en_US')->getText(), 'MessageI18n_Text_en_US_label' , "class='readonly' s='d'")
                .input('hidden', 'MessageI18n_Text_en_US', $dataObj->getTranslation('en_US')->getText(), "s='d'"), 'MessageI18n_Text_en_US', "", $this->commentsMessageI18n_Text_en_US, $this->commentsMessageI18n_Text_en_US_css, 'readonly', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Message'] as $field => $ar) {
                $this->fields['Message'][$field]['html'] = $this->fieldsRo['Message'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Message'][$field]['html'] = $this->fieldsRo['Message'][$field]['html'];
            }
        }
    }
}
