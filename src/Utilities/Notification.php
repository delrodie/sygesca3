<?php


namespace App\Utilities;


use Clx\Xms\Api\MtBatchBinarySmsCreate;
use Clx\Xms\Api\MtBatchTextSmsCreate;
use Clx\Xms\Client;
use Clx\Xms\ErrorResponseException;
use Clx\Xms\NotFoundException;
use Clx\Xms\UnauthorizedException;

class Notification
{
    public function sms($phone,$message)
    {
        $client = new Client('221c9de9ffe24be8b366bc05d7108c1f', '973cb17d0b3b44418843e0297ff76f93');

        $batchParams = new MtBatchTextSmsCreate();
        $batchParams->setSender('447537404817');
        $batchParams->setRecipients([$phone]);
        $batchParams->setBody($message);

        try {
            $result = $client->createTextBatch($batchParams);
            $var = 'Successfully sent batch ' .$result->getBatchId();
        }catch (NotFoundException $ex) {
            $var = 'Failed to communicate with XMS: ' . $ex->getMessage();
        }

        return $var;
    }
}