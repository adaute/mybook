<?php

namespace PaymentBundle\Services;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class Paypal
{

    const URL_SANDBOX = "https://api.sandbox.paypal.com/";
    const URL_LIVE = "https://api.paypal.com/";

    private $clientId;
    private $clientPassword;
    private $mode;
    private $verbose = false;
    private $logDir;
    private $cancelUrl;
    private $returnUrl;
    private $rootDir;

    public function __construct(array $params, $rootDir)
    {
        $this->clientId = $params['client_id'];
        $this->clientPassword = $params['client_password'];
        $this->mode = $params['mode'];
        $this->logDir = $params['log_dir'];
        $this->returnUrl = !empty($params['return_url']) ? $params['return_url'] : null;
        $this->cancelUrl = !empty($params['cancel_url']) ? $params['cancel_url'] : null;
        $this->verbose = $params['verbose_mode'];
        $this->rootDir = $rootDir;
    }

    public function curlAuthentication($url, $params = '', $post = true, $httpHeader = null)
    {

        $logFiles = $this->createLogsFilesIfNotExist();
        $accessFile = $logFiles['access_file'];
        $errorFile = $logFiles['error_file'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, $post);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if ($httpHeader == null && $params != '') {
            curl_setopt($curl, CURLOPT_USERPWD, $this->clientId . ":" . $this->clientPassword);
        }

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($httpHeader != null) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

        if ($this->verbose == true && $this->mode == "sandbox") {
            curl_setopt($curl, CURLOPT_VERBOSE, true);
        }

        $response = curl_exec($curl);


        if (empty($response)) {
            file_put_contents($errorFile, curl_error($curl) . "\n\n", FILE_APPEND);
            curl_close($curl);
        } else {
            $info = curl_getinfo($curl);
            $contentToAccessFile = "Time took: " . $info['total_time'] * 1000 . "ms\n Status :" . $info['http_code'] .
                " Response :" . $response . "\n\n";
            file_put_contents($accessFile, $contentToAccessFile, FILE_APPEND);
            curl_close($curl);
        }

        return json_decode($response, true);
    }

    public function getBaseUrl()
    {
        return $this->mode == "sandbox" ? self::URL_SANDBOX : self::URL_LIVE;
    }

    /**
     * Get Logs files
     * And create it if not exist
     * Return access_file and error_file
     * @return array
     */
    public function createLogsFilesIfNotExist()
    {
        $fs = new Filesystem();

        $exist = $fs->exists($this->rootDir.'/../'.$this->logDir);
        if ($exist == false) {
            try {
                $fs->mkdir($this->rootDir.'/../'.$this->logDir, 0777);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath().'.';
            }
        }
        $logDir     = $this->rootDir.'/../'.$this->logDir;
        $accessFile = $logDir.'/access.log';
        $errorFile  = $logDir.'/error.log';

        if ($fs->exists($accessFile) == false) {
            try {
                $fs->touch($accessFile);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating access file at ".$e->getPath().'.';
            }
        }

        if ($fs->exists($errorFile) == false) {
            try {
                $fs->touch($errorFile);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating error file at ".$e->getPath().'.';
            }
        }

        return [
            'access_file' => $accessFile,
            'error_file'  => $errorFile,
        ];
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return mixed
     */
    public function getClientPassword()
    {
        return $this->clientPassword;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return bool|mixed
     */
    public function getVerbose()
    {
        return $this->verbose;
    }

    /**
     * @return mixed
     */
    public function getLogDir()
    {
        return $this->logDir;
    }

    /**
     * @return mixed|null
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * @return mixed|null
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }
}