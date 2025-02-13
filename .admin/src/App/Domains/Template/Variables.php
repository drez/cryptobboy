<?php

namespace App\Domains\Template;

class Variables
{
    static public $varDef = [
        'Authy' => [
            "_table" => "Authy",
            "_desc" => "User table",
            "_dependancy" => array('Authy'),
            "IdAuthy" => "",
            "Fullname"  => "",
            "Email" => "",
            "ValidationKey" => ""
        ],
        'Utils' =>
        [
            "_desc" => "Collection of utilitarian variables",
            "_table" => "",
            "Now" => ["Desc" => "Todays date {format} ie: [Utils-Now{Y-m-d}] => 2020-01-01"],
            "Url" => ["Desc" => "This app base url: " . _SITE_URL],
            "GuiUrl" => ["Desc" => "The GUI url Settings->app_gui_url: " . app_gui_url]
        ]
    ];

    public function __construct()
    {
    }

    public function print()
    {
        $allVars = '';
        $lis = '';
        foreach ($this::$varDef as $name => $field) {
            $TableVars = '';
            if (is_array($field)) {

                foreach ($field as $sname => $data) {
                    if (!strstr($sname, '_') && (!isset($data['Type']) || $data['Type'] != 'Hidden')) {
                        $variable = '';
                        $variable .= "[" . $name . "-" . camelize($sname, true) . "";

                        if (is_array($data) && ($data['Field'] && ($data['Relation'] || $data['Table']))) {

                            $variable .= "-" . camelize($data['Field'], true) . "]";
                            if ($data['Desc'] || isset($data['Format'])) {
                                $Format = ($data['Format']) ? span(" Format : " . $data['Format'] . " ", "style=''") : "";
                                $variable .= "]" . div($Format . $data['Desc'], '', "style='float: right;width: 75%;font-style: italic;'");
                            }
                            $variable .= "";
                        } else {
                            $desc = '';
                            if (isset($data['Desc']) || isset($data['Format'])) {
                                $Format = ($data['Format']) ? span(" Format : " . $data['Format'] . " ", "style=''") : "";
                                $desc .= "" . div($Format . $data['Desc'], '', "style='float: right;width: 75%;font-style: italic;'");
                            }
                            $variable .= "]" . $desc;
                        }
                        $TableVars .= div($variable, '', "style='padding:2px;'");
                    } elseif (strstr($sname, '_') && $sname == '_desc') {
                        $TableVars = div($data, '', "style='padding: 5px 10px;font-style: italic;font-weight: 600;'");
                    }
                }
            }
            $lis .= li(htmlLink($name, "#" . $name));
            $allVars .=
                div($TableVars, $name, "style='margin-bottom:10px;' class='divStdform'");
        }

        return ['html' => 
            div(
                ul($lis) . $allVars,
                "VarDoc",
                " class='mainForm' style=''"
            ),
            'onReadyJs' => "$('#VarDoc').tabs();"
        ];
    }
}
