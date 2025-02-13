<?php

namespace App;


/**
 *  @version 1.1
 *  Generated Form class on the 'Authy' table.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use ApiGoat\Html\Tabs;
use ApiGoat\Utility\FormHelper as Helper;

class AuthyForm extends Authy
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
        $this->model_name = 'Authy';
        $this->virtualClassName = 'Authy';
        $this->childMaxPerPage = (defined('app_child_max_per_page')) ? app_child_max_per_page : 30;
        $this->maxPerPage = (defined('app_max_per_page')) ? app_max_per_page : 50;
        $this->hookFormBottom = '';
        $this->hookFormReadyJs = '';
        
    }

    public function login($username='', $mobile = false)
    {
        if(defined('LOGO_URL_LOGIN')) {
            if(file_exists(_INSTALL_PATH . 'public/img/' . LOGO_URL_LOGIN)) {
                $logoAdmin = LOGO_URL_LOGIN;
            }
        } else {
            $logoAdmin = _SITE_URL.'public/img/logo-admin.png';
        }

        if(empty($_SESSION[_AUTH_VAR]->getCsrf())) {
            $_SESSION[_AUTH_VAR]->setCsrf( md5(uniqid('GoAt').uniqid('', true)) );
        }

        $return['html'] =
                div(
                    div(
                        div(
                            img($logoAdmin)
                        ,'','class="ac-client-logo"')
                        .form(
                            div(
                                input('text', 'user', '', 'placeholder="Username" autocapitalize="none"')
                                .input('password', 'passwd', '', 'placeholder="Password" autocapitalize="none"')
                            , '', 'class="input-wrapper"')
                            .button( _("Login"), 'id="logMe"' )
                            .href(_("Lost password?"), '#', 'class="lost-password"')
                            .input("hidden", "csrf", $_SESSION[_AUTH_VAR]->getCsrf())
                        , 'id="login-form"')
                    , '', 'class="login-content"')
                , 'logMeContainer', 'class="login-wrapper"')
                .$this->hookLogin;

        $return['onReadyJs'] .= "

        $('#login-form #user').focus();
        $('#login-form .lost-password').click(function() {
            if(!$('#login-form').hasClass('forgot-password')){
                $('#login-form').addClass('forgot-password');
                $('#login-form .lost-password,#login-form #logMe').fadeOut(250,function() {
                    $('#login-form #passwd').slideUp(250);
                    $('#login-form #user').attr('placeholder','".addslashes(_("Email"))."');
                    $('#login-form input').val('');
                    $('#login-form .lost-password').text('".addslashes(_("Cancel"))."');
                    $('#login-form #logMe').text('".addslashes(_("Reset"))."');
                    $('#login-form #user,#login-form .lost-password,#login-form #logMe').fadeIn(250);
                });
            } else {
                $('#login-form').removeClass('forgot-password');
                $('#login-form .lost-password,#login-form #logMe').fadeOut(250,function()
                {
                    $('#login-form #passwd').slideDown(250);
                    $('#login-form #user').attr('placeholder','".addslashes(_("Username"))."');
                    $('#login-form .lost-password').text('".addslashes(_("Lost password?"))."');
                    $('#login-form #logMe').text('".addslashes(_("Login"))."');
                    $('#login-form #user,#login-form .lost-password,#login-form #logMe').fadeIn(250);
                });
            }
        });

        $('#logMeContainer').on('submit','#login-form',function() {
            if((!$(this).hasClass('forgot-password') && ($('#user').val() == '' || $('#passwd').val() == '')) || ($(this).hasClass('forgot-password') && $('#passwd').val() == '')) {
                sw_message('Please enter your username and password', true, 'form-error');
            }

            if($('#user').val() != '' && $('#passwd').val() != ''  || $('#user').val() != '' && $(this).hasClass('forgot-password') ) {
                login_ready = false;
                if(!$(this).hasClass('forgot-password')) {
                    passwdHash = $.md5($('#passwd').val());
                    $.post('"._SITE_URL."Authy/auth', {'u':$('#user').val(), 'csrf':$('#csrf').val(), 'p':passwdHash, 'stay':$('#login-form #stay').val()}, function (data){
                        sw_message(data.messages, true, data.status);

                        if(data.status == 'success')
                        {
                            $.post('"._SITE_URL."GuiManager', { a: 'login', t:getTimeZoneData() }, function (data) {
                                window.location.href = '"._SITE_URL."';
                            }, 'json');
                        }
                        login_ready = true;
                    }, 'json').fail(function(response) {
                        sw_message(response.responseJSON.messages, true, response.responseJSON.status);
                    });
                } else {
                    $.post('"._SITE_URL."Authy/reset', { 'c':$('#login-form #user').val() }, function (data){
                        sw_message(data.messages, true, data.status);
                        window.location.href = '"._SITE_URL."';
                        login_ready = true;
                    }, 'json');
                }
            }

            return false;
        });
        ";
        return $return;
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

        $q = new AuthyQuery();
        $q = $this->setAclFilter($q);
        

        if(is_array( $this->searchMs )){
            # main search form
            $q::create()
                
                #alias required
                ->leftJoinWith('AuthyGroupRelatedByIdAuthyGroup a5');

        if( isset($this->searchMs['Username']) ) {
            $criteria = \Criteria::LIKE;


            $value = $this->setCriteria($this->searchMs['Username'], $criteria);

            $q->filterByUsername($value, $criteria)->_or()->filterByEmail($value, $criteria);
        }
        if( isset($this->searchMs['IdAuthyGroup']) ) {
            $criteria = \Criteria::EQUAL;
            $value = $this->searchMs['IdAuthyGroup'];

            $q->filterByIdAuthyGroup($value, $criteria);
        }
                
        }else{
            
            ## standard list
            $hasParent = json_decode($IdParent);
            if(empty($hasParent)) {
                $q::create()
                
                #alias required
                ->leftJoinWith('AuthyGroupRelatedByIdAuthyGroup a5');
                
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
                                $(\"#AuthyListForm [th='sorted'][c='".$col."']\").attr('sens', '".strtolower($sens)."')
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
                $trHead = th(_("Username"), " th='sorted' c='Username' title='" . _('Username')."' ")
.th(_("Fullname"), " th='sorted' c='Fullname' title='" . _('Fullname')."' ")
.th(_("Email"), " th='sorted' c='Email' title='" . _('Email')."' ")
.th(_("Expiration"), " th='sorted' c='Expire' title='" . _('Expiration')."' ")
.th(_("Deactivated"), " th='sorted' c='Deactivate' title='" . _('Deactivated')."' ")
.th(_("Primary group"), " th='sorted' c='AuthyGroupRelatedByIdAuthyGroup.Name' title='"._('AuthyGroupRelatedByIdAuthyGroup.Name')."' ")
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
                
        $this->arrayIdAuthyGroupOptions = $this->selectBoxAuthy_IdAuthyGroup($this, $emptyVar, $data);
                $data = [];
            

            $trSearch = button(span(_("Show search")),'class="trigger-search button-link-blue"')

            .div(
                form(div(input('text', 'Username', $this->searchMs['Username'], '  title="'._('Name').'" placeholder="'._('Name').'"',''),'','class="ac-search-item"').div(selectboxCustomArray('IdAuthyGroup', $this->arrayIdAuthyGroupOptions, 'Primary group' , "v='ID_AUTHY_GROUP'  s='d' ", $this->searchMs['IdAuthyGroup'], '', false), '', ' class="ac-search-item "').$this->hookListSearchTop
                    .div(
                       button(span(_("Search")),'id="msAuthyBt" title="'._('Search').'" class="icon search"')
                       .button(span(_("Clear")),' title="'._('Clear search').'" id="msAuthyBtClear"')
                       .input('hidden', 'Seq', $data['Seq'] )
                    ,'','class="ac-search-item ac-action-buttons"')
                    ,"id='formMsAuthy'")
            ,"", "  class='msSearchCtnr'");;
                return $trSearch;

            case 'add':
            ###### ADD
                if($_SESSION[_AUTH_VAR]->hasRights('Authy', 'a') && !$this->setReadOnly){
                
                                $this->listAddButton = htmlLink(
                                    _("Add new")
                                ,_SITE_URL.$this->virtualClassName."/edit/", "id='addAuthy' title='"._('Add')."' class='button-link-blue add-button'");
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
        $this->TableName = 'Authy';
        $altValue = array (
  'IdAuthy' => '',
  'ValidationKey' => '',
  'Username' => '',
  'Fullname' => '',
  'Email' => '',
  'PasswdHash' => '',
  'Expire' => '',
  'Deactivate' => '',
  'IsRoot' => '',
  'IdAuthyGroup' => '',
  'IsSystem' => '',
  'RightsAll' => '',
  'RightsGroup' => '',
  'RightsOwner' => '',
  'Onglet' => '',
  'DateCreation' => '',
  'DateModification' => '',
  'IdGroupCreation' => '',
  'IdCreation' => '',
  'IdModification' => '',
);
        $tr = '';
        $hook = [];
        $editEvent = '';
        $return = ['html', 'js', 'onReadyJs'];
        $cCmoreCols = '';

        

        $this->uiTabsId = $uiTabsId;

        
        $this->IdParent = $IdParent;

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Authy/');

        // order
        $this->searchOrder = $this->setOrderVar($request['order'] ?? '', 'Authy/');

        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Authy/');

        
        
        
        
        
        

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
                if($_SESSION[_AUTH_VAR]->hasRights('Authy', 'd')){
                    $this->canDelete = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAuthy' ");
                }
            }
        
            foreach($pcData as $data) {
                $this->listActionCell = '';
                
                
                
                                    $AuthyGroupRelatedByIdAuthyGroup_Name = "";
                                    if($data->getAuthyGroupRelatedByIdAuthyGroup()){
                                        $AuthyGroupRelatedByIdAuthyGroup_Name = $data->getAuthyGroupRelatedByIdAuthyGroup()->getName();
                                    }
                

                $actionCell =  td($this->canDelete . $this->listActionCell, " class='actionrow' ");

                $tr .= tr(
                td(span((($altValue['Username']) ? $altValue['Username'] : $data->getUsername()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Username' class=''  j='editAuthy'") . 
                td(span((($altValue['Fullname']) ? $altValue['Fullname'] : $data->getFullname()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Fullname' class=''  j='editAuthy'") . 
                td(span((($altValue['Email']) ? $altValue['Email'] : $data->getEmail()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Email' class=''  j='editAuthy'") . 
                td(span((($altValue['Expire']) ? $altValue['Expire'] : $data->getExpire()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Expire' class=''  j='editAuthy'") . 
                td(span((($altValue['Deactivate']) ? $altValue['Deactivate'] : isntPo($data->getDeactivate())) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Deactivate' class='center'  j='editAuthy'") . 
                td(span((($altValue['IdAuthyGroup']) ? $altValue['IdAuthyGroup'] : $AuthyGroupRelatedByIdAuthyGroup_Name) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='IdAuthyGroup' class=''  j='editAuthy'") . $cCmoreCols.$actionCell
                , " 
                        rid='".json_encode($data->getPrimaryKey())."' data-iterator='".$pcData->getPosition()."'
                        r='data'
                        class='".$hook['class']." '
                        id='AuthyRow".$data->getPrimaryKey()."'")
                ;
                $i++;
                unset($altValue);
            }
            $tr .= input('hidden', 'rowCountAuthy', $i);
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
                
                .div($controlsContent,'AuthyControlsList', "class='custom-controls'")
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
                        table($trHead.$tr, "id='AuthyTable' class='tablesorter' style='width:100%;'")
                     ,'',' class="content" ')
                ,'listForm',' class="ac-list" ')
                .$this->hookListBottom
                .$bottomRow
            , 'AuthyListForm');

          #no parent

    $editUi = (empty($IdParent)) ? 'tabsContain' : 'editDialog';

    $editEvent .= "$(\"#AuthyListForm td[j='editAuthy']\").bindEdit({
                    modelName:'" . $this->virtualClassName . "',
                    destUi: '{$editUi}'
                });
                
    $(\"#AuthyListForm [j='deleteAuthy']\").bindDelete({
        modelName:'" . $this->virtualClassName . "',
        ui:'".$uiTabsId."',
        title: '".addslashes($this->tableDescription)."',
        message: '".addslashes(message_label('delete_row_confirm_msg'))."'
    });";

        $editEvent .= "
        $('#AuthyPager').bindPaging({
            tableName:'Authy'
            ,uiTabsId:'".$uiTabsId."'
            ,ajaxPageActParent:'".$this->virtualClassName."'
        });
";



        $return['onReadyJs'] =
            $HelpDivJs
            
            ."
        

    $('#msAuthyBt').click(function() {
        sw_message('".addslashes(_('Search in progress...'))."',false ,'search-progress', true);
        $('#msAuthyBt button').attr('disabled', 'disabled');

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:$('#formMsAuthy').serialize() },  function(data){
            $('#".$uiTabsId."').html(data);
            $('#formMsAuthy .js-select-label').SelectBox();
            $('#formMsAuthy input[type=text]').first().focus();
            $('#formMsAuthy input[type=text]').first().putCursorAtEnd();
            $('#msAuthyBt button').attr('disabled', '');
            sw_message_remove('search-progress');
        });

        return false;
    });

    $('#formMsAuthy').keydown(function(e) {
        if(e.which == 13) {
            $('#msAuthyBt').click();
        }
    });

    $('#msAuthyBtClear').bind('click', function (){
        sw_message('".addslashes(_('Search cleared...'))."', false,'search-reset', true);

        $.post('"._SITE_URL.$this->virtualClassName."', {ui: '".$uiTabsId."', ms:'clear' },  function(data){
                $('#".$uiTabsId."').html(data);
                $('#formMsAuthy input[type=text]:first-of-type').focus().putCursorAtEnd();
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

        if($('#addAuthyAutoc').length > 0) {
            $('#addAuthyAutoc').bind('click', function () {
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
    public function setCreateDefaultsAuthy($data)
    {

        unset($data['IdAuthy']);
        $e = new Authy();
        
        if($data['noRights'] != 'y'){

            $data['RightsAll'] = serializeRights($data, 'RightsAll');
            $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
            $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
        }
        if($data['PasswdHash'] != $data['PasswdHash_dflt']){
            $data['PasswdHash'] = md5($data['PasswdHash']);
        }
        
        if( $data['Deactivate'] == '' )unset($data['Deactivate']);
        if(!$data['IsRoot']){
            $data['IsRoot'] = "No";
        } 
        if(!$data['IsSystem']){
            $data['IsSystem'] = "No";
        } 
        $e->fromArray($data );

        #
        
        //integer not required
        $e->setValidationKey( ($data['ValidationKey'] == '' ) ? null : $data['ValidationKey']);
        //integer not required
        $e->setUsername( ($data['Username'] == '' ) ? null : $data['Username']);
        //integer not required
        $e->setFullname( ($data['Fullname'] == '' ) ? null : $data['Fullname']);
        $e->setExpire( ($data['Expire'] == '' || $data['Expire'] == 'null' || substr($data['Expire'],0,10) == '-0001-11-30') ? null : $data['Expire'] );
        $e->setDeactivate(($data['Deactivate'] == '' ) ? null : $data['Deactivate']);
        //integer not required
        $e->setRightsAll( ($data['RightsAll'] == '' ) ? null : $data['RightsAll']);
        //integer not required
        $e->setRightsGroup( ($data['RightsGroup'] == '' ) ? null : $data['RightsGroup']);
        //integer not required
        $e->setRightsOwner( ($data['RightsOwner'] == '' ) ? null : $data['RightsOwner']);
        //integer not required
        $e->setOnglet( ($data['Onglet'] == '' ) ? null : $data['Onglet']);
        $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30') ? null : $data['DateCreation'] );
        $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30') ? null : $data['DateModification'] );
        //foreign
        $e->setIdGroupCreation(( $data['IdGroupCreation'] == '' ) ? null : $data['IdGroupCreation']);
        //foreign
        $e->setIdCreation(( $data['IdCreation'] == '' ) ? null : $data['IdCreation']);
        //foreign
        $e->setIdModification(( $data['IdModification'] == '' ) ? null : $data['IdModification']);
        #
        
        return $e;
    }

    /*
    *	Make sure default value are set before save
    */
    public function setUpdateDefaultsAuthy($data)
    {

        
        $e = AuthyQuery::create()->findPk(json_decode($data['i']));
        
        if($data['noRights'] != 'y'){

            $data['RightsAll'] = serializeRights($data, 'RightsAll');
            $data['RightsOwner'] = serializeRights($data, 'RightsOwner');
            $data['RightsGroup'] = serializeRights($data, 'RightsGroup');
        }
        if($data['PasswdHash'] != $data['PasswdHash_dflt']){
            $data['PasswdHash'] = md5($data['PasswdHash']);
        }
        
        if( $data['Deactivate'] == '' )unset($data['Deactivate']);
        if(!$data['IsRoot']){
            $data['IsRoot'] = "No";
        } 
        if(!$data['IsSystem']){
            $data['IsSystem'] = "No";
        } 
        $e->fromArray($data );

        
        
        if(isset($data['Expire'])){
            $e->setExpire( ($data['Expire'] == '' || $data['Expire'] == 'null' || substr($data['Expire'],0,10) == '-0001-11-30') ? null : $data['Expire'] );
        }
        if(isset($data['Deactivate'])){
            $e->setDeactivate(($data['Deactivate'] == '' ) ? null : $data['Deactivate']);
        }
        if(isset($data['DateCreation'])){
            $e->setDateCreation( ($data['DateCreation'] == '' || $data['DateCreation'] == 'null' || substr($data['DateCreation'],0,10) == '-0001-11-30') ? null : $data['DateCreation'] );
        }
        if(isset($data['DateModification'])){
            $e->setDateModification( ($data['DateModification'] == '' || $data['DateModification'] == 'null' || substr($data['DateModification'],0,10) == '-0001-11-30') ? null : $data['DateModification'] );
        }
        if( isset($data['IdGroupCreation']) ){
            $e->setIdGroupCreation(( $data['IdGroupCreation'] == '' ) ? null : $data['IdGroupCreation']);
        }
        if( isset($data['IdCreation']) ){
            $e->setIdCreation(( $data['IdCreation'] == '' ) ? null : $data['IdCreation']);
        }
        if( isset($data['IdModification']) ){
            $e->setIdModification(( $data['IdModification'] == '' ) ? null : $data['IdModification']);
        }
        $e->setNew(false);
        return $e;
    }
    /**
     * Produce a formated form of Authy
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

        $je = "AuthyTable";

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
                
                case 'AuthyGroup':
                    $data['IdGroupCreation'] = $data['ip'];
                    break;
                case 'Authy':
                    $data['IdModification'] = $data['ip'];
                    break;
            }
            $IdParent = $data['ip'];
        }

        if($error == ''){
            unset($error);
        }

        

        // save button and action
        $this->SaveButtonJs = "";
        if(($_SESSION[_AUTH_VAR]->hasRights('Authy', 'a') and !$id ) || ( $_SESSION[_AUTH_VAR]->hasRights('Authy', 'w') and $id) || $this->setReadOnly) {
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
                $('#formAuthy #saveAuthy').unbind('click.saveAuthy');
                $('#formAuthy #saveAuthy').remove();";
        }

        if($_SESSION[_AUTH_VAR]->hasRights('Authy', 'a') && !$this->setReadOnly) {
            $this->formAddButton = htmlLink(_("Add new"), 'Javascript:;' , "id='addAuthy' title='"._('Add')."' class='button-link-blue add-button'");
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
            

            $q = AuthyQuery::create()
            
                #alias required
                ->leftJoinWith('AuthyGroupRelatedByIdAuthyGroup a5')
            ;
            


            $dataObj = $q->filterByIdAuthy($id)->findOne();
            
        }
        
        if($dataObj == null){
            $this->Authy['isNew'] = 'yes';
        }
    
        
        
        if($dataObj == null){
            $dataObj = new Authy();
            $this->Authy['isNew'] = 'yes';
            if(is_array($data ))
               $dataObj->fromArray(array_filter($data));
            
        }else{
                $this->Authy['isNew'] = 'no';
        }
        $this->dataObj = $dataObj;
            
        


                                    ($dataObj->getAuthyGroupRelatedByIdAuthyGroup())?'':$dataObj->setAuthyGroupRelatedByIdAuthyGroup( new AuthyGroup() );

        
        $this->arrayIdAuthyGroupOptions = $this->selectBoxAuthy_IdAuthyGroup($this, $dataObj, $data);
        
        
        
    ## Rights for RightsOwner
    if($_SESSION[_AUTH_VAR]->get('group') == 'Admin'){
        $rightsGroup = array (
  'All' => 'RightsAll',
  'Owner' => 'RightsOwner',
  'Group' => 'RightsGroup',
);
        if(is_array($rightsGroup)){
            foreach($rightsGroup as $group => $columnName){
                $getColumn = "get{$columnName}";
                $userRightsAr[$group] = json_decode($dataObj->$getColumn(), true);
            }

            if(!isset($this->omMap)){
                require _BASE_DIR."config/permissions.php";
                $this->omMap = $omMap;
            }
            unset($rightTables);
            foreach($this->omMap as $key => $row){
                $name[$key] = $row['display'];
            }
                array_multisort($name,SORT_ASC,$this->omMap);
                $rightTables = \ApiGoat\Renderers\Rights::getRightsTable('All', $this->omMap, $userRightsAr['All']);
                $rightTables .= \ApiGoat\Renderers\Rights::getRightsTable('Group', $this->omMap, $userRightsAr['Group']);
                $rightTables .= \ApiGoat\Renderers\Rights::getRightsTable('Owner', $this->omMap, $userRightsAr['Owner']);

            $tabRights = new tabs(
                    [
                        'All' => ['id' => 'RigthsAllTab', 'targetDiv' => '#RigthsAll', 'defaultSelected' => 'true'], 'Group' => ['id' => 'RigthsGroupTab', 'targetDiv' => '#RigthsGroup'], 'Owner' => ['id' => 'RigthsOwnerTab', 'targetDiv' => '#RigthsOwner']
                    ],
                    "RightsTabs",
                    '',
                    'Rights'
                );
            $tabRights->setParentContentDivId("RigthsContainer");
            $tabRights->setLabel("Set the rights (All gives unrestricted access; Group refers to the creation group; Owner refers to the creation user) ");

            $rightInputRightsAll = $tabRights->getHtml()
                . div(
                    $rightTables,
                    'RigthsContainer'
                );
        }

    }
    
        
        
        
$this->fields['Authy']['Username']['html'] = stdFieldRow(_("Username"), input('text', 'Username', htmlentities($dataObj->getUsername()), "   placeholder='".str_replace("'","&#39;",_('Username'))."' size='35'  v='USERNAME' s='d' class=''  ")."", 'Username', "", $this->commentsUsername, $this->commentsUsername_css, '', ' ', 'no');
$this->fields['Authy']['Fullname']['html'] = stdFieldRow(_("Fullname"), input('text', 'Fullname', htmlentities($dataObj->getFullname()), "   placeholder='".str_replace("'","&#39;",_('Fullname'))."' size='35'  v='FULLNAME' s='d' class=''  ")."", 'Fullname', "", $this->commentsFullname, $this->commentsFullname_css, '', ' ', 'no');
$this->fields['Authy']['Email']['html'] = stdFieldRow(_("Email"), input('text', 'Email', htmlentities($dataObj->getEmail()), "   placeholder='".str_replace("'","&#39;",_('Email'))."' size='35'  v='EMAIL' s='d' class='req'  ")."", 'Email', "", $this->commentsEmail, $this->commentsEmail_css, '', ' ', 'no');
$this->fields['Authy']['PasswdHash']['html'] = stdFieldRow(_("Password"), input('password', 'PasswdHash', htmlentities($dataObj->getPasswdHash()), "   placeholder='".str_replace("'","&#39;",_('Password'))."' size='35'  v='PASSWD_HASH' s='d' class='req'  ").input('hidden', 'PasswdHash_dflt', $dataObj->getPasswdHash(), " s='d' class='req'"), 'PasswdHash', "", $this->commentsPasswdHash, $this->commentsPasswdHash_css, '', ' ', 'no');
$this->fields['Authy']['Expire']['html'] = stdFieldRow(_("Expiration"), input('date', 'Expire', $dataObj->getExpire(), "  j='date' autocomplete='off' placeholder='YYYY-MM-DD' size='10'  s='d' class='' title='Expiration'"), 'Expire', "", $this->commentsExpire, $this->commentsExpire_css, '', ' ', 'no');
$this->fields['Authy']['Deactivate']['html'] = stdFieldRow(_("Deactivated"), selectboxCustomArray('Deactivate', array( '0' => array('0'=>_("Yes"), '1'=>"Yes"),'1' => array('0'=>_("No"), '1'=>"No"), ), _('Deactivated'), "s='d'  ", $dataObj->getDeactivate(), '', true), 'Deactivate', "", $this->commentsDeactivate, $this->commentsDeactivate_css, '', ' ', 'no');
$this->fields['Authy']['IdAuthyGroup']['html'] = stdFieldRow(_("Primary group"), selectboxCustomArray('IdAuthyGroup', $this->arrayIdAuthyGroupOptions, "", "v='ID_AUTHY_GROUP'  s='d'  val='".$dataObj->getIdAuthyGroup()."'", $dataObj->getIdAuthyGroup()), 'IdAuthyGroup', "", $this->commentsIdAuthyGroup, $this->commentsIdAuthyGroup_css, '', ' ', 'no');
$this->fields['Authy']['RightsAll']['html'] = stdFieldRow(_("Rights"), $rightInputRightsAll, 'RightsAll', "", $this->commentsRightsAll, $this->commentsRightsAll_css, ' rightsTr', ' ', 'no');
$this->fields['Authy']['RightsGroup']['html'] = stdFieldRow(_("Rights group"), $rightInputRightsGroup, 'RightsGroup', "", $this->commentsRightsGroup, $this->commentsRightsGroup_css, ' rightsTr', ' ', 'no');
$this->fields['Authy']['RightsOwner']['html'] = stdFieldRow(_("Rights owner"), $rightInputRightsOwner, 'RightsOwner', "", $this->commentsRightsOwner, $this->commentsRightsOwner_css, ' rightsTr', ' ', 'no');


        

        // Whole form read only
        if($this->setReadOnly == 'all' ) {
            $this->lockFormField('all', $dataObj);
        }


        if( !isset($this->Authy['request']['ChildHide']) ) {

            # define child lists 'Group'
            $ongletTab['0']['t'] = _('Group');
            $ongletTab['0']['p'] = 'AuthyGroupX';
            $ongletTab['0']['lkey'] = 'IdAuthy';
            $ongletTab['0']['fkey'] = 'IdAuthy';
            # define child lists 'Login log'
            $ongletTab['1']['t'] = _('Login log');
            $ongletTab['1']['p'] = 'AuthyLog';
            $ongletTab['1']['lkey'] = 'IdAuthy';
            $ongletTab['1']['fkey'] = 'IdAuthy';
        if(!empty($ongletTab) and $dataObj->getIdAuthy()){
            foreach($ongletTab as $value){
                if($_SESSION[_AUTH_VAR]->hasRights($value['p'], 'r')){

                    $getLocalKey = "get".$value['lkey']."";
                    if($dataObj->$getLocalKey()){
                        $ChildOnglet .= li(
                                        htmlLink(	_($value['t'])
                                            ,'javascript:',"p='".$value['p']."' act='list' j=conglet_Authy ip='".$dataObj->$getLocalKey()."' class='ui-state-default' ")
                                    ,"  class='' j=sm  ");
                    }
                }
            }

            if($ChildOnglet){
                $childTable['onReadyJs'] ="
                    $('[j=conglet_Authy]').bind('click', function (data){
                        pp = $(this).attr('p');
                        $('#cntAuthyChild').html( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg') );
                        $.get('"._SITE_URL."Authy/'+pp+'/'+$(this).attr('ip'), { ui: pp+'Table', 'pui':'".$uiTabsId."', pc:'".$data['pc']."'}, function(data){
                            $('#cntAuthyChild').html(data);
                            $('[j=conglet_Authy]').parent().attr('class','ui-state-default');
                            $('[j=conglet_Authy][p='+pp+']').parent().attr('class',' ui-state-default ui-state-active');
                        }).fail(function(data) {
                            $('#cntAssetChild').html('Error: try again or contact your administrator.');
                            console.log(data);
                        });;
                    });
                ";
                if($_SESSION['mem']['Authy']['child']['list'][$dataObj->$getLocalKey()]){
                    $onglet_p = $_SESSION['mem']['Authy']['child']['list'][$dataObj->$getLocalKey()];
                    $childTable['onReadyJs'] .= " $('[j=conglet_Authy][p=".$onglet_p."]').first().click();";
                }else{
                    $childTable['onReadyJs'] .= " $('[j=conglet_Authy]').first().click();";
                }
            }
        }
        }
        $ongletf =
            div(
                ul(li(htmlLink(_('User'),'#ogf_Authy',' j="ogf" p="Authy" class="ui-tabs-anchor" '))
                    .li(htmlLink(_('Rights'),'#ogf_rights_all',' j="ogf" class="ui-tabs-anchor" p="Authy" ')))
            ,'cntOngletAuthy',' class="cntOnglet"')
        ;
        
        if(!$this->setReadOnly){
            $this->formSaveBar = div(	div( input('button', 'saveAuthy', _('Save'),' class="button-link-blue can-save"')
                                .input('hidden', 'formChangedAuthy','', 'j="formChanged"')
                                .input('hidden', 'idPk', urlencode($id), "s='d'")
                            .input('hidden', 'IdAuthy', $dataObj->getIdAuthy(), " s='d' pk").input('hidden', 'IdGroupCreation', $dataObj->getIdGroupCreation(), " s='d' nodesc").input('hidden', 'IdCreation', $dataObj->getIdCreation(), " s='d' nodesc").input('hidden', 'IdModification', $dataObj->getIdModification(), " s='d' nodesc")
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
            $jqueryDatePicker = " $(\"#formAuthy [j='date']\").attr('type', 'text');
            $(\"#formAuthy [j='date']\").each(function(){
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
                div('User', '', "class='panel-heading'").
                $header_top_onglet.
                
                $this->hookFormInnerTop
                
                .
                    '<div id="ogf_Authy">'.
$this->fields['Authy']['Username']['html']
.$this->fields['Authy']['Fullname']['html']
.$this->fields['Authy']['Email']['html']
.$this->fields['Authy']['PasswdHash']['html']
.$this->fields['Authy']['Expire']['html']
.$this->fields['Authy']['Deactivate']['html']
.$this->fields['Authy']['IdAuthyGroup']['html']
.'</div><div id="ogf_rights_all"  class=" ui-tabs-panel">'
.$this->fields['Authy']['RightsAll']['html']
.$this->fields['Authy']['RightsGroup']['html']
.$this->fields['Authy']['RightsOwner']['html'].'</div>'
                
                .$this->formSaveBar
                .$this->hookFormInnerBottom
            ,"divCntAuthy", "class='divStdform' CntTabs=1 ".$this->ccStdFormOptions)
        , "id='formAuthy' class='mainForm formContent' ")
        .$this->hookFormBottom;


        //if not new, show child table
        if($dataObj->getIdAuthy()) {
            if($ChildOnglet) {
                $return['html'] .= div(
                                        div('Child(s)', '', "class='panel-heading'")
                                        . ul($ChildOnglet, " class=' ui-tabs-nav ' ")
                                        . div('','cntAuthyChild',' class="" ')
                                    , 'pannelAuthy', " class='child_pannel ui-tabs childCntClass'");
            }
        }

        if($id and $_SESSION['mem']['Authy']['ogf']) {
            $tabs_act = "$('[href=\"".$_SESSION['mem']['Authy']['ogf']."\"]').click();";
        }

        if($_SESSION['mem']['Authy']['ixmemautocapp'] and $_GET['Autocapp'] == 1) {
            $Autocapp = $_SESSION['mem']['Authy']['ixmemautocapp'];
            unset($_SESSION['mem']['Authy']['ixmemautocapp']);
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
        
{$tabRights?->getOnReadyJs()}
$('[j=mass-action-Rights]').bind('click', function(){
    var target = $(this).attr('target');
    if( $(this).prop('checked')){
        $(\"[j='rcRights\"+target+\"']\").prop('checked',true);
    }else{
        $(\"[j='rcRights\"+target+\"']\").prop('checked',false);
    }
});
$(\"[j='chkRights']\").click(function(){
    if($(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked')){
        $(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked',false);
    }else{
        $(\"[ent='\"+$(this).attr('i')+\"']\").prop('checked',true);
    }
});
if($('#formAuthy #Group').val() == 'Admin'){
    $('#formAuthy #genRightsCtnr').hide();
}else{
    $('#formAuthy #genRightsCtnr').show();
}
$('#formAuthy #Group').change(function (){
    if($('#formAuthy #Group').val() == 'Admin'){
        $('#formAuthy #genRightsCtnr').hide();
    }else{
        $('#formAuthy #genRightsCtnr').show();
    }
});

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
            $(\"#formAuthy [s='d'], #formAuthy .js-select-label, #formAuthy [j='autocomplete']\")
                .bindFormKeypress({modelName: '" . $this->virtualClassName . "'});
            $('#formAuthy .js-select-label').SelectBox();
        }, 400);
        ";
        return $return;
    }

    function lockFormField($fields, $dataObj)
    {
        
        $this->fieldsRo['Authy']['Username']['html'] = stdFieldRow(_("Username"), div( $dataObj->getUsername(), 'Username_label' , "class='readonly' s='d'")
                .input('hidden', 'Username', $dataObj->getUsername(), "s='d'"), 'Username', "", $this->commentsUsername, $this->commentsUsername_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['Fullname']['html'] = stdFieldRow(_("Fullname"), div( $dataObj->getFullname(), 'Fullname_label' , "class='readonly' s='d'")
                .input('hidden', 'Fullname', $dataObj->getFullname(), "s='d'"), 'Fullname', "", $this->commentsFullname, $this->commentsFullname_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['Email']['html'] = stdFieldRow(_("Email"), div( $dataObj->getEmail(), 'Email_label' , "class='readonly' s='d'")
                .input('hidden', 'Email', $dataObj->getEmail(), "s='d'"), 'Email', "", $this->commentsEmail, $this->commentsEmail_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['PasswdHash']['html'] = stdFieldRow(_("Password"), div( $dataObj->getPasswdHash(), 'PasswdHash_label' , "class='readonly' s='d'")
                .input('hidden', 'PasswdHash', $dataObj->getPasswdHash(), "s='d'"), 'PasswdHash', "", $this->commentsPasswdHash, $this->commentsPasswdHash_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['Expire']['html'] = stdFieldRow(_("Expiration"), div( $dataObj->getExpire(), 'Expire_label' , "class='readonly' s='d'")
                .input('hidden', 'Expire', $dataObj->getExpire(), "s='d'"), 'Expire', "", $this->commentsExpire, $this->commentsExpire_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['Deactivate']['html'] = stdFieldRow(_("Deactivated"), div( $dataObj->getDeactivate(), 'Deactivate_label' , "class='readonly' s='d'")
                .input('hidden', 'Deactivate', $dataObj->getDeactivate(), "s='d'"), 'Deactivate', "", $this->commentsDeactivate, $this->commentsDeactivate_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['IdAuthyGroup']['html'] = stdFieldRow(_("Primary group"), div( ($dataObj->getAuthyGroupRelatedByIdAuthyGroup())?$dataObj->getAuthyGroupRelatedByIdAuthyGroup()->getName():'', 'IdAuthyGroup_label' , "class='readonly' s='d'")
                .input('hidden', 'IdAuthyGroup', $dataObj->getIdAuthyGroup(), "s='d'"), 'IdAuthyGroup', "", $this->commentsIdAuthyGroup, $this->commentsIdAuthyGroup_css, 'readonly', ' ', 'no');

        $this->fieldsRo['Authy']['RightsAll']['html'] = stdFieldRow(_("Rights"), div( $dataObj->getRightsAll(), 'RightsAll_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsAll', $dataObj->getRightsAll(), "s='d'"), 'RightsAll', "", $this->commentsRightsAll, $this->commentsRightsAll_css, 'readonly rightsTr', ' ', 'no');

        $this->fieldsRo['Authy']['RightsGroup']['html'] = stdFieldRow(_("Rights group"), div( $dataObj->getRightsGroup(), 'RightsGroup_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsGroup', $dataObj->getRightsGroup(), "s='d'"), 'RightsGroup', "", $this->commentsRightsGroup, $this->commentsRightsGroup_css, 'readonly rightsTr', ' ', 'no');

        $this->fieldsRo['Authy']['RightsOwner']['html'] = stdFieldRow(_("Rights owner"), div( $dataObj->getRightsOwner(), 'RightsOwner_label' , "class='readonly' s='d'")
                .input('hidden', 'RightsOwner', $dataObj->getRightsOwner(), "s='d'"), 'RightsOwner', "", $this->commentsRightsOwner, $this->commentsRightsOwner_css, 'readonly rightsTr', ' ', 'no');


        if($fields == 'all') {
            foreach($this->fields['Authy'] as $field => $ar) {
                $this->fields['Authy'][$field]['html'] = $this->fieldsRo['Authy'][$field]['html'];
            }
        } elseif(is_array($fields)) {
            foreach($fields as $field) {
                $this->fields['Authy'][$field]['html'] = $this->fieldsRo['Authy'][$field]['html'];
            }
        }
    }

    /**
     * Query for Authy_IdAuthyGroup selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxAuthy_IdAuthyGroup(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
        $q = AuthyGroupQuery::create();

            $q->select(array('Name', 'IdAuthyGroup'));
            $q->orderBy('Name', 'ASC');
        
            if(!$array){
                return $q;
            }else{
                $pcDataO = $q->find();
            }


        $arrayOpt = $pcDataO->toArray();

        return assocToNum($arrayOpt , true);
    }

    /**
     * Query for AuthyGroupX_IdAuthyGroup selectBox 
     * @param object $obj
     * @param object $dataObj
     * @param array $data
    **/
    public function selectBoxAuthyGroupX_IdAuthyGroup(&$obj = '', &$dataObj = '', &$data = '', $emptyVal = false, $array = true){
        $q = AuthyGroupQuery::create();

            $q->select(array('Name', 'IdAuthyGroup'));
            $q->orderBy('Name', 'ASC');
        
            if(!$array){
                return $q;
            }else{
                $pcDataO = $q->find();
            }


        $arrayOpt = $pcDataO->toArray();

        return assocToNum($arrayOpt , true);
    }	
    /**
     * function getAuthyGroupXList
     * @param string $IdAuthy
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getAuthyGroupXList(String $IdAuthy, array $request)
    {

        $this->TableName = 'AuthyGroupX';
        $altValue = array (
  'IdAuthy' => '',
  'IdAuthyGroup' => '',
);
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntAuthyChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Authy/AuthyGroupX');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'Authy/AuthyGroupX');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Authy/AuthyGroupX');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->Authy['request']['noHeader']) && $this->Authy['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdAuthy'] = $IdAuthy;
        if($dataObj == null){
            $dataObj = new Authy();
            $dataObj->setIdAuthy($IdAuthy);
        }

        $this->AuthyGroupX['list_add'] = "";
        $this->AuthyGroupX['list_delete'] = "
        $(\"[j='deleteAuthyGroupX']\").bindDelete({
            modelName:'AuthyGroupX',
            ui:'cntAuthyGroupXdivChild',
            title: 'Group',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroupX', 'r')){
            $this->AuthyGroupX['list_edit'] = "
        $(\"#AuthyGroupXTable tr td[j='editAuthyGroupX']\").bind('click', function (){
            
        /*NtN*/
        if($(this).attr('crpk')) {
            var i = $(this).attr('crpk');
        }else{
            var i = $(this).attr('i');
        }
        
        document.location = '"._SITE_URL."AuthyGroup/edit/'+i
        });";
        }

        #filters validation
        
        $filterKey = $IdAuthy;
        $this->IdPk = $IdAuthy;
        
        
        #main query
        
        // many to many relation
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = AuthyGroupXQuery::create();
        

        $q
        
                #NtN
                ->joinWith('AuthyGroup a100', \Criteria::RIGHT_JOIN)
        
            // no search
            ->addJoinCondition('a100', '(authy_group_x.id_authy IS NULL OR authy_group_x.id_authy = ?)', $IdAuthy);
                
        
        ;
        // Search
        
        
        
        // ordering
        
        if( is_array( $search['order'] ) ) {
            foreach ($search['order'] as $order) {
                foreach ($order as $col => $sens) {
                    if( $sens ) {
                        $tOrd = explode('.', $col);
                        $orderBy = "use" . $tOrd[0] . "Query";
                        if( $tOrd[1] && method_exists( $q, $orderBy )) {
                            $q->$orderBy( '', \Criteria::LEFT_JOIN )->orderBy( $tOrd[1], $sens )->endUse();
                        }elseif( method_exists( $q, 'filterBy' . $col )) {
                            $q->orderBy( $col, $sens );
                        }

                        $orderReadyJs .= "
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('order','on');
                        ";
                    }
                }
            }
        }
        
        $this->queryObjAuthyGroupX = $q;
        
        
        $pmpoData = $q->paginate( $search['page'], $maxPerPage );
        $resultsCount = $pmpoData->getNbResults();
        
        #options building
        
        $this->arrayIdAuthyGroupOptions = $this->selectBoxAuthyGroupX_IdAuthyGroup($this, $dataObj, $data);
        
        
          
        
        if(isset($this->Authy['request']['noHeader']) && $this->Authy['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroupX', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("Group"), " th='sorted' c='AuthyGroup.Name' title='"._('AuthyGroup.Name')."' ")
.'' . $actionRowHeader, " ln='AuthyGroupX' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No Group found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='AuthyGroupX' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellAuthyGroupX = '';
                $actionRow = '';
                
                
                
            $checkboxPk = array(intval($IdAuthy), ($data->getAuthyGroup()) ? $data->getAuthyGroup()->getPrimaryKey():0 );
            
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyGroupX', 'd')){
                    $actionRow = "";
                }
                
                
                
                
                if($searchNtNSet  || $data->getIdAuthy() == intval($IdAuthy)){
                    $actionRow .= input('checkbox','check_'.$i, json_encode($checkboxPk), " checked='checked' i='".json_encode($checkboxPk)."' class='hand'  j='check_multi_AuthyGroupX' ").label('','for="check_'.$i.'"');
                }else{
                    $actionRow .=
                    input('checkbox','check_'.$i, json_encode($checkboxPk),"  i='".json_encode($checkboxPk)."' class='hand' j='check_multi_AuthyGroupX' ").label('','for="check_'.$i.'"');
                }
            
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellAuthyGroupX.$actionRow," class='actionrow'") : "";
                
                                    $AuthyGroup_Name = "";
                                    if($data->getAuthyGroup()){
                                        $AuthyGroup_Name = $data->getAuthyGroup()->getName();
                                    }
                
                
                ;
                
                
                
                $tr .= 
                        tr(
                            (isset($hookListColumnsAuthyGroupXFirst)?$hookListColumnsAuthyGroupXFirst:'').
                            
                td(span((($altValue['IdAuthyGroup']) ? $altValue['IdAuthyGroup'] : $AuthyGroup_Name) ?? ''." "), " crPk = '".(($data->getAuthyGroup())?$data->getAuthyGroup()->getIdAuthyGroup():0)."' i='" . json_encode($data->getPrimaryKey()) . "' c='IdAuthyGroup' class=''  j='editAuthyGroupX'") . 
                            (isset($hookListColumnsAuthyGroupX)?$hookListColumnsAuthyGroupX:'').
                            $actionRow
                        ,"id='AuthyGroupXRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='AuthyGroupX'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = "";
    if(($_SESSION[_AUTH_VAR]->hasRights('AuthyGroupX', 'a')) ){
        $add_button_child = "";
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookAuthyGroupXListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookAuthyGroupXTableFooter
                                , "id='AuthyGroupXTable' class='tablesorter'")
                            , 'childlistAuthyGroupX')
                            .$this->hookAuthyGroupXListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'AuthyGroupXListForm')
            ,'cntAuthyGroupXdivChild', "class='childListWrapper'");

            
            

            $return['onReadyJs'] =
                $this->hookListReadyJsFirstAuthyGroupX
                .""
                .$this->AuthyGroupX['list_add']
                .$this->AuthyGroupX['list_delete']
                .$this->AuthyGroupX['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
            $('#mass-action-AuthyGroupX').click(function (e){
                e.preventDefault();
                $('[j=check_multi_AuthyGroupX]').click();
            });

            /*Shift select range*/
            var \$chkboxes = $('.actionrow input[type=checkbox]'); 
            var lastChecked;
            \$chkboxes.click(function(e) {
                if(!lastChecked) {
                    lastChecked = this;
                    return;
                }

                if(e.ctrlKey) {
                    var start = \$chkboxes.index(this);
                    var end = \$chkboxes.index(lastChecked);
                    \$chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
                }
                lastChecked = this;
                
                $('.pagination-wrapper .selectedCount').html( '('+$('[j=check_multi_AuthyGroupX]:checked').length+' selected)' );
        });
        
        $('[j=check_multi_AuthyGroupX]').change(function (){
            $.post('"._SITE_URL."{$this->virtualClassName}/NtNsaveAuthyGroupX', {i:$(this).val(), ui:'".$parentContainer."' }, function (data){
                $('#pannelSForm [j=conglet_Authy][p=AuthyGroupX]').click();
                $('body').css('cursor', 'default');
                $(this).css('cursor', 'default');
            });
        });
                
        /* PAGINATION */
        $('#AuthyGroupXPager').bindPaging({
            tableName:'AuthyGroupX'
            , parentId:'".$IdAuthy."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/AuthyGroupX/$IdAuthy'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'AuthyGroupX',
            url:'".$this->virtualClassName."/AuthyGroupX/$IdAuthy',
            destUi:'".$uiTabsId."'
        });
        
        $('#cntAuthyChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "
                "
                . $this->hookListReadyJsAuthyGroupX;
        return $return;
    }	
    /**
     * function getAuthyLogList
     * @param string $IdAuthy
     * @param integer $page
     * @param string $uiTabsId
     * @param string $parentContainer
     * @param string $mja_list
     * @param array $search
     * @param array $params
     * @return string
     */
    public function getAuthyLogList(String $IdAuthy, array $request)
    {

        $this->TableName = 'AuthyLog';
        $altValue = array (
  'IdAuthyLog' => '',
  'IdAuthy' => '',
  'Timestamp' => '',
  'Login' => '',
  'Userid' => '',
  'Result' => '',
  'Ip' => '',
  'Count' => '',
);
        $dataObj = null;
        $search = ['order' => null, 'page' => null, ];
        $uiTabsId = (empty($request['cui'])) ? 'cntAuthyChild' : $request['cui'];
        $parentContainer = $request['pc'];
        $orderReadyJs = '';
        $param = [];
        $total_child = '';

        // if Search params
        $this->searchMs = $this->setSearchVar($request['ms'] ?? '', 'Authy/AuthyLog');

        // order
        $search['order'] = $this->setOrderVar($request['order'] ?? '', 'Authy/AuthyLog');
        
        // page
        $search['page'] = $this->setPageVar($request['pg'] ?? '', 'Authy/AuthyLog');
       
        
        

        /*column hide*/
        
        if($parentContainer == 'editDialog'){
            $diagNoClose = "diag:\"noclose\", ";
            $diagNoCloseEscaped = "diag:\\\"noclose\\\", ";
        }
        
        if(isset($this->Authy['request']['noHeader']) && $this->Authy['request']['noHeader'] == 'true'){
            $noHeader = "'noHeader':'true',";
        }
        
        $data['IdAuthy'] = $IdAuthy;
        if($dataObj == null){
            $dataObj = new Authy();
            $dataObj->setIdAuthy($IdAuthy);
        }

        $this->AuthyLog['list_add'] = "
        $('#AuthyLogListForm #addAuthyLog').bindEdit({
                modelName: 'AuthyLog',
                destUi: 'editDialog',
                pc:'{$this->virtualClassName}',
                ip:'".$IdAuthy."',
                jet:'refreshChild',
                tp:'AuthyLog',
                description: 'Login log'
        });
        ";
        $this->AuthyLog['list_delete'] = "
        $(\"[j='deleteAuthyLog']\").bindDelete({
            modelName:'AuthyLog',
            ui:'cntAuthyLogdivChild',
            title: 'Login log',
            message: '".addslashes(message_label('delete_row_confirm_msg') ?? '')."'
        });";

        if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'r')){
            $this->AuthyLog['list_edit'] = "
        $(\"#AuthyLogTable tr td[j='editAuthyLog']\").bind('click', function (){
            
        $('#editDialog').html( $('<div>').append( $('<img>').attr('src', '"._SITE_URL."public/img/Ellipsis-3.9s-200px.svg').css('width', '300px')).css('width', '300px').css('margin', 'auto') );
        $('#editDialog').dialog({width:'auto'}).dialog('open');
        $.get('"._SITE_URL."AuthyLog/edit/'+$(this).attr('i'),
                { ip:'".$IdAuthy."', ui:'editDialog', pc:'{$this->virtualClassName}', je:'AuthyLogTableCntnr', jet:'refreshChild', 'it-pos':$(this).data('iterator-pos') },
            function(data){ 
                dialogWidthClass($('#editDialog')); 
                $('#editDialog').html(data).dialog({width:'auto'});  
        });
        });";
        }

        #filters validation
        
        $filterKey = $IdAuthy;
        $this->IdPk = $IdAuthy;
        
        
        #main query
        
        // Normal query
        $maxPerPage = ( $request['maxperpage'] ) ? $request['maxperpage'] : $this->childMaxPerPage;
        $q = AuthyLogQuery::create();
        
        
        $q 
            
            ->filterByIdAuthy( $filterKey );; 
               // Search
        
               // orderring
           
        if( is_array( $search['order'] ) ) {
            foreach ($search['order'] as $order) {
                foreach ($order as $col => $sens) {
                    if( $sens ) {
                        $tOrd = explode('.', $col);
                        $orderBy = "use" . $tOrd[0] . "Query";
                        if( $tOrd[1] && method_exists( $q, $orderBy )) {
                            $q->$orderBy( '', \Criteria::LEFT_JOIN )->orderBy( $tOrd[1], $sens )->endUse();
                        }elseif( method_exists( $q, 'filterBy' . $col )) {
                            $q->orderBy( $col, $sens );
                        }

                        $orderReadyJs .= "
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('sens','".$sens."');
                            $(\"#{$uiTabsId} [th='sorted'][c='".$col."'], #{$uiTabsId} [th='sorted'][rc='".$col."']\").attr('order','on');
                        ";
                    }
                }
            }
        }
            // group by
           
        
        $this->queryObjAuthyLog = $q;
        
        $pmpoData =$q->paginate($search['page'], $maxPerPage);
        $resultsCount = $pmpoData->getNbResults();
        
         
        #options building
        
        
        
          
        
        if(isset($this->Authy['request']['noHeader']) && $this->Authy['request']['noHeader'] == 'true'){
            $trSearch = "";
        }

        $actionRowHeader ='';
        if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'd')){
            $actionRowHeader = th('&nbsp;', " r='delrow' class='actionrow' ");
        }

        $header = tr( th(_("Date"), " th='sorted' c='Timestamp' title='" . _('Date')."' ")
.th(_("Username"), " th='sorted' c='Login' title='" . _('Username')."' ")
.th(_("Ip"), " th='sorted' c='Ip' title='" . _('Ip')."' ")
.th(_("Count"), " th='sorted' c='Count' title='" . _('Count')."' ")
.'' . $actionRowHeader, " ln='AuthyLog' class=''");

        

        $i=0;
        $tr = '';
        if( $pmpoData->isEmpty() ){
            $tr .= tr(	td(p(span(_("No Login log found")),'class="no-results"'), "style='font-size:16px;' t='empty' ln='AuthyLog' colspan='100%' "));
            
        }else{
            //$pcData = $pmpoData->getResults();
            foreach($pmpoData as $data){
                $this->listActionCellAuthyLog = '';
                $actionRow = '';
                
                
                
                if($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'd')){
                    $actionRow = htmlLink("<i class='ri-delete-bin-7-line'></i>", "Javascript:", "class='ac-delete-link' j='deleteAuthyLog' i='".json_encode($data->getPrimaryKey())."'");
                }
                
                
                
                
                
                $actionRow = $actionRow;
                $actionRow = (!empty($actionRow)) ? td($this->listActionCellAuthyLog.$actionRow," class='actionrow'") : "";
                
                
                
                ;
                
                
                
                $tr .= 
                        tr(
                            (isset($hookListColumnsAuthyLogFirst)?$hookListColumnsAuthyLogFirst:'').
                            
                td(span((($altValue['Timestamp']) ? $altValue['Timestamp'] : $data->getTimestamp()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Timestamp' class=''  j='editAuthyLog'") . 
                td(span((($altValue['Login']) ? $altValue['Login'] : $data->getLogin()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Login' class=''  j='editAuthyLog'") . 
                td(span((($altValue['Ip']) ? $altValue['Ip'] : $data->getIp()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Ip' class=''  j='editAuthyLog'") . 
                td(span((($altValue['Count']) ? $altValue['Count'] : $data->getCount()) ?? ''." "), "  i='" . json_encode($data->getPrimaryKey()) . "' c='Count' class=''  j='editAuthyLog'") . 
                            (isset($hookListColumnsAuthyLog)?$hookListColumnsAuthyLog:'').
                            $actionRow
                        ,"id='AuthyLogRow{$data->getPrimaryKey()}' rid='{$data->getPrimaryKey()}' ln='AuthyLog'  ")
                        ;
                
                $i++;
            }
            
            
        }

    $add_button_child = 
                            div(
                                div(
                                    div($total_child,'','class="nolink"')
                            ,'trAuthyLog'," ln='AuthyLog' class=''").$this->cCMainTableHeader, '', "class='listHeaderItem' ");
    if(($_SESSION[_AUTH_VAR]->hasRights('AuthyLog', 'a')) ){
        $add_button_child = htmlLink(span(_("Add")), "Javascript:","title='Add "._('Login log')."' id='addAuthyLog' class='button-link-blue add-button'");
    }

    //@PAGINATION
    $pagerRow = $this->getPager($pmpoData, $resultsCount, $search, true);

    $return['html'] =
            div(
                 $this->hookAuthyLogListTop
                .div(
                    div($add_button_child
                    .$trSearch, '' ,'class="ac-list-form-header-child"')
                    .div(
                        div(
                            div(
                                table(	
                                    thead($header)
                                    .$tr
                                    .$this->hookAuthyLogTableFooter
                                , "id='AuthyLogTable' class='tablesorter'")
                            , 'childlistAuthyLog')
                            .$this->hookAuthyLogListBottom
                        ,'',' class="content" ')
                    ,'listFormChild',' class="ac-list" ')
                    .$pagerRow
                ,'AuthyLogListForm')
            ,'cntAuthyLogdivChild', "class='childListWrapper'");

            
            

            $return['onReadyJs'] =
                $this->hookListReadyJsFirstAuthyLog
                .""
                .$this->AuthyLog['list_add']
                .$this->AuthyLog['list_delete']
                .$this->AuthyLog['list_edit']
            ."
            
            
            
            /*checkboxes*/
            
                
        /* PAGINATION */
        $('#AuthyLogPager').bindPaging({
            tableName:'AuthyLog'
            , parentId:'".$IdAuthy."'
            , uiTabsId:'{$uiTabsId}'
            , ajaxPageActParent:'".$this->virtualClassName."/AuthyLog/$IdAuthy'
            , pui:'".$uiTabsId."'
        });  

        $(\"#{$uiTabsId} [th='sorted']\").bindSorting({
            modelName:'AuthyLog',
            url:'".$this->virtualClassName."/AuthyLog/$IdAuthy',
            destUi:'".$uiTabsId."'
        });
        
        $('#cntAuthyChild .js-select-label').SelectBox();

        {$orderReadyJs}
        ";

        $return['onReadyJs'] .= "
                "
                . $this->hookListReadyJsAuthyLog;
        return $return;
    }
}
