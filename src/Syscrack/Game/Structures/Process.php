<?php
namespace Framework\Syscrack\Game\Structures;

/**
 * Lewis Lancaster 2017
 *
 * Interface Process
 *
 * @package Framework\Syscrack\Game\Structures
 */


interface Process
{

    /**
     * Called when a process is created
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

    public function onCreation( $timecompleted, $computerid, $userid, $process, array $data );

    /**
     * Called upon the completion of the task
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

    public function onCompletion( $timecompleted, $timestarted, $computerid, $userid, $process, array $data );

    /**
     * Returns the completeion time for this process
     *
     * @param $computerid
     *
     * @param $ipaddress
     *
     * @param $process
     *
     * @return int
     */

    public function getCompletionTime( $computerid, $ipaddress, $process );
}