<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * SAM (Software Asset Management) Core
 *
 * This includes core helpers for Software Asset Management such as but not
 * limited to storage cleanup, public domain files management, etc.
 */


/**
 * Clean all contents of a directory with given clean-up interval and locations
 * of both meta file and lock file
 *
 * @param string    $dirpath Path of target directory
 * @param int       $interval Clean-up interval in X days
 * @param string    $metafile Location of clean-up meta file
 * @param string    $lockfile Location of clean-up lock file
 */
function core_sam_Clean($dirpath, $interval, $metafile, $lockfile) {
    // Check if other instance is already doing the job
    if (!file_exists($lockfile)) {

        // Try to lock for this job
        $locked = file_put_contents($lockfile, "", LOCK_EX);

        if (!$locked) {
            $path = $metafile;
            $today = new DateTime();

            if (file_exists($path)) {
                $lastCleanup = file_get_contents($path);
                if ($lastCleanup !== false) {
                    $last = new DateTime($lastCleanup);
                    $interval = $last->diff($today, true);
                    if ($interval->d >= 1) { // INTERVAL OF 1 DAY CLEANUP
                        // Do the job
                        core_io_DirRemove($dirpath);

                        // Delete the last-cleanup file
                        core_io_FileDelete($path, 10);
                        while (file_put_contents($path, $today->format("Y-m-d H:i:s"), LOCK_EX) === false) {
                            // write the last-cleanup file until success
                        }
                    }
                }
            }
            else {
                // Create the last-cleanup
                while (file_put_contents($path, $today->format("Y-m-d H:i:s"), LOCK_EX) === false) { /** write the last-cleanup file until success */
                }
            }

            // unlock
            core_io_FileDelete($lockfile);
        }
        else {
            // Other instance locked it up and is about to do it
            // Therefore, let that instance blow the job :D
        }
    }

}
