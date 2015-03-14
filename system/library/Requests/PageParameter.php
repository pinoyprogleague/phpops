<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Requests {

    /**
     * Description of PageParameter
     *
     * @author Allen
     */
    class PageParameter {

        private static $KEY = 'STATIC_PageParameter';
        private static $KEY_LASTVISITED = 'STATIC_PageParameter_LastVisited';
        public
        /** @var string Parameter's name */
                $name,
                /** @var string Parameter's value */
                $value

        ;

        /**
         * Create a new page parameter
         *
         * @param string $name Parameter's name
         * @param string $value Parameter's value
         */
        public function __construct($name, $value) {
            $this->name = $name;
            $this->value = $value;
        }

        /**
         * Return the name of this parameter
         *
         * @return string
         */
        public function getName() {
            RETURN $this->name;
        }

        /**
         * Return the value of this parameter
         *
         * @return string
         */
        public function getValue() {
            RETURN $this->value;
        }

//------------------------------------------------------------------------------
//  Utilities
//------------------------------------------------------------------------------

        /**
         * Initialize the PageParameter cache
         */
        private static function Initialize() {
            if (!core_session_Contains(self::$KEY) || !core_session_Contains(self::$KEY_LASTVISITED)) {
                self::clearAll();
            }
        }

        /**
         * Get the current PageParameter cache
         *
         * @return array
         */
        private static function __getCacheContent() {
            self::Initialize();
            RETURN core_session_Get(self::$KEY);
        }

        /**
         * Clear or reset the Page parameters cache
         */
        public static function clearAll() {
            core_session_Set(self::$KEY, array());
            core_session_Set(self::$KEY_LASTVISITED, NULL);
        }

        /**
         * Get the `PageParameterCollection` for a page
         *
         * @param string $controllerCallable The callable string of a page controller
         *
         * @return mixed The `PageParameterCollection` for this page, otherwise, FALSE if none found
         */
        public static function getPageParameters($controllerCallable) {
            $cache = self::__getCacheContent();
            RETURN isset($cache[$controllerCallable]) ? $cache[$controllerCallable] : FALSE;
        }

        /**
         * Get the last visited page
         *
         * @return string The callable string of the last page controller
         */
        public static function getLastVisited() {
            self::Initialize();
            RETURN core_session_Get(self::$KEY_LASTVISITED);
        }

        /**
         * Set the last visited page
         *
         * @param string $controllerCallable Callable string of the last page controller
         */
        public static function setLastVisitedPage($controllerCallable) {
            core_session_Set(self::$KEY_LASTVISITED, $controllerCallable);
        }

        /**
         * Set parameters for a page
         *
         * @param string $controllerCallable Callable string of a page controller
         * @param \POPS\Collections\PageParameterCollection $paramCollection A collection of `PageParameter`
         */
        public static function setPageParameter($controllerCallable, \POPS\Collections\PageParameterCollection $paramCollection) {
            $a_cache = self::__getCacheContent();
            $a_cache[$controllerCallable] = $paramCollection;
            core_session_Set(self::$KEY, $a_cache);
        }

    }

}