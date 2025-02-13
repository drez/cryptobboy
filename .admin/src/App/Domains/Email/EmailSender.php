<?php

namespace App\Domains\Email;

use Selective\Config\Configuration;
use PHPMailer\PHPMailer\PHPMailer;
use App\Domains\Template\MatchReplace;
use TemplateQuery;

/**
 * Validate and send Emails
 */
class EmailSender
{

    use \ApiGoat\Api\Message;

    private $config = [];
    private $args = [];
    private $PHPMailer;

    /**
     * configure PHPmailer server options
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->args = $args;
        $Configuration = new Configuration(require _BASE_DIR . 'config/settings.php');
        $this->config = $Configuration->getArray('email');
        $this->PHPMailer = new PHPMailer();
        if (!empty($this->config['host'])) {
            $this->PHPMailer->isSMTP();
            $this->PHPMailer->SMTPAuth = true;
            $this->PHPMailer->SMTPAutoTLS = false;
            $this->PHPMailer->Host = $this->config['host'];
            $this->PHPMailer->Port = $this->config['port'];
            $this->PHPMailer->SMTPSecure  = $this->config['smtp_secure'];
            $this->PHPMailer->Username = $this->config['username'];
            $this->PHPMailer->Password = $this->config['password'];
            $this->PHPMailer->SMTPDebug  = $this->config['smtp_debug'];
            $this->PHPMailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //$this->PHPMailer->DKIM_domain = $this->config['dkim_key'];
        } else {
            $this->PHPMailer->isSendmail();
        }
        $this->PHPMailer->setFrom($this->config['default_from']);
    }

    /**
     * Validate the request
     *
     * @return bool
     */
    public function checkRequest()
    {
        if (\is_int($this->args['i']) || is_array($this->args['data']['id_authy']) || !empty($this->args['data']['email'])) {
            if (!empty($this->args['data']['template_name'])) {
                $Template = \App\TemplateQuery::create()->filterByName($this->args['data']['template_name'])->filterByStatus('Active')->findOne();
                if (!$Template) {
                    return true;
                } else {
                    $this->Template = $Template;
                    return false;
                }
            }
        }

        $this->addLog("Wrong or missing parameters", "errors");
        return true;
    }

    private function getEmailContent(string $Email)
    {
        $MatchReplace = new MatchReplace($this->Template->getBody());
        $Authy = \App\AuthyQuery::create()->filterByEmail(\strtolower($Email))->findOne();
        if ($Authy->getValidationKey() == '') {
            $Authy->setValidationKey(createRandomKey(32));
            $Authy->save();
        }
        if ($Authy) {
            $MatchReplace->setDataObj('Authy', $Authy);
            return $MatchReplace->getContent();
        } else {
            return false;
        }
    }

    /**
     * configure PHPmailer and Send the email(s)
     *
     * @param string $subject
     * @param string/array $content
     * @return null or Exception message
     */
    public function sendEmails()
    {
        if ($this->args['data']['email']) {
            $addresses = $this->validEmail($this->args['data']['email']);
        } else {
            $addresses = $this->getAddresses((($this->args['i']) ? $this->args['i'] : $this->args['data']['id_authy']));
        }

        if (is_array($addresses)) {
            $i = 1;
            if (empty($addresses)) {
                $this->addLog("Email address not found", "errors");
                return true;
            }
            foreach ($addresses as $address) {
                // replace Var
                $Body = $this->getEmailContent($address);
                if ($Body) {
                    // set address
                    $this->PHPMailer->addAddress($address);
                    // send email
                    $this->PHPMailer->msgHTML($Body);
                    $this->PHPMailer->Subject = $this->Template->getSubject();

                    if (!$this->PHPMailer->send()) {
                        $this->addLog("Email(s) not sent", "info");
                        $this->addLog($this->PHPMailer->ErrorInfo, "errors");
                        return true;
                    } else {
                        $this->addLog("Email {$i} sent", "info");
                        $this->setStatus('success');
                    }
                }

                $i++;
            }
        } else {
            $this->addLog("Email address not found", "errors");
            return true;
        }

        return false;
    }

    /**
     * Get email addresses from the user table
     *
     * @param integer/array $IdAuthy
     * @return void
     */
    private function getAddresses(int $IdAuthy)
    {
        $Authies = \App\AuthyQuery::create()
            ->select(['Email'])
            ->findPks($IdAuthy);
        if ($Authies) {
            return $Authies->toArray();
        } else {
            return false;
        }
    }


    private function validEmail(string $Email)
    {
        $Authies = \App\AuthyQuery::create()
            ->select(['Email'])
            ->filterByEmail(\strtolower($Email))
            ->find();
        if ($Authies) {
            return $Authies->toArray();
        } else {
            return false;
        }
    }
}
