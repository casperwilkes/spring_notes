<?php

/**
 * Purpose:
 *  Class to handle setup and parsing of custom templates
 * History:
 *  110517 - Lincoln: Created file
 */

namespace Spring_App\Includes;

use Slim\View;

/**
 * Class to setup custom templates
 * @author Lincoln <jlincoln@clacorp.com>
 */
class CustomView extends View {

    /**
     * The base extension
     * @var string
     */
    private $ext = '.php';

    /**
     * The base template all templates should extend
     * @var string
     */
    private $base_template = '';

    /**
     * Sets the base parent template for all templates
     * @param string $template Name of template without extension
     * @throws \RuntimeException
     */
    public function setBase($template) {
        // Get template path //
        $templatePathname = $this->getTemplatePathname($template . $this->ext);

        // Make sure file exists and we can read it //
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }

        // Set the template //
        $this->base_template = $templatePathname;
    }

    /**
     * Renders the data of the partial template
     * @param string $template Name of the partial
     * @param array $data Data to pass to partial
     * @return string String layout of template data
     * @throws \RuntimeException
     */
    public function render($template, $data = null) {
        // Get partial path //
        $templatePathname = $this->getTemplatePathname($template . $this->ext);

        // Make sure partial exists
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }

        // Merge incoming data and global data //
        $temp_data = array_merge($this->data->all(), (array) $data);

        // Extract data to variables //
        extract($temp_data);

        ob_start();

        require $templatePathname;

        $content = ob_get_clean();

        return $this->renderLayout($content);
    }

    /**
     * Puts partial template into a complete template
     * @param string $content String output from self::render()
     * @return string Returns a string output for parent::display()
     */
    private function renderLayout($content) {
        // Make sure base template is defined //
        if (!is_null($this->base_template)) {
            // Data in the 'global' scope
            $data = $this->data->all();

            // Extract data to variables //
            extract($this->data->all());

            // Set the page title //
            $title = isset($data['title']) ? ' | ' . $data['title'] : '';

            ob_start();

            require $this->base_template;

            return ob_get_clean();
        }
    }

}
