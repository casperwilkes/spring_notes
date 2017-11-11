<?php

/**
 * Purpose:
 *  Handle the site navigation
 * History:
 *  110517 - Lincoln: Created file
 *  111117 - #3 -Lincoln: Added link for api index
 */

namespace Spring_App\Utility;

/**
 * Class Navigation
 * @package Spring_App\Utility
 */
class Navigation {

    /**
     * Name of the project
     * @var string
     */
    private $project = 'Spring Notes';

    /**
     * Collection of site links
     * Set up in setNav
     * @var array
     */
    private $nav = array();

    /**
     * Current url
     * @var string
     */
    private $url = 'index';

    /**
     * Whether user is logged in
     * @var bool
     */
    private $logged_in;

    /**
     * Sets the URL for the navigation system
     * Sets the admin access
     * @param string $url The current url
     * @param bool $logged_in Current login status
     */
    public function __construct($url, $logged_in = false) {
        $this->logged_in = $logged_in;
        $this->setUrl($url);
        $this->setNav();
    }

    /**
     * Gets the project name for the navbar
     * @return string
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Sets up the navigation pane array.
     */
    public function navBar() {
        // Set nav array //
        $nav = array();

        // Check if logged in and set or unset 
        // opposite login/out action //
        if ($this->logged_in) {
            unset($this->nav['logIn']);
        } else {
            unset($this->nav['notes'], $this->nav['logOut']);
        }

        // Loop through nav and find active element //
        foreach ($this->nav as $ref) {
            // Find active reference if any //
            if ($this->url === $ref['link']) {
                $ref['active'] = true;
            } else {
                $ref['active'] = false;
            }

            // Add reference to navbar //
            $nav[] = $ref;
        }

        return $nav;
    }

    /**
     * Gets the visible links in the navigation pane
     * @return array
     */
    public function getNav() {
        return $this->nav;
    }

    /**
     * Sets the main url for nav links
     * @param string $url
     */
    private function setUrl($url) {
        $this->url = basename($url);

        // Highlighting the home tab when user first enters domain //
        if ($this->url === 'public' || $this->url === '') {
            $this->url = 'home';
        }
    }

    /**
     * Sets up the nav links
     */
    private function setNav() {
        $this->nav = array(
            'home' => array(
                'link' => 'home',
                'display' => 'Home',
            ),
            'notes' => array(
                'link' => 'notes',
                'display' => 'Notes',
            ),
            'api' => array(
                'link' => 'api',
                'display' => 'Api',
            ),
            'logOut' => array(
                'link' => 'logout',
                'display' => 'Log Out',
            ),
            'logIn' => array(
                'link' => 'login',
                'display' => 'Log In',
            ),
        );
    }
}
