<?php
namespace Framework\Syscrack\Game\Operations;

/**
 * Lewis Lancaster 2017
 *
 * Class Clear
 *
 * @package Framework\Syscrack\Game\Operations
 */

use Framework\Application\Settings;
use Framework\Exceptions\SyscrackException;
use Framework\Syscrack\Game\BaseClasses\Operation as BaseClass;
use Framework\Syscrack\Game\Structures\Operation as Structure;

class Clear extends BaseClass implements Structure
{

    /**
     * Clear constructor.
     */

    public function __construct()
    {

        parent::__construct();
    }

    /**
     * The configuration of this operation
     */

    public function configuration()
    {

        return array(
            'allowsoftwares'    => false,
            'allowlocal'        => true,
            'requireloggedin'   => true
        );
    }

    /**
     * Called when the process is created
     *
     * @param $timecompleted
     *
     * @param $computerid
     *
     * @param $userid
     *
     * @param $process
     *
     * @param array $data
     *
     * @return bool
     */

    public function onCreation($timecompleted, $computerid, $userid, $process, array $data)
    {

        if( $this->checkData( $data, ['ipaddress'] ) == false )
        {

            return false;
        }

        $computer = $this->internet->getComputer( $data['ipaddress'] );

        if( $this->log->hasLog( $computer->computerid ) == false )
        {

            return false;
        }

        if( empty( $this->log->getCurrentLog( $computer->computerid ) ) )
        {

            if( isset( $data['redirect'] ) )
            {

                $this->redirectError('Log is currently empty', $data['redirect'] );
            }

            $this->redirectError('Log is currently empty', $this->getRedirect( $data['ipaddress'] ) );
        }

        return true;
    }

    /**
     * Called when a process is completed
     *
     * @param $timecompleted
     *
     * @param $timestarted
     *
     * @param $computerid
     *
     * @param $userid
     *
     * @param $process
     *
     * @param array $data
     */

    public function onCompletion($timecompleted, $timestarted, $computerid, $userid, $process, array $data)
    {

        if( $this->checkData( $data, ['ipaddress'] ) == false )
        {

            throw new SyscrackException();
        }

        $this->log->saveLog( $this->internet->getComputer( $data['ipaddress'] )->computerid, [] );

        if( isset( $data['redirect'] ) )
        {

            $this->redirectSuccess( $data['redirect'] );
        }
        else
        {

            $this->redirectSuccess( $this->getRedirect( $data['ipaddress'] ) );
        }
    }

    /**
     * gets the time in seconds it takes to complete an action
     *
     * @param $computerid
     *
     * @param $softwareid
     *
     * @param $process
     *
     * @return null
     */

    public function getCompletionSpeed($computerid, $process, $softwareid=null)
    {

        return $this->calculateProcessingTime( $computerid, Settings::getSetting('syscrack_cpu_type'), Settings::getSetting('syscrack_clear_speed'), $softwareid );
    }

    /**
     * Gets the custom data for this operation
     *
     * @param $ipaddress
     *
     * @param $userid
     *
     * @return array
     */

    public function getCustomData($ipaddress, $userid)
    {

        return array();
    }

    /**
     * Called upon a post request to this operation
     *
     * @param $data
     *
     * @param $ipaddress
     *
     * @param $userid
     *
     * @return bool
     */

    public function onPost($data, $ipaddress, $userid)
    {

        return true;
    }
}